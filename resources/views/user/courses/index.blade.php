@extends('layouts.user')

@section('title', 'My Courses')

@section('content')
<div class="md:ml-64 min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                My Courses
            </h1>
            <a href="{{ route('courses.index') }}" class="bg-accent-teal text-white px-4 py-2 rounded-md hover:bg-opacity-80 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-accent-teal/20">
                Browse More Courses
            </a>
        </div>
        
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
        
        <div class="mt-6">
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
                                
                                @if(auth()->user()->activeSubscription() && auth()->user()->activeSubscription()->subscriptionPlan->courses()->where('courses.id', $course->id)->exists())
                                    <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 text-xs font-bold rounded">Subscription</span>
                                @endif
                            </div>
                            
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-white group-hover:text-accent-teal transition-colors duration-300">{{ $course->title }}</h3>
                                
                                @if($course->category)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-accent-teal bg-opacity-20 text-accent-teal">
                                            {{ $course->category->name }}
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="mt-4">
                                    <div class="flex justify-between text-sm text-gray-400">
                                        <span>{{ $course->videos->count() }} videos</span>
                                        @if(property_exists($course, 'pivot') && $course->pivot && $course->pivot->purchased_at)
                                            <span>Purchased: {{ $course->pivot->purchased_at->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-5">
                                    <a href="{{ route('user.courses.show', $course) }}" class="block w-full text-center py-2 px-4 bg-accent-teal hover:bg-opacity-80 text-white font-medium rounded-md transition-all duration-300">
                                        View Course
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection