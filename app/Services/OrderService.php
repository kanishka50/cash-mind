<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Course;
use App\Models\DigitalProduct;
use App\Models\ProductKey;
use App\Models\UserCourse;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Services\CouponService;
use App\Services\ReferralService;

class OrderService
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Create a new order.
     *
     * @param User $user
     * @param array $cart
     * @param array $data
     * @return Order
     */
    public function createOrder(User $user, array $cart, array $data)
    {
        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $discountAmount = 0;

            // Calculate total amount
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Apply coupon if provided
            $couponId = null;
            if (isset($data['coupon_code']) && !empty($data['coupon_code'])) {
                $couponResult = $this->couponService->validateCoupon($data['coupon_code']);
                
                if ($couponResult['valid']) {
                    $coupon = $couponResult['coupon'];
                    $couponId = $coupon->id;
                    
                    // Calculate discount
                    $couponDetails = $this->couponService->applyCouponToCart($cart, $coupon);
                    $discountAmount = $couponDetails['discount_amount'];
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $totalAmount - $discountAmount,
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'stripe',
                'coupon_id' => $couponId,
                'notes' => $data['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $item['type'],
                    'item_id' => $item['id'],
                    'item_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Increment coupon usage if used
            if ($couponId) {
                $this->couponService->incrementCouponUsage(Coupon::find($couponId));
            }

            DB::commit();
            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a direct purchase order for a single item.
     *
     * @param User $user
     * @param string $itemType
     * @param int $itemId
     * @param array $data
     * @return Order
     */
    public function createDirectPurchaseOrder(User $user, $itemType, $itemId, array $data)
    {
        try {
            DB::beginTransaction();

            // Get the item details
            $item = null;
            $itemName = '';
            $itemPrice = 0;

            if ($itemType === 'course') {
                $item = Course::findOrFail($itemId);
                $itemName = $item->title;
                $itemPrice = $item->price;
                
                // Check if user already has access
                if ($user->hasAccessToCourse($item)) {
                    throw new \Exception('You already have access to this course.');
                }
            } elseif ($itemType === 'digital_product') {
                $item = DigitalProduct::findOrFail($itemId);
                $itemName = $item->name;
                $itemPrice = $item->price;
                
                // Check if product is in stock
                if (!$item->isInStock()) {
                    throw new \Exception('This product is out of stock.');
                }
                
                // Check if user already has access
                if ($user->hasAccessToDigitalProduct($item)) {
                    throw new \Exception('You already have access to this product.');
                }
            }

            // Create a simplified cart for coupon processing
            $cart = [
                "{$itemType}_{$itemId}" => [
                    'id' => $itemId,
                    'type' => $itemType,
                    'name' => $itemName,
                    'price' => $itemPrice,
                    'quantity' => 1
                ]
            ];

            // Apply coupon if provided
            $totalAmount = $itemPrice;
            $discountAmount = 0;
            $couponId = null;
            
            if (isset($data['coupon_code']) && !empty($data['coupon_code'])) {
                $couponResult = $this->couponService->validateCoupon($data['coupon_code']);
                
                if ($couponResult['valid']) {
                    $coupon = $couponResult['coupon'];
                    $couponId = $coupon->id;
                    
                    // Validate coupon for this specific item
                    if ($itemType === 'course') {
                        $isValidForItem = $coupon->courses()->where('courses.id', $itemId)->exists() || 
                                         !$coupon->courses()->exists(); // If no specific courses, valid for all
                    } else {
                        $isValidForItem = $coupon->digitalProducts()->where('digital_products.id', $itemId)->exists() ||
                                         !$coupon->digitalProducts()->exists(); // If no specific products, valid for all
                    }
                    
                    if ($isValidForItem) {
                        // Calculate discount
                        $couponDetails = $this->couponService->applyCouponToCart($cart, $coupon);
                        $discountAmount = $couponDetails['discount_amount'];
                    }
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $totalAmount - $discountAmount,
                'payment_status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'stripe',
                'coupon_id' => $couponId,
                'notes' => $data['notes'] ?? null,
            ]);

            // Create a single order item
            OrderItem::create([
                'order_id' => $order->id,
                'item_type' => $itemType,
                'item_id' => $itemId,
                'item_name' => $itemName,
                'quantity' => 1,
                'price' => $itemPrice,
            ]);

            // Increment coupon usage if used
            if ($couponId) {
                $this->couponService->incrementCouponUsage(Coupon::find($couponId));
            }

            DB::commit();
            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
 * Complete an order after payment.
 *
 * @param Order $order
 * @param string $paymentId
 * @return Order
 */
public function completeOrder(Order $order, $paymentId)
{
    try {
        DB::beginTransaction();

        // Update order status - Use the actual session ID instead of placeholder
        $order->update([
            'payment_status' => 'completed',
            'payment_id' => $paymentId, // This will now be the actual session ID
        ]);

        $user = $order->user;

        // Process order items
        foreach ($order->orderItems as $item) {
            if ($item->item_type === 'course') {
                // Grant access to course
                UserCourse::firstOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $item->item_id,
                    'order_id' => $order->id,
                ]);
            } elseif ($item->item_type === 'digital_product') {
                // Assign product key to user
                $product = DigitalProduct::find($item->item_id);
                $key = $product->availableKeys()->first();
                
                if ($key) {
                    $key->markAsUsed($user->id);
                }
            }
        }

        // Process referral commission if applicable
        app(ReferralService::class)->processCommissionForOrder($order);

        // Send order confirmation email
        $this->sendOrderConfirmationEmail($order);

        DB::commit();
        return $order;

    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
}


    /**
     * Send order confirmation email.
     *
     * @param Order $order
     * @return void
     */
    public function sendOrderConfirmationEmail(Order $order)
    {
        Mail::to($order->user->email)->send(new OrderConfirmation($order));
    }

    /**
     * Get user's recent orders.
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserRecentOrders(User $user, $limit = 5)
    {
        return $user->orders()
            ->with('orderItems')
            ->latest()
            ->limit($limit)
            ->get();
    }
}