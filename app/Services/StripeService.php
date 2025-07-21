<?php

namespace App\Services;

use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Order;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;

class StripeService
{
    protected $stripe;
    
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.secret_key'));
    }
    
    /**
     * Create a Stripe checkout session for subscription.
     */
    public function createSubscriptionCheckoutSession(User $user, SubscriptionPlan $plan, string $billingCycle, float $amount)
    {
        // Use query parameters instead of path parameters
        $successUrl = route('payment.subscription.success') . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('subscription-plans.index');
        
        try {
            $session = $this->stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'customer_email' => $user->email,
                'client_reference_id' => $user->id,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'lkr',
                            'product_data' => [
                                'name' => $plan->name . ' (' . ucfirst($billingCycle) . ')',
                                'description' => $plan->description,
                            ],
                            'unit_amount' => (int)($amount * 100), // In cents
                            'recurring' => [
                                'interval' => $billingCycle === 'yearly' ? 'year' : 'month',
                                'interval_count' => 1,
                            ],
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'subscription',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'billing_cycle' => $billingCycle,
                ],
            ]);
            
            return $session;
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }
    
    /**
     * Create a single payment checkout session.
     * FIXED: Now properly handles discounts
     */
    public function createPaymentCheckoutSession(User $user, Order $order)
    {
        $successUrl = route('payment.order.success', ['session_id' => '{CHECKOUT_SESSION_ID}']);
        $cancelUrl = route('payment.cancel');
        
        try {
            // Simple solution: Create a single line item with the final amount
            $session = $this->stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'customer_email' => $user->email,
                'client_reference_id' => $order->id,
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'lkr',
                            'product_data' => [
                                'name' => 'Order #' . $order->order_number,
                                'description' => $this->generateOrderDescription($order),
                            ],
                            // USE THE FINAL AMOUNT (after discount) NOT THE ORIGINAL PRICE
                            'unit_amount' => (int)($order->final_amount * 100), // This is the key fix!
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                ],
            ]);
            
            return $session;
        } catch (ApiErrorException $e) {
            report($e);
            throw $e;
        }
    }
    
    /**
     * Generate order description for stripe
     */
    private function generateOrderDescription($order)
    {
        $items = [];
        foreach ($order->orderItems as $item) {
            $items[] = $item->item_name;
        }
        
        $description = implode(', ', $items);
        
        if ($order->discount_amount > 0) {
            $description .= sprintf(
                ' (Original: Rs. %s | Discount: Rs. %s | Final: Rs. %s)',
                number_format($order->total_amount, 2),
                number_format($order->discount_amount, 2),
                number_format($order->final_amount, 2)
            );
        }
        
        return $description;
    }
    
    /**
     * Handle successful subscription payment.
     */
    public function handleSubscriptionSuccess(string $sessionId)
    {
        try {
            $session = $this->stripe->checkout->sessions->retrieve($sessionId, [
                'expand' => ['subscription', 'customer'],
            ]);
            
            if (!$session || !$session->subscription) {
                throw new \Exception('Invalid session or subscription not found.');
            }
            
            $userId = $session->client_reference_id;
            $user = User::find($userId);
            
            if (!$user) {
                throw new \Exception('User not found.');
            }
            
            // Extract plan ID from session metadata
            $planId = $session->metadata->plan_id;
            $billingCycle = $session->metadata->billing_cycle;
            
            // Get the subscription plan
            $plan = SubscriptionPlan::find($planId);
            
            if (!$plan) {
                throw new \Exception('Subscription plan not found.');
            }
            
            // Calculate end date based on billing cycle
            $endsAt = null;
            if ($billingCycle === 'yearly') {
                $endsAt = now()->addYear();
            } elseif ($billingCycle === 'monthly') {
                $endsAt = now()->addMonth();
            }
            
            // Create or update user subscription
            $subscription = UserSubscription::updateOrCreate(
                [
                    'user_id' => $userId,
                    'stripe_subscription_id' => $session->subscription->id
                ],
                [
                    'subscription_plan_id' => $planId,
                    'starts_at' => now(),
                    'ends_at' => $endsAt,
                    'is_active' => true,
                    'payment_status' => 'active',
                    'payment_method' => 'stripe',
                    'billing_cycle' => $billingCycle,
                ]
            );
            
            return $subscription;
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }
    
    /**
     * Cancel a subscription.
     */
    public function cancelSubscription(string $stripeSubscriptionId)
    {
        try {
            return $this->stripe->subscriptions->cancel($stripeSubscriptionId);
        } catch (ApiErrorException $e) {
            report($e);
            throw $e;
        }
    }
}