@extends('layouts.app')

@section('title', 'Subscription Plans')

@section('content')
<!-- Page Header -->
<div class="relative py-12 bg-darker">
    <div class="absolute inset-0 bg-gradient-to-r from-accent-teal/20 to-secondary-400/10 opacity-30"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    
    <div class="container px-6 mx-auto relative z-10">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-white">Subscription <span class="text-accent-teal">Plans</span></h1>
        <div class="w-20 h-1 bg-accent-teal mx-auto mt-2"></div>
        <p class="mt-4 text-center text-gray-300 max-w-2xl mx-auto">Choose the subscription plan that best fits your learning journey and financial goals</p>
    </div>
</div>

<div class="container px-6 py-16 mx-auto">
    @if (session('error'))
    <div class="mb-8 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md">
        <div class="flex items-center">
            <svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <div class="mt-8 grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
        @foreach($subscriptionPlans as $plan)
        <div class="flex flex-col h-full bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-800 
            {{ $loop->index == 1 ? 'border-2 border-accent-teal relative lg:transform lg:scale-105 hover:shadow-accent-teal/20' : 'hover:shadow-accent-teal/10' }}">
            
          
            
            <div class="px-6 py-8 {{ $loop->index == 1 ? 'bg-gradient-to-br from-accent-teal/80 to-secondary-400/60 mt-3' : 'bg-darker' }} text-white">
                <h3 class="text-2xl font-bold text-center">{{ $plan->name }}</h3>
                <div class="mt-4 text-center">
                    <span class="text-4xl font-bold {{ $loop->index == 1 ? '' : 'text-accent-teal' }}">Rs. {{ number_format($plan->price_monthly, 2) }}</span>
                    <span class="text-lg {{ $loop->index == 1 ? 'text-gray-200' : 'text-gray-400' }}">/mo</span>
                </div>
                <div class="mt-1 text-center {{ $loop->index == 1 ? 'text-gray-200' : 'text-gray-500' }}">
                    <span>Or Rs. {{ number_format($plan->price_yearly, 2) }}/year</span>
                </div>
            </div>
            
            <div class="p-6 flex-grow">
                <div class="mt-4">
                    <p class="text-gray-300">{{ $plan->description }}</p>
                </div>
                
                <!-- Features list -->
                <div class="mt-6 space-y-3">
                    @if($loop->index == 0)
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Access to 5 basic courses</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Email support</span>
                        </div>
                    @elseif($loop->index == 1)
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Access to all courses</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Full access to premium content</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Priority email support</span>
                        </div>
                    @else
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Access to all courses</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Full access to premium content</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Dedicated support</span>
                        </div>
                        <div class="flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Team access (up to 5 users)</span>
                        </div>
                    @endif
                </div>
            </div>
                
            <div class="p-6 mt-auto">
                @if(auth()->check())
                    <form action="{{ route('subscription-plans.checkout', $plan) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-gray-300 text-sm font-medium mb-2">Billing Cycle</label>
                            <div class="relative">
                                <select name="billing_cycle" 
                                        class="w-full pl-10 pr-10 py-3 border border-gray-700 bg-dark/50 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all duration-300 appearance-none">
                                    <option value="monthly">Monthly - Rs. {{ number_format($plan->price_monthly, 2) }}</option>
                                    <option value="yearly">Yearly - Rs. {{ number_format($plan->price_yearly, 2) }} (Save {{ round((1 - $plan->price_yearly / ($plan->price_monthly * 12)) * 100) }}%)</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3 px-6 {{ $loop->index == 1 
                            ? 'bg-gradient-to-r from-accent-teal to-secondary-400 hover:shadow-lg hover:shadow-accent-teal/30' 
                            : 'bg-accent-teal hover:bg-opacity-80' }} text-white font-medium rounded-md transition-all duration-300 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Subscribe Now
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full py-3 px-6 text-center {{ $loop->index == 1 
                        ? 'bg-gradient-to-r from-accent-teal to-secondary-400 hover:shadow-lg hover:shadow-accent-teal/30' 
                        : 'bg-accent-teal hover:bg-opacity-80' }} text-white font-medium rounded-md transition-all duration-300 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login to Subscribe
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- FAQ Section -->
<div class="py-16 bg-darker">
    <div class="container mx-auto px-6">
        <h2 class="text-2xl font-bold text-center text-white mb-3">Frequently Asked <span class="text-accent-teal">Questions</span></h2>
        <div class="w-20 h-1 bg-accent-teal mx-auto rounded mb-12"></div>
        
        <div class="max-w-3xl mx-auto">
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="glass-effect rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white">What's included in the subscription?</h3>
                    <p class="mt-2 text-gray-300">Each subscription plan gives you access to a specific set of courses, premium content, and support options based on the tier you choose. Higher tiers include more comprehensive access to our complete course library.</p>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="glass-effect rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white">Can I cancel my subscription anytime?</h3>
                    <p class="mt-2 text-gray-300">Yes, you can cancel your subscription at any time. If you cancel, you'll continue to have access until the end of your current billing period, but you won't be charged for the next period.</p>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="glass-effect rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white">Is there a free trial available?</h3>
                    <p class="mt-2 text-gray-300">Currently, we don't offer a free trial, but we do provide free preview videos for most courses so you can assess the content quality before subscribing.</p>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="glass-effect rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-white">How do the yearly plans save money?</h3>
                    <p class="mt-2 text-gray-300">Our yearly plans offer significant savings compared to monthly billing. The exact percentage varies by plan, but you'll typically save between 15-20% by choosing annual billing.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .glass-effect {
        background: rgba(18, 27, 37, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>
@endpush