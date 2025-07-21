@extends('layouts.user')

@section('title', 'My Digital Products')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            My Digital Products
        </h1>
        
        @if (session('success'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        <div class="mt-6">
            @if($productKeys->isEmpty() && $subscriptionProducts->isEmpty())
                <div class="glass-effect rounded-lg p-10 text-center border border-gray-800">
                    <svg class="h-16 w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No Digital Products</h3>
                    <p class="text-gray-400 mb-6">You haven't purchased any digital products yet.</p>
                    <a href="{{ route('digital-products.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                        Browse Digital Products
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            @else
                <!-- Subscription products -->
                @if($subscriptionProducts->isNotEmpty())
                    <div class="mb-10">
                        <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Subscription Products
                        </h2>
                        <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                            @foreach($subscriptionProducts as $product)
                                <div class="bg-card rounded-lg overflow-hidden shadow-lg border border-gray-800 hover:shadow-accent-teal/10 transition-all duration-300 group">
                                    <div class="h-48 bg-darker flex items-center justify-center">
                                        <svg class="h-16 w-16 text-accent-teal/50 group-hover:text-accent-teal transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="p-5">
                                        <h3 class="text-lg font-semibold text-white group-hover:text-accent-teal transition-colors duration-300">{{ $product->name }}</h3>
                                        
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-400">{{ Str::limit($product->description, 100) }}</p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <p class="text-sm text-green-400 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Included in your subscription
                                            </p>
                                        </div>
                                        
                                        <div class="mt-5">
                                            <a href="{{ route('user.digital-products.subscription.show', $product) }}" class="block w-full py-2 text-center bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Purchased products -->
                @if($productKeys->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Purchased Products
                        </h2>
                        <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                            @foreach($productKeys as $key)
                                <div class="bg-card rounded-lg overflow-hidden shadow-lg border border-gray-800 hover:shadow-accent-teal/10 transition-all duration-300 group">
                                    <div class="h-48 bg-darker flex items-center justify-center">
                                        <svg class="h-16 w-16 text-accent-teal/50 group-hover:text-accent-teal transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="p-5">
                                        <h3 class="text-lg font-semibold text-white group-hover:text-accent-teal transition-colors duration-300">{{ $key->digitalProduct->name }}</h3>
                                        
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-400">{{ Str::limit($key->digitalProduct->description, 100) }}</p>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-400">
                                                <span class="font-medium text-gray-300">Purchased:</span> {{ $key->used_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        
                                        <div class="mt-5">
                                            <a href="{{ route('user.digital-products.show', $key) }}" class="block w-full py-2 text-center bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                                                View Key/Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection