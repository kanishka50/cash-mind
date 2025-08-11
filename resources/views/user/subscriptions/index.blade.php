@extends('layouts.user')

@section('title', 'My Subscriptions')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            My Subscriptions
        </h1>
        
        @if (session('success'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        @if (session('error'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if (session('info'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-blue-500 text-blue-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
        @endif
        
        <div class="mt-6">
            @if($subscriptions->isEmpty())
                <div class="glass-effect rounded-lg p-10 text-center border border-gray-800">
                    <svg class="h-16 w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No Subscriptions</h3>
                    <p class="text-gray-400 mb-6">You don't have any subscriptions yet.</p>
                    <a href="{{ route('subscription-plans.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                        Browse Subscription Plans
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            @else
                {{-- Check for pending subscriptions --}}
                @php
                    $pendingSubscriptions = $subscriptions->where('payment_status', 'pending');
                    $activeSubscriptions = $subscriptions->where('is_active', true)->where('payment_status', 'completed');
                    $completedSubscriptions = $subscriptions->where('payment_status', 'completed');
                @endphp

                {{-- Show pending payment verification notice --}}
                @if($pendingSubscriptions->count() > 0)
                <div class="mb-6 glass-effect rounded-lg p-6 border border-yellow-500/30">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-yellow-400 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-yellow-400 mb-2">Payment Verification Pending</h3>
                            <p class="text-gray-300">You have {{ $pendingSubscriptions->count() }} subscription(s) awaiting payment verification. Your subscription will be activated once our admin team verifies your payment receipt.</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Active Subscription Display --}}
                @if($activeSubscriptions->count() > 0)
                @foreach($activeSubscriptions as $subscription)
                <div class="mb-6 glass-effect rounded-lg p-6 border border-green-500/30">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <h3 class="text-xl font-semibold text-white">{{ $subscription->subscriptionPlan->name }}</h3>
                                <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-green-900/20 text-green-400">Active</span>
                            </div>
                            <p class="text-gray-400 mb-3">{{ $subscription->subscriptionPlan->description }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Billing Cycle:</span>
                                    <span class="ml-2 text-gray-300">{{ ucfirst($subscription->billing_cycle) }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Started:</span>
                                    <span class="ml-2 text-gray-300">{{ $subscription->starts_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Expires:</span>
                                    <span class="ml-2 text-gray-300">{{ $subscription->ends_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('user.subscriptions.manage') }}" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                            Manage
                        </a>
                    </div>
                </div>
                @endforeach
                @endif

                {{-- Subscription History Table --}}
                <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
                    <div class="p-6 border-b border-gray-800">
                        <h2 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            All Subscriptions
                        </h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-800">
                            <thead class="bg-card">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Plan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Payment
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Billing Cycle
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        End Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach($subscriptions as $subscription)
                                <tr class="bg-darker hover:bg-card transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-white">{{ $subscription->subscriptionPlan->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($subscription->payment_status === 'pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-900/20 text-yellow-400">
                                                Pending Verification
                                            </span>
                                        @elseif($subscription->is_active && $subscription->ends_at && $subscription->ends_at->isFuture())
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-900/20 text-green-400">
                                                Active
                                            </span>
                                        @elseif($subscription->is_active && (!$subscription->ends_at || $subscription->ends_at->isFuture()))
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-900/20 text-green-400">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-red-900/20 text-red-400">
                                                @if($subscription->ends_at && $subscription->ends_at->isPast())
                                                    Expired
                                                @else
                                                    Inactive
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($subscription->payment_status === 'pending')
                                            <span class="text-yellow-400 text-sm">Awaiting Verification</span>
                                        @elseif($subscription->payment_status === 'completed')
                                            <span class="text-green-400 text-sm">Verified</span>
                                        @else
                                            <span class="text-gray-400 text-sm">{{ ucfirst($subscription->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-300">{{ ucfirst($subscription->billing_cycle) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-300">
                                            @if($subscription->starts_at)
                                                {{ $subscription->starts_at->format('M d, Y') }}
                                            @else
                                                <span class="text-gray-500 italic">Pending</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-300">
                                            @if($subscription->ends_at)
                                                {{ $subscription->ends_at->format('M d, Y') }}
                                            @elseif($subscription->starts_at)
                                                Auto-renew
                                            @else
                                                <span class="text-gray-500 italic">Pending</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($subscription->is_active && $subscription->payment_status === 'completed')
                                            <a href="{{ route('user.subscriptions.manage') }}" class="text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                                                Manage
                                            </a>
                                        @elseif($subscription->payment_status === 'pending')
                                            @if($subscription->payment_receipt)
                                                <span class="text-yellow-400 text-xs">Receipt Uploaded</span>
                                            @else
                                                <a href="{{ route('subscription.payment.upload', $subscription) }}" class="text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                                                    Upload Receipt
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Browse Plans Button --}}
                @if(!$activeSubscriptions->count())
                <div class="mt-8 text-center">
                    <p class="text-gray-400 mb-4">Ready to unlock premium content?</p>
                    <a href="{{ route('subscription-plans.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Browse Subscription Plans
                    </a>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection