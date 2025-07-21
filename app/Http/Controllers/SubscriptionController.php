<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionController extends Controller
{
    protected $stripeService;
    
    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }
    
    /**
     * Display a listing of the subscription plans.
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('subscription-plans', compact('subscriptionPlans'));
    }
    
    /**
     * Handle checkout for subscription.
     */
    public function checkout(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $billingCycle = $request->input('billing_cycle', 'monthly');
        
        $amount = $billingCycle === 'yearly' 
            ? $subscriptionPlan->price_yearly 
            : $subscriptionPlan->price_monthly;
        
        // Create Stripe checkout session
        $session = $this->stripeService->createSubscriptionCheckoutSession(
            Auth::user(),
            $subscriptionPlan,
            $billingCycle,
            $amount
        );
        
        return redirect($session->url);
    }

    /**
 * Handle successful subscription payment.
 */
public function handleSuccess(Request $request)
{
    $sessionId = $request->query('session_id');
    
    if (!$sessionId) {
        return redirect()->route('subscription-plans.index')
            ->with('error', 'Invalid payment session.');
    }
    
    try {
        // Process the successful subscription
        $subscription = $this->stripeService->handleSubscriptionSuccess($sessionId);
        
        return redirect()->route('user.subscriptions.index')
            ->with('success', 'Your subscription has been activated successfully!');
            
    } catch (\Exception $e) {
        report($e); // Log the error
        return redirect()->route('subscription-plans.index')
            ->with('error', 'An error occurred while processing your subscription: ' . $e->getMessage());
    }
}

/**
 * Display subscription success page.
 */
/**
 * Display subscription success page.
 */
/**
 * Display subscription success page.
 */
public function success()
{
    // Get the user object using the User model class directly
    $user = \App\Models\User::find(Auth::id());
    
    if (!$user) {
        return redirect()->route('login');
    }
    
    $subscription = $user->activeSubscription();
    
    if (!$subscription) {
        return redirect()->route('subscription-plans.index');
    }
    
    return view('subscription-success', compact('subscription'));
}
}