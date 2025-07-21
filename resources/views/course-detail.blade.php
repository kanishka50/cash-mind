@extends('layouts.app')

@section('title', $course->title)

@section('content')
<!-- Page Header with Course Title -->
<div class="relative py-10 bg-darker">
    <div class="absolute inset-0 bg-gradient-to-r from-accent-teal/20 to-secondary-400/10 opacity-30"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    
    <div class="container px-6 mx-auto relative z-10">
        <!-- Breadcrumb navigation -->
        <nav class="text-sm text-gray-400 mb-4 flex items-center">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors duration-200">Home</a>
            <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('courses.index') }}" class="hover:text-white transition-colors duration-200">Courses</a>
            <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-white">{{ $course->title }}</span>
        </nav>
        
        <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $course->title }}</h1>
        
        @if($course->category)
        <div class="mt-3 flex flex-wrap gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-accent-teal/20 text-accent-teal">
                {{ $course->category->name }}
            </span>
            
            @foreach($course->tags as $tag)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-secondary-400/20 text-secondary-400">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
        @endif
        
        @if(auth()->check() && auth()->user()->hasActiveSubscription())
            @php
                $subscriptionPlan = auth()->user()->activeSubscription()->subscriptionPlan;
                $isInSubscription = $subscriptionPlan->courses()->where('courses.id', $course->id)->exists();
            @endphp
            
            @if($isInSubscription)
                <div class="mt-3 bg-green-900/20 text-green-400 border border-green-500/30 px-3 py-1 rounded-full text-sm inline-flex items-center">
                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Included in your {{ $subscriptionPlan->name }} subscription
                </div>
            @endif
        @endif
    </div>
</div>

<div class="container px-6 py-10 mx-auto">
    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Main Content Column -->
        <div class="w-full lg:w-2/3">
            @if(session('success'))
                <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Course Thumbnail -->
            <div class="overflow-hidden rounded-lg shadow-lg">
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'" 
                        alt="{{ $course->title }}" 
                        class="w-full h-auto rounded-lg object-cover shadow-md">
                @else
                    <div class="w-full h-64 bg-card flex items-center justify-center rounded-lg">
                        <svg class="h-16 w-16 text-accent-teal opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Course Description -->
            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    About This Course
                </h2>
                <div class="glass-effect p-6 rounded-lg text-gray-300 leading-relaxed">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>
            
            <!-- Course Content section -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    Course Content
                </h2>
                
                @if($videos->isEmpty())
                    <div class="glass-effect p-10 rounded-lg text-center">
                        <svg class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                        </svg>
                        <p class="text-gray-400 text-lg">No videos available for this course yet.</p>
                    </div>
                @else
                    <div class="glass-effect rounded-lg overflow-hidden divide-y divide-gray-800">
                        @foreach($videos as $video)
                            <div class="flex items-center justify-between p-5 hover:bg-card transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($video->is_accessible)
                                            <div class="h-12 w-12 flex items-center justify-center bg-accent-teal/20 rounded-full text-accent-teal">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="h-12 w-12 flex items-center justify-center bg-gray-800/60 rounded-full text-gray-500">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-base font-medium text-white">{{ $video->title }}</h3>
                                        @if($video->duration)
                                            <p class="mt-1 text-sm text-gray-400 flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ gmdate('H:i:s', $video->duration) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @if($video->is_accessible)
                                        <a href="{{ route('user.videos.show', $video) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-300 {{ $video->is_preview ? 'bg-secondary-400/30 text-secondary-400 hover:bg-secondary-400/50' : 'bg-accent-teal text-white hover:bg-opacity-80' }}">
                                            @if($video->is_preview)
                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Preview
                                            @else
                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Watch
                                            @endif
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md bg-gray-800/60 text-gray-400 border border-gray-700">
                                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Locked
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar - Purchase Card -->
        <div class="w-full lg:w-1/3">
            <div class="sticky top-24">
                <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 hover:shadow-accent-teal/10 transition-all duration-300">
                    <div class="bg-gradient-to-br from-accent-teal/30 to-secondary-400/20 p-6">
                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-bold text-white">Rs. {{ number_format($course->price, 2) }}</span>
                            @if($course->is_featured)
                                <span class="px-2 py-1 bg-accent-teal text-white text-xs font-medium rounded-md">Featured</span>
                            @endif
                        </div>
                        
                        <div class="mt-4 flex items-center text-gray-300">
                            <svg class="h-5 w-5 text-secondary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $videos->count() }} videos</span>
                            
                            @if($videos->sum('duration') > 0)
                                <span class="mx-2">•</span>
                                <span>{{ gmdate('H \h i \m', $videos->sum('duration')) }} total length</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <ul class="space-y-4 mb-6">
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Full lifetime access</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Access on mobile and TV</span>
                            </li>
                            <li class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 text-accent-teal mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Created in Sinhala language</span>
                            </li>
                        </ul>
                        
                        @auth
                            @if(auth()->user()->hasAccessToCourse($course))
                                <a href="{{ route('user.courses.show', $course) }}" class="flex items-center justify-center w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white text-center font-medium rounded-md transition-all duration-300 shadow-lg">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Access Course
                                </a>
                                
                                @if(auth()->user()->activeSubscription() && auth()->user()->activeSubscription()->subscriptionPlan->courses()->where('courses.id', $course->id)->exists())
                                    <p class="mt-3 text-sm text-green-400 text-center">
                                        <svg class="inline h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Included in your subscription
                                    </p>
                                @endif
                            @else
                                <form action="{{ route('checkout.buy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_type" value="course">
                                    <input type="hidden" name="product_id" value="{{ $course->id }}">
                                    <button type="submit" class="flex items-center justify-center w-full py-3 px-4 bg-accent-teal hover:bg-opacity-80 text-white text-center font-medium rounded-md transition-all duration-300 shadow-lg">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Buy This Course
                                    </button>
                                </form>
                                
                                <div class="mt-4 text-center">
                                    <a href="{{ route('subscription-plans.index') }}" class="text-accent-teal hover:text-accent-teal/80 transition-colors duration-200 flex items-center justify-center">
                                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Or get this with a subscription plan
                                    </a>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-3 px-4 bg-accent-teal hover:bg-opacity-80 text-white text-center font-medium rounded-md transition-all duration-300 shadow-lg">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login to Purchase
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Share Box -->
                <div class="mt-6 glass-effect rounded-lg overflow-hidden p-5 border border-gray-800">
                    <h3 class="text-white font-medium mb-3">Share this course</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-600 text-white hover:bg-opacity-80 transition-all">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
                            </svg>
                        </a>
                        <a href="#" class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-400 text-white hover:bg-opacity-80 transition-all">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="flex items-center justify-center w-9 h-9 rounded-full bg-green-600 text-white hover:bg-opacity-80 transition-all">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="flex items-center justify-center w-9 h-9 rounded-full bg-red-600 text-white hover:bg-opacity-80 transition-all">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Affiliate Program Section -->
@auth
    @if($course->hasActiveCommissionRate())
        <div class="mt-6 glass-effect rounded-lg overflow-hidden p-5 border border-accent-teal border-opacity-30">
            <h3 class="text-white font-medium mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Affiliate Program
            </h3>
            <p class="mt-1 text-sm text-gray-400">Earn {{ $course->activeCommissionRate }}% commission when someone purchases this course through your referral link.</p>
            
            <form action="{{ route('user.referrals.generate') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="item_type" value="course">
                <input type="hidden" name="item_id" value="{{ $course->id }}">
                <button type="submit" class="px-4 py-2 bg-accent-teal bg-opacity-20 text-accent-teal rounded-md text-sm hover:bg-opacity-30 transition duration-200 w-full">
                    <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    Generate Referral Link
                </button>
            </form>
        </div>
    @endif
@endauth
        </div>
    </div>
    
    <!-- Related Courses -->
    @if(isset($relatedCourses) && $relatedCourses->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-semibold text-white mb-6">You may also like</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($relatedCourses as $relatedCourse)
                @include('components.course-card', ['course' => $relatedCourse])
            @endforeach
        </div>
    </div>
    @endif
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
    
    /* Ensure the course thumbnail displays correctly */
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
        const thumbnails = document.querySelectorAll('img[alt="{{ $course->title }}"]');
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