{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center">
            <a href="{{ route('admin.orders.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Orders
            </a>
            <h3 class="text-xl font-medium text-white">Order: <span class="text-accent-teal">#{{ $order->order_number }}</span></h3>
        </div>
        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-md 
            @if($order->payment_status === 'completed') bg-green-900 bg-opacity-30 text-green-400 
            @elseif($order->payment_status === 'pending') bg-yellow-900 bg-opacity-30 text-yellow-400 
            @elseif($order->payment_status === 'failed') bg-red-900 bg-opacity-30 text-red-400 
            @else bg-gray-700 bg-opacity-30 text-gray-400 @endif">
            {{ ucfirst($order->payment_status) }}
        </span>
    </div>
    
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif

    {{-- Payment Receipt Section (if manual payment) --}}
    @if($order->payment_method === 'bank_transfer' && $order->payment_receipt)
    <div class="mb-6 glass-effect rounded-lg border border-gray-700 p-6">
        <h4 class="text-lg font-medium text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Payment Receipt
        </h4>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="bg-darker rounded-lg p-4 border border-gray-700">
                    @if(pathinfo($order->payment_receipt, PATHINFO_EXTENSION) === 'pdf')
                        <iframe src="{{ route('admin.orders.receipt', $order) }}" class="w-full h-64 rounded"></iframe>
                    @else
                        <img src="{{ route('admin.orders.receipt', $order) }}" alt="Payment Receipt" 
                             class="w-full rounded cursor-pointer" onclick="window.open(this.src, '_blank')">
                    @endif
                </div>
                <div class="mt-2 text-sm text-gray-400">
                    Uploaded: {{ $order->payment_receipt_uploaded_at->format('M d, Y h:i A') }}
                </div>
            </div>
            
            <div>
                @if($order->payment_status === 'pending' && $order->payment_receipt)
                    <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-md p-4 mb-4">
                        <p class="text-yellow-400 font-medium">Payment Verification Required</p>
                        <p class="text-sm text-gray-300 mt-1">Please verify the payment receipt and update the order status.</p>
                    </div>
                    
                    {{-- Quick Verification Actions --}}
                    <div class="space-y-3">
                        <form action="{{ route('admin.payment-verifications.verify-order', $order) }}" method="POST">
                            @csrf
                            <textarea name="admin_notes" rows="2" placeholder="Admin notes (optional)"
                                class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md text-gray-300 mb-2"></textarea>
                            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                                Verify Payment & Complete Order
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.payment-verifications.reject-order', $order) }}" method="POST">
                            @csrf
                            <textarea name="admin_notes" rows="2" placeholder="Rejection reason (required)" required
                                class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md text-gray-300 mb-2"></textarea>
                            <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                                Reject Payment
                            </button>
                        </form>
                    </div>
                @endif
                
                @if($order->payment_verified_by)
                    <div class="bg-darker rounded-md p-4">
                        <p class="text-sm text-gray-400">Verified by:</p>
                        <p class="text-white">{{ $order->verifiedBy->name }}</p>
                        <p class="text-sm text-gray-400 mt-2">Verified at:</p>
                        <p class="text-white">{{ $order->payment_verified_at->format('M d, Y h:i A') }}</p>
                        
                        @if($order->admin_notes)
                            <p class="text-sm text-gray-400 mt-2">Admin notes:</p>
                            <p class="text-gray-300">{{ $order->admin_notes }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="glass-effect rounded-lg border border-gray-700 p-6">
                <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Order Summary
                </h4>
                
                <div class="mb-6 grid grid-cols-2 gap-4">
                    <div class="p-3 bg-card bg-opacity-50 rounded-md">
                        <p class="text-gray-400 text-xs">Order Number</p>
                        <p class="text-white font-mono">#{{ $order->order_number }}</p>
                    </div>
                    <div class="p-3 bg-card bg-opacity-50 rounded-md">
                        <p class="text-gray-400 text-xs">Order Date</p>
                        <p class="text-white">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div class="p-3 bg-card bg-opacity-50 rounded-md">
                        <p class="text-gray-400 text-xs">Payment Method</p>
                        <p class="text-white flex items-center">
                            @if($order->payment_method === 'bank_transfer')
                                <svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Bank Transfer
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </p>
                    </div>
                    <div class="p-3 bg-card bg-opacity-50 rounded-md">
                        <p class="text-gray-400 text-xs">Payment ID</p>
                        <p class="text-white font-mono">{{ $order->payment_id ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <h5 class="text-md font-medium text-white mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Items
                </h5>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Item
                                </th>
                                <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($order->orderItems as $item)
                            <tr class="hover:bg-card hover:bg-opacity-70 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded bg-{{ $item->item_type === 'course' ? 'accent-teal' : 'secondary-400' }} bg-opacity-20 flex items-center justify-center text-{{ $item->item_type === 'course' ? 'accent-teal' : 'secondary-400' }}">
                                            @if($item->item_type === 'course')
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            @else
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-3 text-white font-medium">{{ $item->item_name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($item->item_type === 'course') bg-accent-teal bg-opacity-20 text-accent-teal
                                        @else bg-secondary-400 bg-opacity-20 text-secondary-400 @endif">
                                        {{ ucfirst($item->item_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-300">Rs. {{ number_format($item->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-300">{{ $item->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-white font-medium">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-card bg-opacity-30">
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm font-medium text-gray-400">
                                    Subtotal:
                                </td>
                                <td class="px-6 py-3 text-left text-sm font-medium text-white">
                                    Rs. {{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm font-medium text-gray-400">
                                    Discount:
                                    @if($order->coupon)
                                        <span class="text-green-400">({{ $order->coupon->code }})</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-left text-sm font-medium text-green-400">
                                    -Rs. {{ number_format($order->discount_amount, 2) }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="4" class="px-6 py-3 text-right text-sm font-bold text-gray-300">
                                    Total:
                                </td>
                                <td class="px-6 py-3 text-left text-sm font-bold text-secondary-400">
                                    Rs. {{ number_format($order->final_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                @if($order->notes)
                <div class="mt-6 p-4 border border-gray-700 rounded-md bg-card bg-opacity-30">
                    <h5 class="text-md font-medium text-white mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Order Notes
                    </h5>
                    <p class="text-gray-300">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <div>
            <div class="glass-effect rounded-lg border border-gray-700 p-6 mb-6">
                <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Customer Information
                </h4>
                
                <div class="mb-4 flex items-center">
                    <div class="h-10 w-10 rounded-full bg-secondary-400 bg-opacity-20 flex items-center justify-center text-secondary-400 mr-3">
                        {{ substr($order->user->name, 0, 2) }}
                    </div>
                    <div>
                        <h5 class="text-white font-medium">{{ $order->user->name }}</h5>
                        <p class="text-gray-400 text-sm">{{ $order->user->email }}</p>
                    </div>
                </div>
                
                <div class="bg-card bg-opacity-50 rounded-md p-3 mb-3">
                    <p class="text-gray-400 text-xs">Member Since</p>
                    <p class="text-white flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $order->user->created_at->format('M d, Y') }}
                    </p>
                </div>
                
                <a href="#" class="text-accent-teal hover:text-accent-light text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contact Customer
                </a>
            </div>
            
            <div class="glass-effect rounded-lg border border-gray-700 p-6">
                <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Update Order Status
                </h4>
                
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="payment_status" class="block text-gray-300 text-sm font-medium mb-2">Payment Status</label>
                        <select name="payment_status" id="payment_status" 
                               class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent" 
                               required>
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                        <div class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Status
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection