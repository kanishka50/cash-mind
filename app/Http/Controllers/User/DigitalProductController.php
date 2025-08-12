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
        $productKeys = User::find(Auth::id())->productKeys()
            ->where('subscription_assigned', false)
            ->with('digitalProduct')
            ->get();
        
        // Initialize empty collection for subscription products
        $subscriptionProducts = collect();
        
        // Get active subscription
        $activeSubscription = User::find(Auth::id())->activeSubscription();
        
        if ($activeSubscription) {
            // Load the subscription plan with its digital products
            $activeSubscription->load('subscriptionPlan.digitalProducts');
            
            // Get all digital products included in the subscription plan
            $subscriptionProducts = $activeSubscription->subscriptionPlan->digitalProducts;
            
            // Debug logging
            Log::info('Loading subscription products for user', [
                'user_id' => $user->id,
                'subscription_id' => $activeSubscription->id,
                'subscription_plan' => $activeSubscription->subscriptionPlan->name,
                'products_count' => $subscriptionProducts->count(),
                'product_names' => $subscriptionProducts->pluck('name')->toArray()
            ]);
        }
        
        // Return with the exact variable names your view expects
        return view('user.digital-products.index', compact(
            'productKeys',           // For purchased products
            'subscriptionProducts',  // For subscription products
            'activeSubscription'     // For showing subscription info
        ));
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
            // User owns this key
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
     * Display subscription product and assign key if needed
     */
    public function showSubscriptionProduct($digitalProductId)
{
    $user = Auth::user();
    $digitalProduct = DigitalProduct::findOrFail($digitalProductId);
    
    // Check if user has access through subscription
    if (!User::find(Auth::id())->hasAccessToDigitalProduct($digitalProduct)) {
        abort(403, 'You do not have access to this product through your subscription.');
    }
    
    // Check if user already has a key assigned
    $productKey = ProductKey::where('digital_product_id', $digitalProduct->id)
        ->where('used_by', $user->id)
        ->where('subscription_assigned', true)
        ->first();
    
    if ($productKey) {
        return view('user.digital-products.subscription-product', [
            'digitalProduct' => $digitalProduct,
            'productKey' => $productKey
        ]);
    }
    
    // No key found - this shouldn't happen if keys are assigned on verification
    return view('user.digital-products.subscription-product', [
        'digitalProduct' => $digitalProduct,
        'noKeysAvailable' => true
    ]);
}
    
    /**
     * Handle subscription product display and key assignment.
     */
    private function handleSubscriptionProduct(DigitalProduct $digitalProduct)
    {
        $user = Auth::user();
        
        try {
            DB::beginTransaction();
            
            // Check if user already has a key for this product
            $existingKey = ProductKey::where('digital_product_id', $digitalProduct->id)
                ->where('used_by', $user->id)
                ->first();
            
            if ($existingKey) {
                // User already has a key
                DB::commit();
                return view('user.digital-products.subscription-product', [
                    'digitalProduct' => $digitalProduct,
                    'productKey' => $existingKey
                ]);
            }
            
            // Try to assign a new key
            $availableKey = ProductKey::where('digital_product_id', $digitalProduct->id)
                ->where('is_used', false)
                ->lockForUpdate()
                ->first();
            
            if ($availableKey) {
                // Use the markAsUsed method from ProductKey model
                $availableKey->markAsUsed($user->id, true); // true for subscription
                
                DB::commit();
                
                Log::info('Assigned subscription product key on-demand', [
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
            
            // No available keys
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
                'error' => 'An error occurred while accessing this product.'
            ]);
        }
    }
}