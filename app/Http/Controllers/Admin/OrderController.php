<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
{
    return view('admin.orders.show', [
        'order' => $order
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
}