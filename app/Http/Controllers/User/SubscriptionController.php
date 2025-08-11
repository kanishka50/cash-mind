<?php

namespace App\Http\Controllers\User;

use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log as LogFacade;

class SubscriptionController extends Controller
{
    /**
     * Display USER'S SUBSCRIPTIONS - NOT ALL PLANS!
     * This should show the user's subscription history and current status
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all of this user's subscriptions (both active and inactive)
        $subscriptions = UserSubscription::where('user_id', $user->id)
            ->with('subscriptionPlan')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Return the USER subscription index view, not the plans view
        return view('user.subscriptions.index', compact('subscriptions'));
    }
    
    /**
     * Display the manage subscription page.
     * This shows details of the active subscription and allows cancellation.
     */
    public function manage()
    {
        $user = Auth::user();
        $activeSubscription = User::find(Auth::id())->activeSubscription();
        
        if (!$activeSubscription) {
            return redirect()->route('user.subscriptions.index')
                ->with('info', 'You do not have an active subscription.');
        }
        
        // Load related data
        $activeSubscription->load(['subscriptionPlan.courses', 'subscriptionPlan.digitalProducts']);
        
        return view('user.subscriptions.manage', compact('activeSubscription'));
    }
    
    /**
     * Cancel the active subscription.
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $activeSubscription = User::find(Auth::id())->activeSubscription();
        
        if (!$activeSubscription) {
            return redirect()->route('user.subscriptions.index')
                ->with('error', 'No active subscription found.');
        }
        
        try {
            // Just mark as inactive - subscription continues until end date
            // No need for extra fields, just set is_active to false
            $activeSubscription->update([
                'is_active' => false,
                'admin_notes' => 'User cancelled subscription on ' . now()->format('Y-m-d H:i:s')
            ]);
            
            LogFacade::info('Subscription cancelled', [
                'user_id' => $user->id,
                'subscription_id' => $activeSubscription->id
            ]);
            
            return redirect()->route('user.subscriptions.index')
                ->with('success', 'Your subscription has been cancelled. You will continue to have access until ' . 
                       $activeSubscription->ends_at->format('M d, Y') . '.');
                       
        } catch (\Exception $e) {
            LogFacade::error('Error cancelling subscription', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to cancel subscription. Please try again.');
        }
    }
    
    /**
     * Handle checkout for subscription (Manual Payment).
     */
    public function checkout(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $user = Auth::user();
        
        // Check if user already has an active subscription
        if (User::find(Auth::id())->hasActiveSubscription()) {
            return redirect()->route('user.subscriptions.manage')
                ->with('info', 'You already have an active subscription. Please cancel it first to subscribe to a new plan.');
        }
        
        $billingCycle = $request->input('billing_cycle', 'monthly');
        
        $amount = $billingCycle === 'yearly' 
            ? $subscriptionPlan->price_yearly 
            : $subscriptionPlan->price_monthly;
        
        // Create pending subscription
        $subscription = UserSubscription::create([
            'user_id' => Auth::id(),
            'subscription_plan_id' => $subscriptionPlan->id,
            'billing_cycle' => $billingCycle,
            'price' => $amount,
            'starts_at' => null, // Will be set when payment is verified
            'ends_at' => null, // Will be set when payment is verified
            'is_active' => false,
            'payment_status' => 'pending',
            'payment_method' => 'bank_transfer'
        ]);
        
        // Store subscription ID in session
        Session::put('pending_subscription_id', $subscription->id);
        
        // Redirect to payment receipt upload
        return redirect()->route('subscription.payment.upload', $subscription->id);
    }
    
    /**
     * Display subscription payment receipt upload page.
     */
    public function showPaymentReceipt(UserSubscription $subscription)
    {
        // Check if the subscription belongs to the current user
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        // Check if payment is already completed
        if ($subscription->is_active && $subscription->payment_status === 'completed') {
            return redirect()->route('user.subscriptions.index')
                ->with('info', 'Payment for this subscription has already been completed.');
        }
        
        return view('subscription-payment-upload', compact('subscription'));
    }
    
    /**
     * Handle subscription payment receipt upload.
     */
    public function uploadPaymentReceipt(Request $request, UserSubscription $subscription)
    {
        LogFacade::info('Uploading payment receipt for subscription', [
            'subscription_id' => $subscription->id,
            'user_id' => Auth::id()
        ]);

        // Check if the subscription belongs to the current user
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        // Validate the upload
        $request->validate([
            'payment_receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);
        
        try {
            // Store the receipt
            $path = $request->file('payment_receipt')->store('subscription_receipts/' . date('Y/m'), 'private');
            
            // Update the subscription
            $subscription->update([
                'payment_receipt' => $path,
                'payment_receipt_uploaded_at' => now()
            ]);
            
            // Clear pending subscription from session
            Session::forget('pending_subscription_id');
            
            return redirect()->route('user.subscriptions.index')
                ->with('success', 'Payment receipt uploaded successfully. Please wait for admin verification.');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload payment receipt: ' . $e->getMessage());
        }
    }
    
    /**
     * Display subscription success page.
     */
    public function success()
    {
        $user = User::find(Auth::id());
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $subscription = $user->activeSubscription();
        
        if (!$subscription) {
            return redirect()->route('subscription-plans.index');
        }
        
        return view('subscription-success', compact('subscription'));
    }
    
    /**
     * View subscription receipt/invoice.
     */
    public function viewReceipt(UserSubscription $subscription)
    {
        // Check if the subscription belongs to the current user
        if ($subscription->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        // You can create a receipt view or just redirect to orders
        return redirect()->route('user.subscriptions.index')
            ->with('info', 'Receipt viewing will be implemented soon.');
    }
}