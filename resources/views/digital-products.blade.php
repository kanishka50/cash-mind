@extends('layouts.app')

@section('title', 'Digital Products')

@section('content')
<!-- Page Header -->
<div class="relative py-12 bg-darker">
    <div class="absolute inset-0 bg-gradient-to-r from-secondary-400/20 to-accent-teal/10 opacity-30"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    
    <div class="container px-6 mx-auto relative z-10">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-white">Digital <span class="text-secondary-400">Products</span></h1>
        <div class="w-20 h-1 bg-secondary-400 mx-auto mt-2"></div>
        <p class="mt-4 text-center text-gray-300 max-w-2xl mx-auto">Browse our selection of premium digital products including license keys and software subscriptions</p>
    </div>
</div>

<div class="container px-6 py-16 mx-auto">
    <!-- Product Categories -->
    <div class="mb-12 flex flex-wrap justify-center gap-4">
        <a href="#" class="px-6 py-2 rounded-full bg-card border border-gray-800 text-white hover:bg-accent-teal hover:text-white transition-all duration-300">
            All Products
        </a>
        <a href="#" class="px-6 py-2 rounded-full bg-card border border-gray-800 text-gray-400 hover:bg-accent-teal hover:text-white transition-all duration-300">
            Windows Licenses
        </a>
        <a href="#" class="px-6 py-2 rounded-full bg-card border border-gray-800 text-gray-400 hover:bg-accent-teal hover:text-white transition-all duration-300">
            Accounts & Subscriptions
        </a>
        <a href="#" class="px-6 py-2 rounded-full bg-card border border-gray-800 text-gray-400 hover:bg-accent-teal hover:text-white transition-all duration-300">
            Digital Assets
        </a>
    </div>

    @if($digitalProducts->isEmpty())
        <div class="glass-effect p-16 rounded-lg">
            <div class="text-center py-10">
                <svg class="h-20 w-20 text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">No Digital Products Available</h3>
                <p class="text-gray-400 max-w-lg mx-auto mb-8">We're currently updating our inventory. Please check back soon for new digital products.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Return to Home
                </a>
            </div>
        </div>
    @else
        <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
            @foreach($digitalProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    @endif

    <!-- Call to Action -->
    <div class="mt-20 glass-effect rounded-lg p-8 md:p-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-accent-teal/10 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-400/10 rounded-full filter blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 md:mr-8">
                <h3 class="text-2xl font-bold text-white mb-2">Need a custom digital product?</h3>
                <p class="text-gray-300">Contact us for custom software licenses, subscriptions, or special product requests.</p>
            </div>
            <a href="{{ route('contact') }}" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-accent-teal to-secondary-400 text-white font-medium rounded-md shadow-lg hover:shadow-accent-teal/20 transition-all duration-300 min-w-[150px] whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                Contact Us
            </a>
        </div>
    </div>
</div>

<!-- Benefits Section -->
<div class="py-16 bg-darker relative overflow-hidden">
    <div class="absolute top-0 right-0 w-80 h-80 bg-accent-teal/5 rounded-full filter blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-secondary-400/5 rounded-full filter blur-3xl"></div>
    
    <div class="container px-6 mx-auto relative z-10">
        <h2 class="text-2xl font-bold text-center text-white mb-3">Why Choose Our <span class="text-secondary-400">Digital Products</span>?</h2>
        <div class="w-20 h-1 bg-secondary-400 mx-auto rounded mb-12"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="glass-effect p-6 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-accent-teal/10 group">
                <div class="w-14 h-14 flex items-center justify-center bg-accent-teal bg-opacity-10 rounded-full mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-3 text-white group-hover:text-accent-teal transition-colors duration-300">100% Genuine Products</h3>
                <p class="text-gray-300">
                    All our digital products are 100% authentic and come with a guarantee of legitimacy and reliability.
                </p>
            </div>
            
            <!-- Card 2 -->
            <div class="glass-effect p-6 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-accent-teal/10 group">
                <div class="w-14 h-14 flex items-center justify-center bg-accent-teal bg-opacity-10 rounded-full mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-3 text-white group-hover:text-accent-teal transition-colors duration-300">Instant Delivery</h3>
                <p class="text-gray-300">
                    After purchase, your digital products are delivered instantly to your account or email for immediate use.
                </p>
            </div>
            
            <!-- Card 3 -->
            <div class="glass-effect p-6 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-accent-teal/10 group">
                <div class="w-14 h-14 flex items-center justify-center bg-accent-teal bg-opacity-10 rounded-full mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-6 w-6 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-3 text-white group-hover:text-accent-teal transition-colors duration-300">Technical Support</h3>
                <p class="text-gray-300">
                    We provide dedicated technical support to help you with activation or any issues you might encounter.
                </p>
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