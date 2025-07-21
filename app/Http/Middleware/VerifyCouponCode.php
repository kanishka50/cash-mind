<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Services\CouponService;

class VerifyCouponCode
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($request->has('coupon_code') && !empty($request->coupon_code)) {
            $code = $request->coupon_code;
            $cart = $request->session()->get('cart', []);
            
            // Validate coupon with cart items
            $result = $this->couponService->validateCoupon($code, $cart);
            
            if (!$result['valid']) {
                return redirect()->back()->withErrors(['coupon_code' => $result['message']]);
            }

            $coupon = $result['coupon'];
            
            // Apply coupon to cart to get discount details
            $discountDetails = $this->couponService->applyCouponToCart($cart, $coupon);
            
            // Store coupon details in the session
            session()->put('coupon', [
                'code' => $code,
                'coupon_id' => $coupon->id,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->value,
                'discount_amount' => $discountDetails['discount_amount'],
                'applicable_items' => $discountDetails['applicable_items']
            ]);
        }

        return $next($request);
    }
}