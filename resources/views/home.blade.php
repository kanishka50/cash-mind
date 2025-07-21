@extends('layouts.app')

@section('title', 'Financial Education Platform')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden">
    <!-- Background with overlay gradient -->
    <div class="absolute inset-0 bg-gradient-to-r from-darker to-card"></div>
    
    <!-- Hero pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    </div>

    <!-- Animated circles -->
    <div class="absolute right-0 top-0 w-96 h-96 bg-accent-teal/5 rounded-full filter blur-3xl animate-pulse-slow"></div>
    <div class="absolute left-0 bottom-0 w-80 h-80 bg-secondary-400/5 rounded-full filter blur-3xl animate-pulse-slow" style="animation-delay: 1s;"></div>

    <div class="container mx-auto px-6 py-20 md:py-32 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 md:pr-10">
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                    Learn Financial Skills with 
                    <span class="text-accent-teal">Cash<span class="text-white">Mind</span></span>
                </h1>
                
                <p class="mt-6 text-lg text-gray-300 leading-relaxed">
                    Gain practical financial knowledge with our expert-led courses in Sinhala, designed specifically for Sri Lankan learners.
                </p>
                
                <div class="mt-10 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('courses.index') }}" class="px-6 py-3 bg-accent-teal text-white rounded-md shadow-lg hover:shadow-accent-teal/30 hover:bg-opacity-90 transition-all duration-300 text-center">
                        Browse Courses
                    </a>
                    <a href="{{ route('subscription-plans.index') }}" class="px-6 py-3 bg-transparent border border-secondary-400 text-secondary-400 rounded-md hover:bg-secondary-400/10 transition-all duration-300 text-center">
                        View Subscription Plans
                    </a>
                </div>
            </div>
            
            <div class="md:w-1/2 mt-10 md:mt-0">
                <div class="relative">
                    <!-- Decorative elements -->
                    <div class="absolute -top-6 -right-6 w-40 h-40 bg-accent-teal/20 rounded-full filter blur-xl"></div>
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-secondary-400/20 rounded-full filter blur-xl"></div>
                    
                    <!-- Main image container with shine effect -->
                    <div class="relative glass-effect rounded-lg overflow-hidden border border-white/5 shadow-2xl animate-glow">
                        <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=400" alt="Financial Education" class="w-full h-auto">
                        
                        <!-- Shine effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent shine-anim"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Courses Section -->
<div class="py-20 bg-dark relative overflow-hidden">
    <!-- Background decorative element -->
    <div class="absolute left-0 top-0 w-full h-full bg-gradient-to-b from-transparent to-darker opacity-50"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Our Featured <span class="text-accent-teal">Courses</span></h2>
                <div class="h-1 w-20 bg-accent-teal rounded"></div>
            </div>
            
            <a href="{{ route('courses.index') }}" class="mt-4 sm:mt-0 group flex items-center text-secondary-400 hover:text-secondary-300 transition-all duration-300">
                View All Courses
                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($featuredCourses) && $featuredCourses->count() > 0)
                @foreach($featuredCourses as $course)
                    @include('components.course-card', ['course' => $course])
                @endforeach
            @else
                <!-- Fallback static courses if no featured courses are found -->
                <div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group">
                    <div class="relative">
                        <div class="h-48 bg-gray-800 overflow-hidden">
                            <img src="https://via.placeholder.com/400x250" alt="Personal Finance Basics" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-accent-teal text-white text-xs px-2 py-1 rounded-md">Featured</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60"></div>
                        <div class="absolute bottom-0 left-0 mb-4 ml-4">
                            <span class="bg-secondary-400 bg-opacity-90 text-dark text-xs px-2 py-1 rounded-md">Beginner</span>
                        </div>
                    </div>
                    
                    <div class="p-5 relative z-10">
                        <h3 class="text-xl font-semibold mb-2 group-hover:text-accent-teal transition-colors duration-300">Personal Finance Basics</h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">Learn how to manage your personal finances effectively and build wealth over time.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-accent-teal font-semibold">Rs. 3,500</span>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-secondary-400 hover:text-secondary-300 transition-colors duration-200">
                                View Course
                                <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group">
                    <div class="relative">
                        <div class="h-48 bg-gray-800 overflow-hidden">
                            <img src="https://via.placeholder.com/400x250" alt="Investment Strategies" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60"></div>
                        <div class="absolute bottom-0 left-0 mb-4 ml-4">
                            <span class="bg-secondary-400 bg-opacity-90 text-dark text-xs px-2 py-1 rounded-md">Intermediate</span>
                        </div>
                    </div>
                    
                    <div class="p-5 relative z-10">
                        <h3 class="text-xl font-semibold mb-2 group-hover:text-accent-teal transition-colors duration-300">Investment Strategies</h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">Master different investment techniques for long-term growth in the Sri Lankan market.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-accent-teal font-semibold">Rs. 4,500</span>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-secondary-400 hover:text-secondary-300 transition-colors duration-200">
                                View Course
                                <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group">
                    <div class="relative">
                        <div class="h-48 bg-gray-800 overflow-hidden">
                            <img src="https://via.placeholder.com/400x250" alt="Fiverr Freelancing Masterclass" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="absolute top-0 right-0 mt-2 mr-2">
                            <span class="bg-accent-teal text-white text-xs px-2 py-1 rounded-md">Featured</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60"></div>
                        <div class="absolute bottom-0 left-0 mb-4 ml-4">
                            <span class="bg-secondary-400 bg-opacity-90 text-dark text-xs px-2 py-1 rounded-md">Beginner</span>
                        </div>
                    </div>
                    
                    <div class="p-5 relative z-10">
                        <h3 class="text-xl font-semibold mb-2 group-hover:text-accent-teal transition-colors duration-300">Fiverr Freelancing Masterclass</h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">Generate income with proven Fiverr strategies for beginners in the Sri Lankan market.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-accent-teal font-semibold">Rs. 5,000</span>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-secondary-400 hover:text-secondary-300 transition-colors duration-200">
                                View Course
                                <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Digital Products Section -->
