<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserSubscription;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\PaymentReceiptService;

class PaymentVerificationController extends Controller
{
    protected $orderService;
    
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    /**
     * Display all pending payment verifications.
     */
    public function index(Request $request)
    {
        // Get pending orders
        $ordersQuery = Order::whereNotNull('payment_receipt')
                           ->where('payment_status', 'pending')
                           ->with('user');
                           
        // Get pending subscriptions
        $subscriptionsQuery = UserSubscription::whereNotNull('payment_receipt')
                                             ->where('payment_status', 'pending')
                                             ->with(['user', 'subscriptionPlan']);
        
        // Apply date filter if provided
        if ($request->has('date_from')) {
            $dateFrom = Carbon::parse($request->date_from)->startOfDay();
            $ordersQuery->where('payment_receipt_uploaded_at', '>=', $dateFrom);
            $subscriptionsQuery->where('payment_receipt_uploaded_at', '>=', $dateFrom);
        }
        
        if ($request->has('date_to')) {
            $dateTo = Carbon::parse($request->date_to)->endOfDay();
            $ordersQuery->where('payment_receipt_uploaded_at', '<=', $dateTo);
            $subscriptionsQuery->where('payment_receipt_uploaded_at', '<=', $dateTo);
        }
        
        $orders = $ordersQuery->latest('payment_receipt_uploaded_at')->get();
        $subscriptions = $subscriptionsQuery->latest('payment_receipt_uploaded_at')->get();
        
        // Combine and sort by upload date
        $pendingPayments = collect()
            ->merge($orders->map(function($order) {
                $order->type = 'order';
                return $order;
            }))
            ->merge($subscriptions->map(function($subscription) {
                $subscription->type = 'subscription';
                return $subscription;
            }))
            ->sortByDesc('payment_receipt_uploaded_at');
        
        return view('admin.payment-verifications.index', compact('pendingPayments'));
    }
    
    /**
     * Show payment verification details for an order.
     */
    public function showOrder(Order $order)
    {
        if (!$order->payment_receipt) {
            return redirect()->route('admin.payment-verifications.index')
                ->with('error', 'No payment receipt found for this order.');
        }
        
        return view('admin.payment-verifications.show-order', compact('order'));
    }
    
    /**
     * Show payment verification details for a subscription.
     */
    public function showSubscription(UserSubscription $subscription)
    {
        if (!$subscription->payment_receipt) {
            return redirect()->route('admin.payment-verifications.index')
                ->with('error', 'No payment receipt found for this subscription.');
        }
        
        return view('admin.payment-verifications.show-subscription', compact('subscription'));
    }
    
    /**
     * Verify order payment.
     */
    public function verifyOrder(Request $request, Order $order)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);
        
        try {
            // Update order
            $order->update([
                'payment_status' => 'completed',
                'payment_verified_by' => Auth::id(),
                'payment_verified_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);
            
            // Complete the order
            $this->orderService->completeOrder($order, 'manual_payment_' . $order->id);
            
            return redirect()->route('admin.payment-verifications.index')
                ->with('success', 'Order payment verified successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to verify payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Verify subscription payment.
     */
    public function verifySubscription(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);
        
        try {
            // Calculate subscription dates
            $startsAt = now();
            $endsAt = $subscription->billing_cycle === 'yearly' 
                ? $startsAt->copy()->addYear() 
                : $startsAt->copy()->addMonth();
            
            // Update subscription
            $subscription->update([
                'payment_status' => 'completed',
                'payment_verified_by' => Auth::id(),
                'payment_verified_at' => now(),
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'is_active' => true,
                'admin_notes' => $request->admin_notes
            ]);
            
            return redirect()->route('admin.payment-verifications.index')
                ->with('success', 'Subscription payment verified successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to verify payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject order payment.
     */
    public function rejectOrder(Request $request, Order $order)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);
        
        $order->update([
            'payment_status' => 'failed',
            'payment_verified_by' => Auth::id(),
            'payment_verified_at' => now(),
            'admin_notes' => $request->admin_notes
        ]);
        
        return redirect()->route('admin.payment-verifications.index')
            ->with('success', 'Order payment rejected.');
    }
    
    /**
     * Reject subscription payment.
     */
    public function rejectSubscription(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500'
        ]);
        
        $subscription->update([
            'payment_status' => 'failed',
            'payment_verified_by' => Auth::id(),
            'payment_verified_at' => now(),
            'admin_notes' => $request->admin_notes
        ]);
        
        return redirect()->route('admin.payment-verifications.index')
            ->with('success', 'Subscription payment rejected.');
    }
    
    /**
     * View payment receipt for order.
     */
    public function viewOrderReceipt(Order $order)
{
    if (!$order->payment_receipt) {
        abort(404, 'No payment receipt found.');
    }

    $fullPath = Storage::disk('private')->path($order->payment_receipt);
    return response()->file($fullPath);
}

public function viewSubscriptionReceipt(UserSubscription $subscription)
{
    if (!$subscription->payment_receipt) {
        abort(404, 'No payment receipt found.');
    }

    $fullPath = Storage::disk('private')->path($subscription->payment_receipt);
    return response()->file($fullPath);
}
}