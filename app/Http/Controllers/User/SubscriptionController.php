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
     * Display a listing of the subscription plans.
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('subscription-plans', compact('subscriptionPlans'));
    }
    
    /**
     * Handle checkout for subscription (Manual Payment).
     */
    public function checkout(Request $request, SubscriptionPlan $subscriptionPlan)
    {
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
            'payment_status' => 'pending'
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
}