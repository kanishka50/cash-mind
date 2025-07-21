<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CheckoutRequest;
use App\Models\Course;
use App\Models\DigitalProduct;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\ReferralService;



class CheckoutController extends Controller
{
    protected $orderService;
    protected $stripeService;
    
    public function __construct(OrderService $orderService, StripeService $stripeService)
    {
        $this->orderService = $orderService;
        $this->stripeService = $stripeService;
        
        $this->middleware('auth');
    }
    
   /**
 * Display the checkout page.
 */
/**
 * Display the checkout page.
 */
public function index()
{
    $cart = Session::get('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('home')
            ->with('error', 'Your cart is empty. Please select a course or product to purchase.');
    }
    
    // Calculate subtotal
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    // Initialize discount variables
    $discount = 0;
    $couponCode = null;
    $discountDetails = null;
    
    if (Session::has('coupon')) {
        $couponData = Session::get('coupon');
        $couponCode = $couponData['code'];
        $discount = $couponData['discount_amount'];
        
        // Prepare discount details for display
        $discountDetails = [
            'type' => $couponData['discount_type'],
            'value' => $couponData['discount_value'],
            'applicable_items' => $couponData['applicable_items']
        ];
    }
    
    $total = $subtotal - $discount;
    
    // Pass a flag to indicate if this is a single item checkout
    $isSingleItemCheckout = (count($cart) === 1);
    
    return view('checkout', compact(
        'cart', 
        'subtotal', 
        'discount', 
        'total', 
        'couponCode', 
        'isSingleItemCheckout',
        'discountDetails'
    ));
}
    
    /**
     * Add an item to the cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_type' => 'required|in:course,digital_product',
            'product_id' => 'required|integer'
        ]);
        
        $productType = $request->product_type;
        $productId = $request->product_id;
        
        // Get current cart
        $cart = Session::get('cart', []);
        
        // Check if item already exists in cart
        $cartKey = $productType . '_' . $productId;
        
        if (isset($cart[$cartKey])) {
            return redirect()->back()
                ->with('info', 'This item is already in your cart.');
        }
        
        // Get product details
        if ($productType === 'course') {
            $product = Course::find($productId);
            if (!$product) {
                return redirect()->back()
                    ->with('error', 'Course not found.');
            }
            
            // Check if user already purchased this course
            if (User::find(Auth::id())->hasAccessToCourse($product)) {
                return redirect()->back()
                    ->with('error', 'You already have access to this course.');
            }
            
        } else { // digital_product
            $product = DigitalProduct::find($productId);
            if (!$product) {
                return redirect()->back()
                    ->with('error', 'Digital product not found.');
            }
            
            // Check if product is in stock
            if (!$product->isInStock()) {
                return redirect()->back()
                    ->with('error', 'This product is out of stock.');
            }
            
            // Check if user already has this product
            if (User::find(Auth::id())->hasAccessToDigitalProduct($product)) {
                return redirect()->back()
                    ->with('error', 'You already have access to this product.');
            }
        }
        
        // Add to cart
        $cart[$cartKey] = [
            'id' => $productId,
            'type' => $productType,
            'name' => $productType === 'course' ? $product->title : $product->name,
            'price' => $product->price,
            'quantity' => 1
        ];
        
        Session::put('cart', $cart);
        
        return redirect()->route('checkout.index')
            ->with('success', 'Item added to cart successfully.');
    }
    
    /**
     * Remove an item from the cart.
     */
    public function removeFromCart($cartKey)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put('cart', $cart);
            
            return redirect()->route('checkout.index')
                ->with('success', 'Item removed from cart successfully.');
        }
        
        return redirect()->route('checkout.index')
            ->with('error', 'Item not found in cart.');
    }
    
    /**
     * Apply a coupon code.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);
        
        // This will be handled by the VerifyCouponCode middleware
        
        return redirect()->route('checkout.index');
    }
    
    /**
     * Remove applied coupon.
     */
    public function removeCoupon()
    {
        Session::forget('coupon');
        
        return redirect()->route('checkout.index')
            ->with('success', 'Coupon removed successfully.');
    }
    
/**
 * Process the checkout and create an order.
 */
