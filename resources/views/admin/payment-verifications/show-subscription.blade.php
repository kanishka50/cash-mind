{{-- resources/views/admin/payment-verifications/show-subscription.blade.php --}}
@extends('layouts.admin')

@section('title', 'Verify Subscription Payment')

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
                @if(pathinfo($subscription->payment_receipt, PATHINFO_EXTENSION) === 'pdf')
                    <iframe src="{{ route('admin.subscriptions.receipt', $subscription) }}" class="w-full h-96 rounded"></iframe>
                    <a href="{{ route('admin.subscriptions.receipt', $subscription) }}" target="_blank" 
                       class="inline-block mt-4 text-primary-400 hover:text-primary-300">
                        <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open in New Tab
                    </a>
                @else
                    <img src="{{ route('admin.subscriptions.receipt', $subscription) }}" alt="Payment Receipt" 
                         class="w-full rounded cursor-pointer" onclick="window.open(this.src, '_blank')">
                @endif
            </div>
            
            <div class="mt-4 text-sm text-gray-400">
                Uploaded: {{ $subscription->payment_receipt_uploaded_at->format('M d, Y h:i A') }}
            </div>
        </div>

        {{-- Subscription Details --}}
        <div class="bg-card rounded-lg shadow-md p-6 border border-gray-800">
            <h2 class="text-xl font-bold text-gray-100 mb-4">Subscription Details</h2>
            
            <div class="space-y-4">
                {{-- Subscription Info --}}
                <div class="bg-darker rounded-md p-4 border border-gray-700">
                    <h3 class="font-semibold text-gray-200 mb-3">Subscription Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Plan:</span>
                            <span class="text-gray-200 font-medium">{{ $subscription->subscriptionPlan->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Billing Cycle:</span>
                            <span class="text-gray-200">{{ ucfirst($subscription->billing_cycle) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Price:</span>
                            <span class="text-gray-200 font-medium">Rs. {{ number_format($subscription->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Status:</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-900/20 text-yellow-400">
                                {{ ucfirst($subscription->payment_status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Created:</span>
                            <span class="text-gray-200">{{ $subscription->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="bg-darker rounded-md p-4 border border-gray-700">
                    <h3 class="font-semibold text-gray-200 mb-3">Customer Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Name:</span>
                            <span class="text-gray-200">{{ $subscription->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Email:</span>
                            <span class="text-gray-200">{{ $subscription->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Phone:</span>
                            <span class="text-gray-200">{{ $subscription->user->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Current Plan:</span>
                            <span class="text-gray-200">
                                @if($subscription->user->activeSubscription())
                                    {{ $subscription->user->activeSubscription()->subscriptionPlan->name }}
                                    <span class="text-xs text-gray-400">(expires {{ $subscription->user->activeSubscription()->ends_at->format('M d, Y') }})</span>
                                @else
                                    <span class="text-gray-500">No active subscription</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Plan Features --}}
                @if($subscription->subscriptionPlan->features)
                <div class="bg-darker rounded-md p-4 border border-gray-700">
                    <h3 class="font-semibold text-gray-200 mb-3">Plan Features</h3>
                    <ul class="space-y-1">
                        @foreach(json_decode($subscription->subscriptionPlan->features) as $feature)
                        <li class="flex items-start text-gray-300 text-sm">
                            <svg class="w-4 h-4 mr-2 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Subscription Period --}}
                <div class="bg-blue-900/20 border border-blue-500/30 rounded-md p-4">
                    <h3 class="font-semibold text-blue-400 mb-2">Subscription Period (After Activation)</h3>
                    <div class="text-sm text-gray-300">
                        <p>Start: <span class="font-medium">{{ now()->format('M d, Y') }}</span></p>
                        <p>End: <span class="font-medium">
                            @if($subscription->billing_cycle === 'yearly')
                                {{ now()->addYear()->format('M d, Y') }}
                            @else
                                {{ now()->addMonth()->format('M d, Y') }}
                            @endif
                        </span></p>
                        <p class="mt-2 text-xs text-gray-400">
                            The subscription will be activated immediately upon payment verification.
                        </p>
                    </div>
                </div>

                {{-- Action Forms --}}
                <div class="space-y-3">
                    {{-- Verify Form --}}
                    <form action="{{ route('admin.payment-verifications.verify-subscription', $subscription) }}" method="POST">
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
                            Verify Payment & Activate Subscription
                        </button>
                    </form>

                    {{-- Reject Form --}}
                    <form action="{{ route('admin.payment-verifications.reject-subscription', $subscription) }}" method="POST" 
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