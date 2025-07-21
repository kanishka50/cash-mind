@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="container px-4 py-8 mx-auto">
    <div class="max-w-3xl mx-auto">
        <div class="bg-card rounded-lg shadow-md p-8 text-center border border-gray-800">
            <div class="mb-6 flex justify-center">
                <div class="rounded-full bg-green-900/20 p-3 border border-green-500/30">
                    <svg class="h-12 w-12 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <h1 class="text-3xl font-semibold text-gray-100 mb-2">Payment Successful!</h1>
            <p class="text-gray-400 mb-6">Thank you for your purchase. Your order has been processed successfully.</p>
            
            <div class="mb-6 bg-darker rounded-md p-6 text-left border border-gray-800">
                <h2 class="text-lg font-semibold text-gray-100 mb-3">Order Summary</h2>
                
                <div class="grid grid-cols-2 gap-y-2">
                    <p class="text-gray-400">Order Number:</p>
                    <p class="font-medium text-gray-200">{{ $order->order_number }}</p>
                    
                    <p class="text-gray-400">Date:</p>
                    <p class="font-medium text-gray-200">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    
                    <p class="text-gray-400">Total Amount:</p>
                    <p class="font-medium text-primary-400">Rs. {{ number_format($order->final_amount, 2) }}</p>
                    
                    <p class="text-gray-400">Payment Method:</p>
                    <p class="font-medium text-gray-200">{{ ucfirst($order->payment_method) }}</p>
                </div>
            </div>
            
            <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3 justify-center">
                <a href="{{ route('user.orders.show', $order) }}" class="px-6 py-3 bg-primary-500 text-white font-medium rounded hover:bg-primary-600 transition-colors duration-200">
                    View Order Details
                </a>
                <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-gray-700 text-gray-200 font-medium rounded hover:bg-gray-600 transition-colors duration-200">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection