<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProductKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DigitalProduct;


class DigitalProductController extends Controller
{
    /**
     * Display a listing of the user's digital products.
     */
   /**
 * Display a listing of the user's digital products.
 */
public function index()
{
    $user = Auth::user();
    
    // Get individually purchased products
    $purchasedProductKeys = User::find(Auth::id())->productKeys()->with('digitalProduct')->get();
    
    // Get subscription products if user has active subscription
    $subscriptionProducts = collect();
    $activeSubscription = User::find(Auth::id())->activeSubscription();
    
    if ($activeSubscription) {
        $subscriptionProducts = $activeSubscription->subscriptionPlan->digitalProducts;
    }
    
    return view('user.digital-products.index', [
        'productKeys' => $purchasedProductKeys,
        'subscriptionProducts' => $subscriptionProducts
    ]);
}
    
    /**
 * Display the specified digital product details.
 */
public function show($id)
{
    // Try to fetch as product key first (for individually purchased products)
    $productKey = ProductKey::find($id);
    
    if ($productKey && $productKey->used_by === Auth::id()) {
        // User purchased this product individually
        return view('user.digital-products.show', compact('productKey'));
    }
    
    // Try to fetch as digital product (for subscription-based products)
    $digitalProduct = DigitalProduct::find($id);
    
    if ($digitalProduct &&  User::find(Auth::id())->hasAccessToDigitalProduct($digitalProduct)) {
        // User has access through subscription
        return view('user.digital-products.subscription-product', compact('digitalProduct'));
    }
    
    // User doesn't have access
    abort(403, 'Unauthorized action.');
}


/**
 * Display the specified subscription digital product.
 */
/**
 * Display the specified subscription digital product.
 */
public function showSubscriptionProduct(DigitalProduct $digitalProduct)
    {
        $user = Auth::user();
        
        // Check if user has access through subscription
        if (! User::find(Auth::id())->hasAccessToDigitalProduct($digitalProduct)) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if this user already has a key assigned for this product through subscription
        $existingKey = ProductKey::where('digital_product_id', $digitalProduct->id)
            ->where('used_by', $user->id)
            ->where('subscription_assigned', true)
            ->first();
        
        if ($existingKey) {
            // User already has a subscription-assigned key
            return view('user.digital-products.subscription-product', [
                'digitalProduct' => $digitalProduct,
                'productKey' => $existingKey
            ]);
        }
        
        // Assign a new key to this subscriber if there are available keys
        $availableKey = $digitalProduct->productKeys()
            ->where('is_used', false)
            ->first();
        
        if ($availableKey) {
            // Mark the key as used by this subscriber and flagged as subscription-assigned
            $availableKey->update([
                'is_used' => true,
                'used_by' => $user->id,
                'used_at' => now(),
                'subscription_assigned' => true
            ]);
            
            return view('user.digital-products.subscription-product', [
                'digitalProduct' => $digitalProduct,
                'productKey' => $availableKey
            ]);
        }
        
        // No available keys - return the view without a key
        return view('user.digital-products.subscription-product', [
            'digitalProduct' => $digitalProduct,
            'noKeysAvailable' => true
        ]);
    }
}