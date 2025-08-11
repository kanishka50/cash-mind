<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\DigitalProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log as LogFacade;

class CouponService
{
    /**
     * Validate a coupon code.
     *
     * @param string $code
     * @param array $cartItems
     * @return array
     */
    public function validateCoupon($code, $cartItems = [])
    {
        LogFacade::info("Validating coupon code: $code", ['cartItems' => $cartItems]);
        // Find the coupon with relationships
        $coupon = Coupon::with(['courses', 'digitalProducts'])
            ->where('code', $code)
            ->first();

        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Invalid coupon code. Please try again.'
            ];
        }

        // Check if coupon is valid
        if (!$coupon->isValid()) {
            return [
                'valid' => false,
                'message' => 'This coupon is no longer valid.'
            ];
        }

        // If cart items provided, check applicability
        if (!empty($cartItems)) {
            $applicable = false;
            
            foreach ($cartItems as $item) {
                if ($item['type'] === 'course' && $coupon->courses->contains('id', $item['id'])) {
                    $applicable = true;
                    break;
                }
                
                if ($item['type'] === 'digital_product' && $coupon->digitalProducts->contains('id', $item['id'])) {
                    $applicable = true;
                    break;
                }
            }
            
            // If coupon has no restrictions, it applies to all
            if (!$applicable && $coupon->courses->isEmpty() && $coupon->digitalProducts->isEmpty()) {
                $applicable = true;
            }
            
            if (!$applicable) {
                return [
                    'valid' => false,
                    'message' => 'This coupon does not apply to any items in your cart.'
                ];
            }
        }

        return [
            'valid' => true,
            'coupon' => $coupon,
            'message' => 'Coupon applied successfully!'
        ];
    }

    /**
     * Apply coupon to a cart.
     *
     * @param array $cart
     * @param Coupon $coupon
     * @return array
     */
    public function applyCouponToCart($cart, Coupon $coupon)
    {
        $totalBeforeDiscount = $this->calculateCartTotal($cart);
        $applicableItems = [];
        $applicableTotal = 0;

        // Check if coupon has specific items
        $hasCourseRestrictions = $coupon->courses->count() > 0;
        $hasProductRestrictions = $coupon->digitalProducts->count() > 0;

        // If coupon has restrictions, apply only to applicable items
        if ($hasCourseRestrictions || $hasProductRestrictions) {
            foreach ($cart as $key => $item) {
                if ($item['type'] === 'course' && $hasCourseRestrictions) {
                    if ($coupon->courses->contains('id', $item['id'])) {
                        $applicableItems[] = $key;
                        $applicableTotal += $item['price'] * $item['quantity'];
                    }
                } elseif ($item['type'] === 'digital_product' && $hasProductRestrictions) {
                    if ($coupon->digitalProducts->contains('id', $item['id'])) {
                        $applicableItems[] = $key;
                        $applicableTotal += $item['price'] * $item['quantity'];
                    }
                }
            }
        } else {
            // If no restrictions, apply to all items
            $applicableTotal = $totalBeforeDiscount;
            $applicableItems = array_keys($cart);
        }

        // Calculate discount
        $discountAmount = 0;
        if ($applicableTotal > 0) {
            $discountAmount = $coupon->type === 'percentage' 
                ? ($applicableTotal * $coupon->value / 100)
                : min($coupon->value, $applicableTotal);
        }

        return [
            'total_before_discount' => $totalBeforeDiscount,
            'applicable_total' => $applicableTotal,
            'discount_amount' => $discountAmount,
            'final_total' => $totalBeforeDiscount - $discountAmount,
            'applicable_items' => $applicableItems
        ];
    }

    /**
     * Calculate cart total.
     *
     * @param array $cart
     * @return float
     */
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Increment coupon usage.
     *
     * @param Coupon $coupon
     * @return void
     */
    public function incrementCouponUsage(Coupon $coupon)
    {
        $coupon->increment('times_used');
    }
}