public function process(CheckoutRequest $request)
{
    $cart = Session::get('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('home')
            ->with('error', 'Your cart is empty.');
    }
    
    try {
        // Create order
        $order = $this->orderService->createOrder(
            Auth::user(), 
            $cart, 
            [
                'coupon_code' => Session::has('coupon') ? Session::get('coupon')['code'] : null,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes
            ]
        );
        
        // Note: Removed the commission processing from here as it's called in OrderService::completeOrder
        // This prevents duplicate commission entries
        
        // Create Stripe checkout session
        $session = $this->stripeService->createPaymentCheckoutSession(
            Auth::user(), 
            $order
        );
        
        // Store order ID in session
        Session::put('pending_order_id', $order->id);
        
        // Clear cart and coupon after creating order
        Session::forget(['cart', 'coupon']);
        
        // Redirect to Stripe checkout
        return redirect($session->url);
        
    } catch (\Exception $e) {
        return redirect()->route('checkout.index')
            ->with('error', 'An error occurred during checkout: ' . $e->getMessage());
    }
}
    
    /**
     * Handle successful payment.
     */
    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('home')
                ->with('error', 'Invalid payment session.');
        }
        
        try {
            // Get order ID from session
            $orderId = Session::get('pending_order_id');
            
            if (!$orderId) {
                return redirect()->route('home')
                    ->with('error', 'Order not found.');
            }
            
            $order = Order::find($orderId);
            
            if (!$order) {
                return redirect()->route('home')
                    ->with('error', 'Order not found.');
            }
            
            // Complete the order
            $this->orderService->completeOrder($order, $sessionId);
            
            // Clear pending order from session
            Session::forget('pending_order_id');
            
            return redirect()->route('payment.success')
                ->with([
                    'order' => $order,
                    'order_id' => $order->order_number
                ]);
            
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'An error occurred while processing your payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Display payment success page.
     */
    public function success()
    {
        if (!Session::has('order_id')) {
            return redirect()->route('home');
        }
        
        $orderId = Session::get('order_id');
        $order = Order::where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect()->route('home');
        }
        
        return view('payment-success', compact('order'));
    }


    // In CheckoutController.php, add this new method:
/**
 * Process a direct buy request for a single item.
 */
public function buyNow(Request $request)
{
    $request->validate([
        'product_type' => 'required|in:course,digital_product',
        'product_id' => 'required|integer'
    ]);
    
    $productType = $request->product_type;
    $productId = $request->product_id;
    
    // Clear any existing cart
    Session::forget(['cart', 'coupon']);
    
    // Create a fresh cart with just this one item
    $cart = [];
    
    // Get product details
    if ($productType === 'course') {
        $product = Course::find($productId);
        if (!$product) {
            return redirect()->back()
                ->with('error', 'Course not found.');
        }
        
        // Check if user already purchased this course
        if (User::find(Auth::id())->hasAccessToCourse($product)) {
            return redirect()->back()
                ->with('error', 'You already have access to this course.');
        }
        
    } else { // digital_product
        $product = DigitalProduct::find($productId);
        if (!$product) {
            return redirect()->back()
                ->with('error', 'Digital product not found.');
        }
        
        // Check if product is in stock
        if (!$product->isInStock()) {
            return redirect()->back()
                ->with('error', 'This product is out of stock.');
        }
        
        // Check if user already has this product
        if (User::find(Auth::id())->hasAccessToDigitalProduct($product)) {
            return redirect()->back()
                ->with('error', 'You already have access to this product.');
        }
    }
    
    // Add to cart (single item only)
    $cartKey = $productType . '_' . $productId;
    $cart[$cartKey] = [
        'id' => $productId,
        'type' => $productType,
        'name' => $productType === 'course' ? $product->title : $product->name,
        'price' => $product->price,
        'quantity' => 1
    ];
    
    Session::put('cart', $cart);
    
    return redirect()->route('checkout.index')
        ->with('success', 'Proceeding to checkout.');
}


public function cancel(Request $request)
{
    $orderId = Session::get('pending_order_id');
    
    if ($orderId) {
        $order = Order::find($orderId);
        
        if ($order && $order->payment_status === 'pending') {
            // Delete order items first
            $order->orderItems()->delete();
            
            // Delete the order
            $order->delete();
        }
        
        // Clear the session
        Session::forget('pending_order_id');
    }
    
    return redirect()->route('checkout.index')
        ->with('error', 'Payment was cancelled. Please try again.');
}


}