<div class="py-20 bg-darker relative overflow-hidden">
    <!-- Background decorative element -->
    <div class="absolute right-0 top-1/3 w-80 h-80 bg-accent-teal/5 rounded-full filter blur-3xl"></div>
    <div class="absolute left-0 bottom-1/3 w-80 h-80 bg-secondary-400/5 rounded-full filter blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Digital <span class="text-secondary-400">Products</span></h2>
                <div class="h-1 w-20 bg-secondary-400 rounded"></div>
            </div>
            
            <a href="{{ route('digital-products.index') }}" class="mt-4 sm:mt-0 group flex items-center text-accent-teal hover:text-accent-light transition-all duration-300">
                View All Products
                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                @foreach($featuredProducts as $product)
                    <div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group h-full flex flex-col">
                        <div class="p-6 flex-1">
                            <div class="flex items-center justify-center w-full h-40 mb-4 bg-darker rounded-md group-hover:scale-95 transition-transform duration-300">
                                @php
                                    $icon = 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z';
                                    
                                    if($product->type == 'account_credentials') {
                                        $icon = 'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z';
                                    } elseif($product->type == 'digital_asset') {
                                        $icon = 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z';
                                    }
                                @endphp
                                
                                <svg class="w-16 h-16 text-accent-teal opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-xl font-semibold group-hover:text-accent-teal transition-colors duration-300">{{ $product->name }}</h3>
                            <p class="mt-3 text-gray-400 text-sm line-clamp-2">{{ $product->description }}</p>
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-900 bg-opacity-30 border-t border-gray-800 mt-auto">
                            <div class="flex justify-between items-center">
                                <span class="text-accent-teal font-semibold">Rs. {{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('digital-products.show', $product->id) }}" class="inline-flex items-center text-secondary-400 hover:text-secondary-300 transition-colors duration-200">
                                    Buy Now
                                    <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback content if no products found -->
                <div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group h-full flex flex-col">
                    <div class="p-6 flex-1">
                        <div class="flex items-center justify-center w-full h-40 mb-4 bg-darker rounded-md group-hover:scale-95 transition-transform duration-300">
                            <svg class="w-16 h-16 text-accent-teal opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-semibold group-hover:text-accent-teal transition-colors duration-300">Windows 11 Pro License Key</h3>
                        <p class="mt-3 text-gray-400 text-sm line-clamp-2">Genuine Windows 11 Pro license key with lifetime validity. Activate directly with Microsoft.</p>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-900 bg-opacity-30 border-t border-gray-800 mt-auto">
                        <div class="flex justify-between items-center">
                            <span class="text-accent-teal font-semibold">Rs. 8,500</span>
                            <a href="{{ route('digital-products.index') }}" class="inline-flex items-center text-secondary-400 hover:text-secondary-300 transition-colors duration-200">
                                Buy Now
                                <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Add two more fallback products as in the original code -->
            @endif
        </div>
    </div>
</div>

<!-- Subscription Plans Section -->
<div class="py-20 bg-dark relative overflow-hidden">
    <!-- Background decorative effects -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <h2 class="text-3xl font-bold text-center mb-3 text-white">Subscription <span class="text-accent-teal">Plans</span></h2>
        <div class="h-1 w-20 bg-accent-teal mx-auto rounded mb-10"></div>
        <p class="text-center text-gray-300 max-w-2xl mx-auto mb-12">Choose the perfect plan that suits your needs and unlock premium financial education content.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if(isset($subscriptionPlans) && $subscriptionPlans->count() > 0)
                @php
                    // Find the middle plan to highlight as featured
                    $planCount = $subscriptionPlans->count();
                    $middleIndex = floor($planCount / 2);
                    $currentIndex = 0;
                @endphp
                
                @foreach($subscriptionPlans as $plan)
                    @php 
                        $isFeatured = ($currentIndex == $middleIndex && $planCount > 1);
                    @endphp
                    
                    @if($isFeatured)
                        <!-- Featured Plan -->
                        <div class="bg-card rounded-lg overflow-hidden border-2 border-accent-teal shadow-xl hover:shadow-2xl hover:shadow-accent-teal/20 transition-all duration-300 transform scale-105">
                            <div class="bg-gradient-to-r from-accent-teal to-secondary-400 text-white text-center py-2">
                                <span class="text-sm font-semibold">Most Popular</span>
                            </div>
                            <div class="p-8">
                                <h3 class="text-xl font-bold mb-2 text-center text-white">{{ $plan->name }}</h3>
                                <div class="text-center mb-6">
                                    <span class="text-4xl font-bold text-accent-teal">Rs. {{ number_format($plan->price_monthly, 0) }}</span>
                                    <span class="text-gray-400">/month</span>
                                </div>
                                <ul class="space-y-3 mb-8">
                                    @if($plan->description)
                                        @php 
                                            $features = explode("\n", $plan->description);
                                        @endphp
                                        @foreach($features as $feature)
                                            @if(trim($feature))
                                                <li class="flex items-center text-gray-300">
                                                    <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>{{ trim($feature) }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <li class="flex items-center text-gray-300">
                                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Full access to premium content</span>
                                        </li>
                                        <li class="flex items-center text-gray-300">
                                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Priority support</span>
                                        </li>
                                    @endif
                                </ul>
                                <div class="text-center">
                                    <a href="{{ route('subscription-plans.index') }}" class="inline-block w-full py-3 px-6 bg-gradient-to-r from-accent-teal to-secondary-400 text-white rounded-md hover:shadow-lg hover:shadow-accent-teal/30 transition-all duration-300">
                                        Subscribe Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Regular Plan -->
                        <div class="bg-card rounded-lg overflow-hidden border border-gray-800 shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 text-center text-white">{{ $plan->name }}</h3>
                                <div class="text-center mb-6">
                                    <span class="text-4xl font-bold text-accent-teal">Rs. {{ number_format($plan->price_monthly, 0) }}</span>
                                    <span class="text-gray-400">/month</span>
                                </div>
                                <ul class="space-y-3 mb-8">
                                    @if($plan->description)
                                        @php 
                                            $features = explode("\n", $plan->description);
                                        @endphp
                                        @foreach($features as $feature)
                                            @if(trim($feature))
                                                <li class="flex items-center text-gray-300">
                                                    <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>{{ trim($feature) }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <li class="flex items-center text-gray-300">
                                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Access to select courses</span>
                                        </li>
                                        <li class="flex items-center text-gray-300">
                                            <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Email support</span>
                                        </li>
                                    @endif
                                </ul>
                                <div class="text-center">
                                    <a href="{{ route('subscription-plans.index') }}" class="inline-block w-full py-3 px-6 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300 shadow-lg">
                                        Subscribe Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @php $currentIndex++; @endphp
                @endforeach
            @else
                <!-- Fallback plans if no subscription plans are found in the database -->
                <!-- Basic Plan -->
                <div class="bg-card rounded-lg overflow-hidden border border-gray-800 shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-center text-white">Basic Plan</h3>
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-accent-teal">Rs. 999</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Access to 5 basic courses</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Limited access to premium content</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Email support</span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="{{ route('subscription-plans.index') }}" class="inline-block w-full py-3 px-6 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300 shadow-lg">
                                Subscribe Now
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Premium Plan (Featured) -->
                <div class="bg-card rounded-lg overflow-hidden border-2 border-accent-teal shadow-xl hover:shadow-2xl hover:shadow-accent-teal/20 transition-all duration-300 transform scale-105">
                    <div class="bg-gradient-to-r from-accent-teal to-secondary-400 text-white text-center py-2">
                        <span class="text-sm font-semibold">Most Popular</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-2 text-center text-white">Premium Plan</h3>
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-accent-teal">Rs. 1,999</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Access to all courses</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Full access to premium content</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Priority email support</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Monthly Q&A sessions</span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="{{ route('subscription-plans.index') }}" class="inline-block w-full py-3 px-6 bg-gradient-to-r from-accent-teal to-secondary-400 text-white rounded-md hover:shadow-lg hover:shadow-accent-teal/30 transition-all duration-300">
                                Subscribe Now
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Business Plan -->
                <div class="bg-card rounded-lg overflow-hidden border border-gray-800 shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-center text-white">Business Plan</h3>
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-accent-teal">Rs. 4,999</span>
                            <span class="text-gray-400">/month</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Access to all courses</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Full access to premium content</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Dedicated support</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Weekly 1-on-1 consultation</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Team access (up to 5 users)</span>
                            </li>
                        </ul>
                        <div class="text-center">
                            <a href="{{ route('subscription-plans.index') }}" class="inline-block w-full py-3 px-6 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300 shadow-lg">
                                Subscribe Now
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Why Choose Us Section -->
<div class="py-20 bg-darker relative overflow-hidden">
    <!-- Animated background effects -->
    <div class="absolute inset-0 bg-gradient-to-b from-dark to-darker opacity-50"></div>
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-accent-teal/5 rounded-full filter blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-secondary-400/5 rounded-full filter blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <h2 class="text-3xl font-bold text-center mb-3 text-white">Why Choose <span class="text-secondary-400">Cash</span><span class="text-accent-teal">Mind</span>?</h2>
        <div class="h-1 w-20 bg-gradient-to-r from-accent-teal to-secondary-400 mx-auto rounded mb-10"></div>
        <p class="text-center text-gray-300 max-w-2xl mx-auto mb-16">We deliver high-quality financial education tailored specifically for Sri Lankans.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="glass-effect p-8 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-accent-teal/10 group">
                <div class="w-16 h-16 flex items-center justify-center bg-accent-teal bg-opacity-10 rounded-full mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center text-white group-hover:text-accent-teal transition-colors duration-300">Local Language</h3>
                <p class="text-gray-300 text-center">
                    All our courses are presented in Sinhala, making complex financial concepts accessible to everyone in Sri Lanka.
                </p>
            </div>
            
            <!-- Card 2 -->
            <div class="glass-effect p-8 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-accent-teal/10 group">
                <div class="w-16 h-16 flex items-center justify-center bg-accent-teal bg-opacity-10 rounded-full mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center text-white group-hover:text-accent-teal transition-colors duration-300">Practical Knowledge</h3>
                <p class="text-gray-300 text-center">
                    Learn practical skills that you can apply immediately to improve your financial situation and career prospects.
                </p>
            </div>
            
            <!-- Card 3 -->
            <div class="glass-effect p-8 rounded-lg transition-all duration-300 hover:shadow-lg hover:shadow-accent-teal/10 group">
                <div class="w-16 h-16 flex items-center justify-center bg-accent-teal bg-opacity-10 rounded-full mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="h-8 w-8 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4 text-center text-white group-hover:text-accent-teal transition-colors duration-300">Proven Results</h3>
                <p class="text-gray-300 text-center">
                    Our courses have helped thousands of Sri Lankans improve their financial literacy and income generation capabilities.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="py-20 bg-gradient-to-r from-accent-dark to-dark relative overflow-hidden">
    <!-- Animated background effects -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to start your financial journey?</h2>
            <p class="text-xl text-gray-300 mb-10">Join thousands of Sri Lankans who have transformed their financial future with Cash Mind</p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('courses.index') }}" class="px-8 py-4 bg-accent-teal text-white rounded-md shadow-xl hover:shadow-accent-teal/30 hover:bg-opacity-90 transition-all duration-300 text-center text-lg font-medium">
                    Browse Courses
                </a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-secondary-400 bg-opacity-20 text-secondary-400 border border-secondary-400 rounded-md hover:bg-opacity-30 transition-all duration-300 text-center text-lg font-medium">
                    Create Account
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Glass effect */
    .glass-effect {
        background: rgba(18, 27, 37, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    /* Glow animation */
    .animate-glow {
        animation: glow 2s ease-in-out infinite alternate;
    }
    
    @keyframes glow {
        0% {
            box-shadow: 0 0 5px rgba(17, 100, 102, 0.5);
        }
        100% {
            box-shadow: 0 0 20px rgba(17, 100, 102, 0.8);
        }
    }
    
    /* Pulse animation */
    .animate-pulse-slow {
        animation: pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 0.1;
        }
        50% {
            opacity: 0.3;
        }
    }
    
    /* Shine effect */
    .shine-anim {
        animation: shine 3s ease-in-out infinite;
        animation-fill-mode: forwards;
        animation-delay: 0.5s;
    }
    
    @keyframes shine {
        0% {
            transform: translateX(-100%);
        }
        20%, 100% {
            transform: translateX(100%);
        }
    }
</style>
@endpush