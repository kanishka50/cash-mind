@extends('layouts.user')

@section('title', 'Manage Subscription')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Manage Subscription
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
        
        <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
            <div class="p-6 border-b border-gray-800">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Current Subscription
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <h3 class="text-md font-medium text-white mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Plan Details
                        </h3>
                        <div class="bg-card p-4 rounded-lg border border-gray-800">
                            <p class="text-gray-300 mb-2"><span class="font-medium text-white">Plan:</span> {{ $activeSubscription->subscriptionPlan->name }}</p>
                            <p class="text-gray-300 mb-2"><span class="font-medium text-white">Description:</span> {{ $activeSubscription->subscriptionPlan->description }}</p>
                            <p class="text-gray-300 mb-2"><span class="font-medium text-white">Billing Cycle:</span> {{ ucfirst($activeSubscription->billing_cycle) }}</p>
                            <p class="text-gray-300"><span class="font-medium text-white">Price:</span> 
                                @if($activeSubscription->billing_cycle === 'monthly')
                                    <span class="text-accent-teal">Rs. {{ number_format($activeSubscription->subscriptionPlan->price_monthly, 2) }}</span>/month
                                @else
                                    <span class="text-accent-teal">Rs. {{ number_format($activeSubscription->subscriptionPlan->price_yearly, 2) }}</span>/year
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-md font-medium text-white mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Subscription Status
                        </h3>
                        <div class="bg-card p-4 rounded-lg border border-gray-800">
                            <p class="text-gray-300 mb-2"><span class="font-medium text-white">Status:</span> 
                                <span class="ml-2 px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-900/20 text-green-400">
                                    Active
                                </span>
                            </p>
                            <p class="text-gray-300 mb-2"><span class="font-medium text-white">Started On:</span> {{ $activeSubscription->starts_at->format('M d, Y') }}</p>
                            @if($activeSubscription->ends_at)
                                <p class="text-gray-300 mb-2"><span class="font-medium text-white">Ends On:</span> {{ $activeSubscription->ends_at->format('M d, Y') }}</p>
                            @else
                                <p class="text-gray-300 mb-2"><span class="font-medium text-white">Next Billing:</span> {{ $activeSubscription->starts_at->addMonth()->format('M d, Y') }}</p>
                            @endif
                            <p class="text-gray-300"><span class="font-medium text-white">Payment Method:</span> {{ ucfirst($activeSubscription->payment_method) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 border-t border-gray-800 pt-6">
                    <h3 class="text-md font-medium text-white mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Subscription Actions
                    </h3>
                    <div>
                        <form action="{{ route('user.subscriptions.cancel') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your subscription? You will lose access to premium content at the end of your current billing period.')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-opacity-80 text-white font-medium rounded-md transition-all duration-300">
                                Cancel Subscription
                            </button>
                        </form>
                        <p class="text-sm text-gray-400 mt-3">
                            * Cancelling your subscription will allow you to use the service until the end of your current billing period.
                        </p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('user.subscriptions.index') }}" class="inline-flex items-center px-4 py-2 bg-card border border-gray-800 text-white rounded-md hover:bg-darker transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Subscriptions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection