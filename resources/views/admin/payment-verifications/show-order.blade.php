{{-- resources/views/admin/payment-verifications/show-order.blade.php --}}
@extends('layouts.admin')

@section('title', 'Verify Payment - ' . $order->order_number)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.payment-verifications.index') }}" class="inline-flex items-center text-primary-400 hover:text-primary-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Verifications
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Receipt Display --}}
        <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
            <h2 class="text-xl font-bold text-gray-100 mb-4">Payment Receipt</h2>
            
            <div class="bg-darker rounded-lg p-4 border border-gray-700">
                @if(pathinfo($order->payment_receipt, PATHINFO_EXTENSION) === 'pdf')
                    <iframe src="{{ route('admin.orders.receipt', $order) }}" class="w-full h-96 rounded"></iframe>
                    <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" 
                       class="inline-block mt-4 text-primary-400 hover:text-primary-300">
                        <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open in New Tab
                    </a>
                @else
                    <img src="{{ route('admin.orders.receipt', $order) }}" alt="Payment Receipt" 
                         class="w-full rounded cursor-pointer" onclick="window.open(this.src, '_blank')">
                @endif
            </div>
            
            <div class="mt-4 text-sm text-gray-400">
                Uploaded: {{ $order->payment_receipt_uploaded_at->format('M d, Y h:i A') }}
            </div>
        </div>

        {{-- Order Details --}}
        <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
            <h2 class="text-xl font-bold text-gray-100 mb-4">Order Details</h2>
            
            <div class="space-y-4">
                {{-- Order Info --}}
                <div class="bg-darker rounded-md p-4 border border-gray-700">
                    <h3 class="font-semibold text-gray-200 mb-3">Order Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Order Number:</span>
                            <span class="text-gray-200 font-medium">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Date:</span>
                            <span class="text-gray-200">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Status:</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-900/20 text-yellow-400">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="bg-darker rounded-md p-4 border border-gray-700">
                    <h3 class="font-semibold text-gray-200 mb-3">Customer Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Name:</span>
                            <span class="text-gray-200">{{ $order->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Email:</span>
                            <span class="text-gray-200">{{ $order->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Phone:</span>
                            <span class="text-gray-200">{{ $order->user->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="bg-darker rounded-md p-4 border border-gray-700">
                    <h3 class="font-semibold text-gray-200 mb-3">Order Items</h3>
                    <div class="space-y-2">
                        @foreach($order->orderItems as $item)
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-200 text-sm">{{ $item->item_name }}</p>
                                <p class="text-gray-500 text-xs">{{ ucfirst($item->item_type) }}</p>
                            </div>
                            <span class="text-gray-200 font-medium">Rs. {{ number_format($item->price, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($order->discount_amount > 0)
                    <div class="mt-3 pt-3 border-t border-gray-700">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Subtotal:</span>
                            <span class="text-gray-300">Rs. {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Discount:</span>
                            <span class="text-green-400">-Rs. {{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-3 pt-3 border-t border-gray-700">
                        <div class="flex justify-between">
                            <span class="text-gray-200 font-semibold">Total Amount:</span>
                            <span class="text-xl font-bold text-primary-400">Rs. {{ number_format($order->final_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Action Forms --}}
                <div class="space-y-3">
                    {{-- Verify Form --}}
                    <form action="{{ route('admin.payment-verifications.verify-order', $order) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_notes_verify" class="block text-sm font-medium text-gray-300 mb-1">
                                Admin Notes (Optional)
                            </label>
                            <textarea name="admin_notes" id="admin_notes_verify" rows="2" 
                                class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                placeholder="Add any notes about this verification..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-green-500 text-white font-medium rounded-md hover:bg-green-600 transition-colors duration-200">
                            Verify Payment & Complete Order
                        </button>
                    </form>

                    {{-- Reject Form --}}
                    <form action="{{ route('admin.payment-verifications.reject-order', $order) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to reject this payment?');">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_notes_reject" class="block text-sm font-medium text-gray-300 mb-1">
                                Rejection Reason <span class="text-red-400">*</span>
                            </label>
                            <textarea name="admin_notes" id="admin_notes_reject" rows="2" required
                                class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md text-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="Provide a reason for rejection..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-red-500 text-white font-medium rounded-md hover:bg-red-600 transition-colors duration-200">
                            Reject Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection