<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProductKey;
use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of the user's digital products.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get individually purchased products (non-subscription keys)
        $purchasedProductKeys = User::find(Auth::id())->productKeys()
            ->where('subscription_assigned', false)
            ->with('digitalProduct')
            ->get();
        
        // Get subscription products if user has active subscription
        $subscriptionProducts = collect();
        $activeSubscription =User::find(Auth::id())->activeSubscription();
        
        if ($activeSubscription) {
            // Get all products included in the subscription plan
            $subscriptionProducts = $activeSubscription->subscriptionPlan->digitalProducts;
        }
        
        return view('user.digital-products.index', [
            'productKeys' => $purchasedProductKeys,
            'subscriptionProducts' => $subscriptionProducts,
            'activeSubscription' => $activeSubscription
        ]);
    }
    
    /**
     * Display the specified digital product details.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Try to fetch as product key first (for individually purchased products)
        $productKey = ProductKey::find($id);
        
        if ($productKey && $productKey->used_by === $user->id) {
            // User owns this key (either purchased or via subscription)
            if ($productKey->subscription_assigned) {
                // This is a subscription-assigned key
                return view('user.digital-products.subscription-product', [
                    'digitalProduct' => $productKey->digitalProduct,
                    'productKey' => $productKey
                ]);
            } else {
                // User purchased this product individually
                return view('user.digital-products.show', compact('productKey'));
            }
        }
        
        // Try to fetch as digital product (for subscription-based products)
        $digitalProduct = DigitalProduct::find($id);
        
        if ($digitalProduct && User::find(Auth::id())->hasAccessToDigitalProduct($digitalProduct)) {
            // User has access through subscription - show or assign key
            return $this->handleSubscriptionProduct($digitalProduct);
        }
        
        // User doesn't have access
        abort(403, 'Unauthorized access to this product.');
    }

    /**
     * Display the specified subscription digital product.
     * This method handles both displaying existing keys and assigning new ones.
     */
    public function showSubscriptionProduct(DigitalProduct $digitalProduct)
    {
        $user = Auth::user();
        
        // Check if user has access through subscription
        if (!User::find(Auth::id())->hasAccessToDigitalProduct($digitalProduct)) {
            abort(403, 'You do not have access to this product through your subscription.');
        }
        
        return $this->handleSubscriptionProduct($digitalProduct);
    }
    
    /**
     * Handle subscription product display and key assignment.
     * 
     * @param DigitalProduct $digitalProduct
     * @return \Illuminate\View\View
     */
    private function handleSubscriptionProduct(DigitalProduct $digitalProduct)
    {
        $user = Auth::user();
        
        try {
            DB::beginTransaction();
            
            // Check if this user already has a key assigned for this product through subscription
            $existingKey = ProductKey::where('digital_product_id', $digitalProduct->id)
                ->where('used_by', $user->id)
                ->where('subscription_assigned', true)
                ->first();
            
            if ($existingKey) {
                // User already has a subscription-assigned key
                DB::commit();
                return view('user.digital-products.subscription-product', [
                    'digitalProduct' => $digitalProduct,
                    'productKey' => $existingKey
                ]);
            }
            
            // Try to assign a new key to this subscriber if there are available keys
            $availableKey = $digitalProduct->productKeys()
                ->where('is_used', false)
                ->lockForUpdate() // Prevent race conditions
                ->first();
            
            if ($availableKey) {
                // Mark the key as used by this subscriber
                $availableKey->markAsUsed($user->id, true); // true = subscription assigned
                
                DB::commit();
                
                // Log the assignment
                Log::info('Assigned subscription product key', [
                    'user_id' => $user->id,
                    'product_id' => $digitalProduct->id,
                    'key_id' => $availableKey->id
                ]);
                
                return view('user.digital-products.subscription-product', [
                    'digitalProduct' => $digitalProduct,
                    'productKey' => $availableKey
                ]);
            }
            
            DB::commit();
            
            // No available keys - show out of stock message
            return view('user.digital-products.subscription-product', [
                'digitalProduct' => $digitalProduct,
                'noKeysAvailable' => true
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling subscription product', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'product_id' => $digitalProduct->id
            ]);
            
            return view('user.digital-products.subscription-product', [
                'digitalProduct' => $digitalProduct,
                'error' => 'An error occurred while accessing this product. Please try again later.'
            ]);
        }
    }
    
    /**
     * Release subscription keys when subscription expires or is cancelled.
     * This should be called from a scheduled task or when subscription status changes.
     * 
     * @param int $userId
     * @return void
     */
    public function releaseSubscriptionKeys($userId)
    {
        try {
            // Find all subscription-assigned keys for this user
            $subscriptionKeys = ProductKey::where('used_by', $userId)
                ->where('subscription_assigned', true)
                ->get();
            
            foreach ($subscriptionKeys as $key) {
                $key->release();
            }
            
            Log::info('Released subscription keys', [
                'user_id' => $userId,
                'keys_released' => $subscriptionKeys->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error releasing subscription keys', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
        }
    }
}


