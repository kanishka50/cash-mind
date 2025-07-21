@extends('layouts.user')

@section('title', $course->title)

@section('content')
<div class="md:ml-64 min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('user.courses.index') }}" class="text-accent-teal hover:text-accent-teal/80 mr-3 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-white">{{ $course->title }}</h1>
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

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                @if($course->thumbnail)
                    <div class="mb-8 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'" 
                             alt="{{ $course->title }}" 
                             class="w-full h-auto object-cover">
                    </div>
                @endif
                
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Course Content
                    </h2>
                    
                    @if($videos->isEmpty())
                        <div class="glass-effect rounded-lg p-6 text-center border border-gray-800">
                            <p class="text-gray-400">No videos available for this course yet.</p>
                        </div>
                    @else
                        <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
                            <div class="divide-y divide-gray-800">
                                @foreach($videos as $video)
                                    <div class="hover:bg-darker transition-colors duration-200 {{ $video->progress && $video->progress->completed ? 'bg-green-900/20' : '' }}">
                                        <a href="{{ route('user.videos.show', $video) }}" class="block p-4">
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        @if($video->progress && $video->progress->completed)
                                                            <div class="w-10 h-10 rounded-full bg-green-900/20 flex items-center justify-center">
                                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                            </div>
                                                        @else
                                                            <div class="w-10 h-10 rounded-full bg-accent-teal/20 flex items-center justify-center">
                                                                <svg class="h-5 w-5 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <h4 class="text-sm font-medium text-white">{{ $video->title }}</h4>
                                                        <div class="mt-1 flex items-center text-xs text-gray-500">
                                                            @if($video->duration)
                                                                <span>{{ gmdate('H:i:s', $video->duration) }}</span>
                                                            @endif
                                                            
                                                            @if($video->progress)
                                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $video->progress->completed ? 'bg-green-900/20 text-green-400' : 'bg-accent-teal/20 text-accent-teal' }}">
                                                                    {{ $video->progress->completed ? 'Completed' : 'In Progress' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="px-3 py-1 text-xs font-medium rounded-md text-accent-teal bg-accent-teal bg-opacity-10 hover:bg-opacity-20 transition-all duration-200">
                                                        Watch
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="sticky top-24">
                    <div class="glass-effect rounded-lg overflow-hidden border border-gray-800 mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white mb-4">Course Overview</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">Total Videos:</span>
                                    <span class="font-medium text-white">{{ $videos->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">Completed:</span>
                                    <span class="font-medium text-green-400">{{ $videos->filter(function($video) { return $video->progress && $video->progress->completed; })->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">In Progress:</span>
                                    <span class="font-medium text-accent-teal">{{ $videos->filter(function($video) { return $video->progress && !$video->progress->completed; })->count() }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-400 mb-2">Your Progress</h4>
                                @php
                                    $completedCount = $videos->filter(function($video) {
                                        return $video->progress && $video->progress->completed;
                                    })->count();
                                    
                                    $progressPercentage = $videos->count() > 0
                                        ? round(($completedCount / $videos->count()) * 100)
                                        : 0;
                                @endphp
                                
                                <div class="relative">
                                    <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-gray-800">
                                        <div style="width: {{ $progressPercentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-accent-teal"></div>
                                    </div>
                                    <div class="text-right text-xs text-gray-400">{{ $progressPercentage }}% complete</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($videos->isNotEmpty())
                        @php
                            $nextVideo = $videos->first(function($video) {
                                return !$video->progress || !$video->progress->completed;
                            }) ?? $videos->first();
                        @endphp
                        
                        @if($nextVideo)
                            <a href="{{ route('user.videos.show', $nextVideo) }}" class="block w-full text-center py-3 px-4 bg-accent-teal hover:bg-opacity-80 text-white font-medium rounded-md transition-all duration-300">
                                {{ ($nextVideo->progress && !$nextVideo->progress->completed) ? 'Continue Learning' : 'Start Learning' }}
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection