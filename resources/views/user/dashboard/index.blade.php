@extends('layouts.user')

@section('title', 'My Dashboard')

@section('content')
<div class="md:ml-64 min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        @if (session('success'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        <!-- Quick Stats -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Overview
            </h2>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- My Courses Card -->
                <div class="glass-effect rounded-lg overflow-hidden border border-gray-800 hover:shadow-lg hover:shadow-accent-teal/10 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-accent-teal bg-opacity-10 mr-4">
                                <svg class="h-8 w-8 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-400">My Courses</h3>
                                <p class="text-3xl font-bold text-white">{{ auth()->user()->courses()->count() }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('user.courses.index') }}" class="text-accent-teal hover:text-accent-teal/80 text-sm flex items-center transition-all duration-200">
                                View all courses
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Completed Videos Card -->
                <div class="glass-effect rounded-lg overflow-hidden border border-gray-800 hover:shadow-lg hover:shadow-accent-teal/10 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10 mr-4">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-400">Completed Videos</h3>
                                <p class="text-3xl font-bold text-white">{{ auth()->user()->videoProgress()->where('completed', true)->count() }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('user.courses.index') }}" class="text-green-500 hover:text-green-400 text-sm flex items-center transition-all duration-200">
                                Continue learning
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Wishlist Items Card -->
                <div class="glass-effect rounded-lg overflow-hidden border border-gray-800 hover:shadow-lg hover:shadow-accent-teal/10 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-secondary-400 bg-opacity-10 mr-4">
                                <svg class="h-8 w-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-400">Wishlist Items</h3>
                                <p class="text-3xl font-bold text-white">{{ auth()->user()->wishlist()->count() }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('user.wishlist.index') }}" class="text-secondary-400 hover:text-secondary-300 text-sm flex items-center transition-all duration-200">
                                View wishlist
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if(auth()->user()->hasActiveSubscription())
        <div class="mb-12 glass-effect rounded-lg p-6 border-l-4 border-accent-teal relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-accent-teal/10 rounded-full filter blur-3xl"></div>
            
            <div class="flex items-start relative z-10">
                <div class="flex-shrink-0 mr-4">
                    <svg class="h-10 w-10 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-white mb-2">Active Subscription: <span class="text-accent-teal">{{ auth()->user()->activeSubscription()->subscriptionPlan->name }}</span></h3>
                    <p class="text-gray-300 mb-4">
                        Your subscription gives you access to premium content. Visit your <a href="{{ route('user.courses.index') }}" class="text-accent-teal hover:text-accent-teal/80 underline transition-colors duration-200">courses</a> and <a href="{{ route('user.digital-products.index') }}" class="text-accent-teal hover:text-accent-teal/80 underline transition-colors duration-200">digital products</a> to see what's included.
                    </p>
                    <a href="{{ route('user.subscriptions.manage') }}" class="inline-flex items-center text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                        Manage subscription
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Recent Courses -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    My Courses
                </h2>
                <a href="{{ route('user.courses.index') }}" class="text-accent-teal hover:text-accent-teal/80 flex items-center transition-all duration-200">
                    View all
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            @if($courses->isEmpty())
                <div class="glass-effect rounded-lg p-10 text-center border border-gray-800">
                    <svg class="h-16 w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-gray-400 mb-6">You haven't purchased any courses yet.</p>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                        Browse courses
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($courses as $course)
                        <div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group border border-gray-800">
                            <div class="relative h-48">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'" 
                                        alt="{{ $course->title }}" 
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="h-full w-full bg-darker flex items-center justify-center">
                                        <svg class="h-16 w-16 text-accent-teal opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60"></div>
                            </div>
                            
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-white group-hover:text-accent-teal transition-colors duration-300">{{ $course->title }}</h3>
                                
                                <div class="mt-4">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-xs font-medium text-accent-teal">
                                                Progress
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-medium text-accent-teal">
                                                {{ $course->progress_percentage }}%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="h-2 bg-gray-800 rounded-full">
                                        <div style="width:{{ $course->progress_percentage }}%" class="h-full bg-accent-teal rounded-full"></div>
                                    </div>
                                </div>
                                
                                <div class="mt-5">
                                    <a href="{{ route('user.courses.show', $course) }}" class="block w-full text-center py-2 px-4 bg-accent-teal hover:bg-opacity-80 text-white font-medium rounded-md transition-all duration-300">
                                        Continue Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
  
        <!-- Recent Activity -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Activity
            </h2>
            
            <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
                @if($recentProgress->isEmpty())
                    <div class="p-8 text-center text-gray-400">
                        <svg class="h-16 w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>No recent activity found.</p>
                        <p class="text-sm mt-2">Start watching some videos to track your progress.</p>
                    </div>
                @else
                    <ul class="divide-y divide-gray-800">
                        @foreach($recentProgress as $progress)
                            <li class="hover:bg-darker transition-colors duration-200">
                                <a href="{{ route('user.videos.show', $progress->video) }}" class="block px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-teal/20 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white">
                                                    {{ $progress->video->title }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $progress->video->course->title }}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                @if($progress->completed)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-900/20 text-green-400">
                                                        Completed
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-secondary-400/20 text-secondary-400">
                                                        In Progress
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 text-right mt-1">
                                                {{ $progress->last_watched->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>


        <!-- Affiliate Program Promotion -->
<div class="mt-8">
    <div class="glass-effect rounded-lg p-6 border border-accent-teal border-opacity-30 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-accent-teal/10 rounded-full filter blur-3xl"></div>
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between relative z-10">
            <div>
                <h3 class="text-lg font-medium text-white">Earn with our Affiliate Program</h3>
                <p class="mt-2 text-gray-400">Generate referral links, share with others, and earn commissions when they purchase courses or products.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('user.referrals.index') }}" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition-all duration-200">
                    View Affiliate Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

        <!-- Subscription Content Section -->
        @if(auth()->user()->hasActiveSubscription())
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Your Subscription Content
                </h2>
                
                @php
                    $subscriptionPlan = auth()->user()->activeSubscription()->subscriptionPlan;
                    $subscriptionCourses = $subscriptionPlan->courses;
                    $subscriptionProducts = $subscriptionPlan->digitalProducts;
                @endphp
                
                @if($subscriptionCourses->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-xl font-medium text-white mb-4">Included Courses</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($subscriptionCourses->take(3) as $course)
                                @include('components.course-card', ['course' => $course])
                            @endforeach
                        </div>
                        
                        @if($subscriptionCourses->count() > 3)
                            <div class="mt-4 text-center">
                                <a href="{{ route('user.courses.index') }}" class="inline-flex items-center text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                                    View all subscription courses
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
                
                @if($subscriptionProducts->count() > 0)
                    <div>
                        <h3 class="text-xl font-medium text-white mb-4">Included Digital Products</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($subscriptionProducts->take(3) as $product)
                                @include('components.product-card', ['product' => $product])
                            @endforeach
                        </div>
                        
                        @if($subscriptionProducts->count() > 3)
                            <div class="mt-4 text-center">
                                <a href="{{ route('user.digital-products.index') }}" class="inline-flex items-center text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                                    View all subscription products
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
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
    
    /* Fix for thumbnail display */
    .course-thumbnail {
        height: 192px;
        width: 100%;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script>
    // Fix for thumbnail display
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('img[alt]');
        thumbnails.forEach(thumbnail => {
            // Check if image fails to load
            thumbnail.addEventListener('error', function() {
                this.src = 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
            });
            
            // For images that might have already failed
            if (thumbnail.complete && thumbnail.naturalHeight === 0) {
                thumbnail.src = 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
            }
        });
    });
</script>
@endpush