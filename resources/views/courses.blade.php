@extends('layouts.app')

@section('title', 'Our Courses')

@section('content')
<!-- Page Header -->
<div class="relative py-12 bg-darker">
    <div class="absolute inset-0 bg-gradient-to-r from-accent-teal/20 to-secondary-400/10 opacity-30"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    
    <div class="container px-6 mx-auto relative z-10">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-white">Explore Our <span class="text-accent-teal">Courses</span></h1>
        <div class="w-20 h-1 bg-accent-teal mx-auto mt-2"></div>
        <p class="mt-4 text-center text-gray-300 max-w-2xl mx-auto">Browse through our wide selection of financial education courses designed specifically for Sri Lankan learners</p>
    </div>
</div>

<div class="container px-6 py-10 mx-auto">
    <div class="lg:flex lg:items-start lg:gap-8">
        <!-- Filters -->
        <div class="w-full lg:w-1/4">
            <div class="sticky top-24 glass-effect rounded-lg overflow-hidden shadow-lg">
                <div class="bg-gradient-to-r from-accent-teal to-secondary-400 h-1 w-full"></div>
                <div class="p-6">
                    <h3 class="text-xl font-medium text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filters
                    </h3>
                    
                    <form action="{{ route('courses.index') }}" method="GET" class="mt-5">
                        <div class="mb-5">
                            <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                       class="w-full pl-10 pr-3 py-2 border border-gray-700 bg-dark/50 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all duration-300 placeholder-gray-500"
                                       placeholder="Search courses...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                            <div class="relative">
                                <select name="category" id="category" 
                                        class="w-full pl-10 pr-3 py-2 border border-gray-700 bg-dark/50 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all duration-300 appearance-none">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <label for="tag" class="block text-sm font-medium text-gray-300 mb-2">Tag</label>
                            <div class="relative">
                                <select name="tag" id="tag" 
                                        class="w-full pl-10 pr-3 py-2 border border-gray-700 bg-dark/50 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all duration-300 appearance-none">
                                    <option value="">All Tags</option>
                                    @foreach($tags as $id => $name)
                                        <option value="{{ $id }}" {{ request('tag') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full py-3 px-4 bg-accent-teal hover:bg-opacity-80 rounded-md text-white font-medium transition-all duration-300 shadow-lg hover:shadow-accent-teal/20 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Apply Filters
                        </button>
                        
                        @if(request()->has('search') || request()->has('category') || request()->has('tag'))
                            <a href="{{ route('courses.index') }}" class="block mt-3 text-center text-secondary-400 hover:text-secondary-300 transition-all duration-300">
                                <span class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear Filters
                                </span>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Courses Grid -->
        <div class="w-full lg:w-3/4 mt-8 lg:mt-0">
            @if($courses->isEmpty())
                <div class="flex flex-col items-center justify-center p-10 glass-effect rounded-lg shadow-xl">
                    <svg class="w-20 h-20 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-medium text-white mb-2">No courses found</h3>
                    <p class="text-gray-400 text-center mb-6">Try adjusting your search or filter criteria</p>
                    <a href="{{ route('courses.index') }}" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-80 transition-all duration-300">
                        View All Courses
                    </a>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($courses as $course)
                        @include('components.course-card', ['course' => $course])
                    @endforeach
                </div>
                
                <div class="mt-10">
                    {{ $courses->links() }}
                </div>
            @endif
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
    
    /* Fix for the thumbnail issue */
    .pb-1\/2 {
        padding-bottom: 50%;
    }
    
    /* Custom pagination styles */
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .pagination li {
        margin: 0 5px;
    }
    
    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(18, 27, 37, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 0.375rem;
        color: white;
        transition: all 0.3s ease;
    }
    
    .pagination li.active span {
        background-color: #116466;
        color: white;
    }
    
    .pagination li a:hover {
        background-color: rgba(17, 100, 102, 0.2);
    }
</style>
@endpush

@push('scripts')
<script>
    // Fix for thumbnail display if needed
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('.course-thumbnail');
        thumbnails.forEach(thumbnail => {
            if (!thumbnail.complete || thumbnail.naturalHeight === 0) {
                thumbnail.src = 'https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=400';
            }
        });
    });
</script>
@endpush