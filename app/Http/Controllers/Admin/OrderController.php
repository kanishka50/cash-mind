<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    protected $orderService;
    
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');
        
        // Filter by payment status
        if ($request->has('status')) {
            $query->where('payment_status', $request->status);
        }
        
        // Filter for orders with pending receipts
        if ($request->has('pending_receipts')) {
            $query->whereNotNull('payment_receipt')
                  ->where('payment_status', 'pending');
        }
        
        $orders = $query->latest()->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order' => $order->load(['user', 'orderItems', 'coupon'])
        ]);
    }

    /**
     * Update the payment status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded'
        ]);
        
        $order->update([
            'payment_status' => $request->payment_status
        ]);
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully!');
    }
    
    /**
     * Display orders with pending payment verification.
     */
    public function pendingPayments()
    {
        $orders = Order::whereNotNull('payment_receipt')
                      ->where('payment_status', 'pending')
                      ->with('user')
                      ->latest('payment_receipt_uploaded_at')
                      ->paginate(20);
                      
        return view('admin.orders.pending-payments', compact('orders'));
    }
    
    /**
     * Verify payment and complete the order.
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);
        
        try {
            // Update order status
            $order->update([
                'payment_status' => 'completed',
                'payment_verified_by' => Auth::id(),
                'payment_verified_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);
            
            // Complete the order (grant access to courses/products)
            $this->orderService->completeOrder($order, 'manual_payment_' . $order->id);
            
            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Payment verified and order completed successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to verify payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject payment with reason.
     */
    public function rejectPayment(Request $request, Order $order)
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
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Payment rejected. User has been notified.');
    }
    
    /**
     * View payment receipt.
     */
    public function viewReceipt(Order $order)
    {
        if (!$order->payment_receipt) {
            abort(404, 'No payment receipt found.');
        }
        
       $fullPath = Storage::disk('private')->path($order->payment_receipt);
       return response()->file($fullPath);
    }
}