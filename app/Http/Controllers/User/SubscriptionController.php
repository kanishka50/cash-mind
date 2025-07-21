<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ProductKey;

class SubscriptionController extends Controller
{
    protected $stripeService;
    
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }
    
    /**
     * Display user's subscriptions.
     */
    public function index()
    {
        $subscriptions =  User::find(Auth::id())->subscriptions()->latest()->get();
        return view('user.subscriptions.index', compact('subscriptions'));
    }
    
    /**
     * Display the subscription management page.
     */
    public function manage()
    {
        $activeSubscription =  User::find(Auth::id())->activeSubscription();
        
        if (!$activeSubscription) {
            return redirect()->route('subscription-plans.index');
        }
        
        return view('user.subscriptions.manage', compact('activeSubscription'));
    }
    
    /**
     * Cancel the user's subscription.
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $subscription =  User::find(Auth::id())->activeSubscription();
        
        if ($subscription && $subscription->stripe_subscription_id) {
            $this->stripeService->cancelSubscription($subscription->stripe_subscription_id);
            
            // Release all subscription-assigned product keys
            ProductKey::where('used_by', $user->id)
                ->where('subscription_assigned', true)
                ->update([
                    'is_used' => false,
                    'used_by' => null,
                    'used_at' => null,
                    'subscription_assigned' => false
                ]);
            
            $subscription->update([
                'is_active' => false,
                'ends_at' => now(),
                'payment_status' => 'canceled'
            ]);
            
            return redirect()->route('user.subscriptions.index')
                ->with('success', 'Your subscription has been canceled. Your access to subscription benefits will end at the end of your billing period.');
        }
        
        return redirect()->route('user.subscriptions.index')
            ->with('error', 'No active subscription found.');
    }
}