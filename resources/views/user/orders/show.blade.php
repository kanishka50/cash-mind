@extends('layouts.user')

@section('title', 'Order Details')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Order Details
        </h1>
        
        <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
            <a href="{{ route('user.orders.index') }}" class="flex items-center text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Orders
            </a>
            <div>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-medium rounded-full 
                    @if($order->payment_status === 'completed') bg-green-900/20 text-green-400 
                    @elseif($order->payment_status === 'pending') bg-yellow-900/20 text-yellow-400 
                    @elseif($order->payment_status === 'failed') bg-red-900/20 text-red-400 
                    @else bg-gray-800 text-gray-400 @endif">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>
        
        <div class="glass-effect rounded-lg border border-gray-800 overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <h3 class="text-lg font-medium text-white mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Order Information
                        </h3>
                        <div class="grid grid-cols-2 gap-y-3">
                            <p class="text-gray-400">Order Number:</p>
                            <p class="font-medium text-white">{{ $order->order_number }}</p>
                            
                            <p class="text-gray-400">Date:</p>
                            <p class="font-medium text-white">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            
                            <p class="text-gray-400">Payment Method:</p>
                            <p class="font-medium text-white">{{ ucfirst($order->payment_method) }}</p>
                            
                            @if($order->payment_id)
                            <p class="text-gray-400">Payment ID:</p>
                            <p class="font-medium text-white">{{ $order->payment_id }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <h3 class="text-lg font-medium text-white mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Order Summary
                        </h3>
                        <div class="grid grid-cols-2 gap-y-3">
                            <p class="text-gray-400">Subtotal:</p>
                            <p class="font-medium text-white">Rs. {{ number_format($order->total_amount, 2) }}</p>
                            
                            @if($order->discount_amount > 0)
                            <p class="text-gray-400">Discount:</p>
                            <p class="font-medium text-red-400">-Rs. {{ number_format($order->discount_amount, 2) }}</p>
                            
                                @if($order->coupon)
                                <p class="text-gray-400">Coupon:</p>
                                <p class="font-medium text-white">{{ $order->coupon->code }}</p>
                                @endif
                            @endif
                            
                            <p class="text-gray-300 font-bold">Total:</p>
                            <p class="font-bold text-accent-teal">Rs. {{ number_format($order->final_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Order Items
                    </h3>
                    <div class="overflow-x-auto bg-card rounded-lg border border-gray-800">
                        <table class="min-w-full divide-y divide-gray-800">
                            <thead class="bg-darker">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach($order->orderItems as $item)
                                <tr class="hover:bg-darker transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-white">{{ $item->item_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-300">{{ ucfirst($item->item_type) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-300">Rs. {{ number_format($item->price, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-300">{{ $item->quantity }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-accent-teal">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($item->item_type === 'course' && $order->payment_status === 'completed')
                                            <a href="{{ route('user.courses.show', $item->item_id) }}" class="text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">View Course</a>
                                        @elseif($item->item_type === 'digital_product' && $order->payment_status === 'completed')
                                            <a href="{{ route('user.digital-products.index') }}" class="text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">View Product</a>
                                        @else
                                            <span class="text-gray-600">Access Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Order Notes
                    </h3>
                    <div class="bg-card p-5 rounded-lg border border-gray-800">
                        <p class="text-gray-300">{{ $order->notes }}</p>
                    </div>
                </div>
                @endif
                
                @if($order->payment_status === 'failed')
                <div class="mt-8 text-center bg-red-900/20 p-6 rounded-lg border border-red-900/40">
                    <p class="text-red-400 mb-5 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Your payment has failed. Please contact support or try again.
                    </p>
                    <a href="{{ route('checkout.index') }}" class="inline-flex items-center px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Try Again
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection