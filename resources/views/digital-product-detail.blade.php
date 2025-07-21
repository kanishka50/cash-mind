@extends('layouts.app')

@section('title', $digitalProduct->name)

@section('content')
<div class="container px-6 py-8 mx-auto">
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-accent-teal transition-colors duration-200">Home</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('digital-products.index') }}" class="hover:text-accent-teal transition-colors duration-200">Digital Products</a>
        <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-300">{{ $digitalProduct->name }}</span>
    </div>

    <!-- Product Details Card -->
    <div class="glass-effect rounded-xl overflow-hidden border border-gray-700 shadow-lg">
        <!-- Header with badge -->
        <div class="p-6 border-b border-gray-700 relative">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $digitalProduct->name }}</h1>
                    <div class="flex items-center space-x-3">
                        <div class="px-3 py-1 bg-primary-400 bg-opacity-20 rounded-full border border-primary-400 border-opacity-30 text-sm text-primary-400">
                            @if($digitalProduct->type === 'license_key')
                                License Key
                            @elseif($digitalProduct->type === 'account_credentials')
                                Account Credentials
                            @else
                                Digital Asset
                            @endif
                        </div>
                        <div class="px-3 py-1 rounded-full text-sm {{ $digitalProduct->isInStock() ? 'bg-green-900/20 border border-green-500/30 text-green-400' : 'bg-red-900/20 border border-red-500/30 text-red-400' }}">
                            {{ $digitalProduct->isInStock() ? 'In Stock' : 'Out of Stock' }}
                        </div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-primary-400">
                    Rs. {{ number_format($digitalProduct->price, 2) }}
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left: Product Description -->
            <div class="md:col-span-2">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        About This Product
                    </h2>
                    <div class="p-4 bg-darker rounded-lg border border-gray-700">
                        <p class="text-gray-300 whitespace-pre-line leading-relaxed">{{ $digitalProduct->description }}</p>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-xl font-semibold text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Key Features
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-darker rounded-lg border border-gray-700">
                            <h3 class="text-secondary-400 font-medium mb-2">Instant Delivery</h3>
                            <p class="text-gray-400 text-sm">Receive your digital product immediately after purchase</p>
                        </div>
                        
                        <div class="p-4 bg-darker rounded-lg border border-gray-700">
                            <h3 class="text-secondary-400 font-medium mb-2">Secure Access</h3>
                            <p class="text-gray-400 text-sm">Your {{ strtolower($digitalProduct->type === 'license_key' ? 'license key' : ($digitalProduct->type === 'account_credentials' ? 'credentials' : 'digital asset')) }} is securely stored in your account</p>
                        </div>
                        
                        @if($digitalProduct->type === 'license_key')
                        <div class="p-4 bg-darker rounded-lg border border-gray-700">
                            <h3 class="text-secondary-400 font-medium mb-2">Official License</h3>
                            <p class="text-gray-400 text-sm">100% authentic and legitimate product key</p>
                        </div>
                        @endif
                        
                        @if($digitalProduct->type === 'account_credentials')
                        <div class="p-4 bg-darker rounded-lg border border-gray-700">
                            <h3 class="text-secondary-400 font-medium mb-2">Account Access</h3>
                            <p class="text-gray-400 text-sm">Immediate login details for the service</p>
                        </div>
                        @endif
                        
                        <div class="p-4 bg-darker rounded-lg border border-gray-700">
                            <h3 class="text-secondary-400 font-medium mb-2">Customer Support</h3>
                            <p class="text-gray-400 text-sm">Assistance available if you encounter any issues</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right: Purchase Options -->
            <div class="md:border-l md:border-gray-700 md:pl-8">
                <div class="gradient-border mb-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-white">Purchase Options</h3>
                            <svg class="h-6 w-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-darker rounded-lg border border-gray-700 p-4">
                                <div class="flex justify-between items-center text-lg mb-1">
                                    <span class="text-white">Price:</span>
                                    <span class="text-primary-400 font-bold">Rs. {{ number_format($digitalProduct->price, 2) }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mb-2">One-time purchase, instant access</div>
                            </div>
                            
                            @auth
                                @if(auth()->user()->hasAccessToDigitalProduct($digitalProduct))
                                    <!-- User has access -->
                                    <div class="bg-green-900/20 border border-green-500/30 p-4 rounded-md">
                                        <p class="text-green-400 font-medium flex items-center">
                                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            You already own this product
                                        </p>
                                        
                                        @if(auth()->user()->activeSubscription() && auth()->user()->activeSubscription()->subscriptionPlan->digitalProducts()->where('digital_products.id', $digitalProduct->id)->exists())
                                            <p class="mt-1 ml-7 text-sm text-green-400">
                                                Included in your {{ auth()->user()->activeSubscription()->subscriptionPlan->name }} subscription
                                            </p>
                                        @endif
                                        
                                        <a href="{{ route('user.digital-products.index') }}" class="mt-3 block w-full py-3 text-center bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition-colors duration-200">
                                            View in My Products
                                        </a>
                                    </div>
                                @else
                                    <!-- User doesn't have access -->
                                    <form action="{{ route('checkout.buy') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_type" value="digital_product">
                                        <input type="hidden" name="product_id" value="{{ $digitalProduct->id }}">
                                        <button type="submit" class="w-full py-3 bg-primary-500 text-white font-bold rounded-md hover:bg-primary-600 transition-colors duration-200 animate-glow flex items-center justify-center" {{ !$digitalProduct->isInStock() ? 'disabled' : '' }}>
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            @if($digitalProduct->isInStock())
                                                Buy Now
                                            @else
                                                Out of Stock
                                            @endif
                                        </button>
                                    </form>
                                    
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('subscription-plans.index') }}" class="text-primary-400 hover:text-primary-300 transition-colors duration-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                            </svg>
                                            Or get with subscription plan
                                        </a>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full py-3 text-center bg-primary-500 text-white font-bold rounded-md hover:bg-primary-600 transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Login to Purchase
                                </a>
                                
                                <div class="mt-4 text-center">
                                    <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 transition-colors duration-200">
                                        Don't have an account? Register now
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <!-- Product Icon -->
                <div class="bg-darker rounded-xl border border-gray-700 p-6 text-center">
                    <div class="mx-auto w-20 h-20 rounded-full bg-primary-400 bg-opacity-20 flex items-center justify-center mb-4">
                        @if($digitalProduct->type === 'license_key')
                            <svg class="h-10 w-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        @elseif($digitalProduct->type === 'account_credentials')
                            <svg class="h-10 w-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="h-10 w-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">100% Secure Purchase</h3>
                    <p class="text-gray-400 text-sm">Your digital product will be available instantly in your account after purchase</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products Section -->
    
</div>
@endsection

@push('styles')
<style>
    .animate-glow {
        box-shadow: 0 0 15px rgba(17, 100, 102, 0.5);
        animation: glow 2s ease-in-out infinite alternate;
    }
</style>
@endpush