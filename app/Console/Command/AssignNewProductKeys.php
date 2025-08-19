<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\ProductKey;
use Illuminate\Support\Facades\DB;

class AssignNewProductKeys extends Command
{
    protected $signature = 'subscription:assign-new-keys {plan_id}';
    protected $description = 'Assign product keys to existing subscribers when new products are added';

    public function handle()
    {
        $planId = $this->argument('plan_id');
        $plan = SubscriptionPlan::find($planId);
        
        if (!$plan) {
            $this->error('Plan not found');
            return;
        }
        
        // Get all active subscriptions for this plan
        $activeSubscriptions = UserSubscription::where('subscription_plan_id', $planId)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->get();
        
        $this->info("Found {$activeSubscriptions->count()} active subscriptions");
        
        // Get all products in the plan
        $products = $plan->digitalProducts;
        
        foreach ($activeSubscriptions as $subscription) {
            foreach ($products as $product) {
                // Check if user already has a key
                $existingKey = ProductKey::where('digital_product_id', $product->id)
                    ->where('used_by', $subscription->user_id)
                    ->first();
                
                if (!$existingKey) {
                    // Assign new key
                    $availableKey = ProductKey::where('digital_product_id', $product->id)
                        ->where('is_used', false)
                        ->first();
                    
                    if ($availableKey) {
                        $availableKey->update([
                            'is_used' => true,
                            'used_by' => $subscription->user_id,
                            'used_at' => now(),
                            'subscription_assigned' => true,
                            'subscription_id' => $subscription->id,
                            'expires_at' => $subscription->ends_at
                        ]);
                        
                        $this->info("Assigned key for product {$product->name} to user {$subscription->user_id}");
                    } else {
                        $this->warn("No keys available for product {$product->name}");
                    }
                }
            }
        }
        
        $this->info('Done!');
    }
}