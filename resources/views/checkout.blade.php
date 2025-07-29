{{-- resources/views/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container px-4 py-8 mx-auto">
    <h1 class="text-2xl font-semibold text-gray-100 text-center">
    @if(count($cart) == 1)
        Complete Your Purchase
    @else
        Checkout
    @endif
    </h1>
    
    @if (session('error'))
    <div class="mt-4 p-4 bg-red-900/30 border border-red-500 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif
    
    @if (session('success'))
    <div class="mt-4 p-4 bg-green-900/30 border border-green-500 text-green-400 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="mt-8 grid gap-8 md:grid-cols-3">
        <!-- Order Summary -->
        <div class="md:col-span-2">
            <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
                <h2 class="text-lg font-semibold mb-4 text-gray-100">
                    @if(count($cart) == 1)
                        Purchase Summary
                    @else
                        Order Summary
                    @endif
                </h2>
                
                @if(empty($cart))
                    <p class="text-gray-400">Your cart is empty.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-800">
                            <thead class="bg-darker">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Item
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-card divide-y divide-gray-800">
                                @foreach($cart as $key => $item)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-200">{{ $item['name'] }}</div>
                                        <div class="text-gray-500 text-sm">{{ ucfirst($item['type']) }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-gray-200">Rs. {{ number_format($item['price'], 2) }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('checkout.remove', $key) }}" class="text-red-400 hover:text-red-300 transition-colors duration-200">Remove</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
            <!-- Coupon Code -->
            <div class="bg-card rounded-lg shadow-md p-6 mt-4 border border-gray-800">
                <h2 class="text-lg font-semibold mb-4 text-gray-100">Discount Code</h2>
                
                @if(session('coupon'))
                    <div class="bg-green-900/20 border border-green-500/50 p-4 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-400">
                                    Coupon "{{ session('coupon')['code'] }}" applied!
                                </h3>
                                <div class="mt-2 text-sm text-green-400">
                                    <p>
                                        @if(session('coupon')['discount_type'] === 'percentage')
                                            {{ session('coupon')['discount_value'] }}% discount applied.
                                        @else
                                            Rs. {{ number_format(session('coupon')['discount_value'], 2) }} discount applied.
                                        @endif
                                    </p>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('checkout.removeCoupon') }}" class="text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors duration-200">
                                        Remove coupon
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form action="{{ route('checkout.applyCoupon') }}" method="POST">
                        @csrf
                        <div class="flex">
                            <input type="text" name="coupon_code" id="coupon_code" placeholder="Enter coupon code" class="flex-1 px-3 py-2 border border-gray-700 bg-gray-800 text-gray-200 rounded-l focus:outline-none focus:ring-2 focus:ring-primary-500 @error('coupon_code') border-red-500 @enderror">
                            <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-r hover:bg-primary-600 transition-colors duration-200">
                                Apply
                            </button>
                        </div>
                        @error('coupon_code')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                @endif
            </div>

            <!-- Bank Transfer Instructions -->
            <div class="bg-card rounded-lg shadow-md p-6 mt-4 border border-gray-800">
                <h2 class="text-lg font-semibold mb-4 text-gray-100">Payment Instructions</h2>
                <div class="bg-blue-900/20 border border-blue-500/30 rounded-md p-4">
                    <p class="text-blue-400 mb-3 font-medium">Bank Transfer Details:</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex">
                            <span class="text-gray-400 w-32">Bank Name:</span>
                            <span class="text-gray-200">{{ env('BANK_NAME', 'Commercial Bank of Ceylon') }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-400 w-32">Account Name:</span>
                            <span class="text-gray-200">{{ env('BANK_ACCOUNT_NAME', 'Cash Mind Pvt Ltd') }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-400 w-32">Account Number:</span>
                            <span class="text-gray-200 font-medium">{{ env('BANK_ACCOUNT_NUMBER', '1234567890') }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-400 w-32">Branch:</span>
                            <span class="text-gray-200">{{ env('BANK_BRANCH', 'Colombo') }}</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mt-3">
                    <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    You will be asked to upload your payment receipt after placing the order.
                </p>
            </div>
        </div>
        
        <!-- Order Total -->
        <div>
            <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
                <h2 class="text-lg font-semibold mb-4 text-gray-100">Order Total</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Subtotal:</span>
                        <span class="text-gray-200">Rs. {{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    @if($discount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-400">Discount:</span>
                        <span class="text-red-400">-Rs. {{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="pt-3 border-t border-gray-700 flex justify-between font-semibold">
                        <span class="text-gray-200">Total:</span>
                        <span class="text-primary-400">Rs. {{ number_format($total, 2) }}</span>
                    </div>
                </div>
                
                @if(!empty($cart))
                <form action="{{ route('checkout.process') }}" method="POST" class="mt-6">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-gray-300 text-sm font-medium mb-2">Order Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-700 bg-gray-800 text-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('notes') }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="terms_accepted" value="1" class="rounded border-gray-700 bg-gray-800 text-primary-500 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 @error('terms_accepted') border-red-500 @enderror" required>
                            <span class="ml-2 text-sm text-gray-300">I accept the <a href="{{ route('terms') }}" class="text-primary-400 hover:text-primary-300 transition-colors duration-200">Terms and Conditions</a></span>
                        </label>
                        @error('terms_accepted')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full py-3 bg-primary-500 text-white font-bold rounded hover:bg-primary-600 transition-colors duration-200">
                        Place Order & Upload Receipt
                    </button>
                </form>
                @else
                <div class="mt-6">
                    <a href="{{ route('courses.index') }}" class="block w-full py-3 text-center bg-primary-500 text-white font-bold rounded hover:bg-primary-600 transition-colors duration-200">
                        Browse Courses
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection