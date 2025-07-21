@extends('layouts.user')

@section('title', $video->title)

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-1 text-sm text-gray-400">
                            <li>
                                <a href="{{ route('user.dashboard') }}" class="hover:text-accent-teal transition-colors duration-200">Dashboard</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('user.courses.index') }}" class="ml-1 hover:text-accent-teal transition-colors duration-200">My Courses</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('user.courses.show', $video->course) }}" class="ml-1 hover:text-accent-teal transition-colors duration-200">{{ $video->course->title }}</a>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-300">{{ $video->title }}</span>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-white">{{ $video->title }}</h1>
                </div>
                
                <div class="relative">
                    @include('components.video-player', ['video' => $video, 'progress' => $progress])
                </div>
                
                <div class="mt-6 glass-effect rounded-lg p-6 border border-gray-800">
                    <h2 class="text-lg font-semibold text-white mb-4">About This Video</h2>
                    <div class="text-gray-300">
                        {!! nl2br(e($video->description)) !!}
                    </div>
                    
                    <div class="mt-6 flex flex-wrap gap-4">
                        @if($previousVideo)
                            <a href="{{ route('user.videos.show', $previousVideo) }}" class="inline-flex items-center px-4 py-2 bg-card border border-gray-800 shadow-sm text-sm font-medium rounded-md text-gray-300 hover:bg-opacity-80 hover:text-white transition-all duration-300">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous Video
                            </a>
                        @endif
                        
                        @if($nextVideo)
                            <a href="{{ route('user.videos.show', $nextVideo) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-accent-teal hover:bg-opacity-80 transition-all duration-300">
                                Next Video
                                <svg class="-mr-1 ml-2 h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="sticky top-24">
                    <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
                        <div class="p-4 bg-card border-b border-gray-800">
                            <h3 class="font-medium text-white">Course Videos</h3>
                        </div>
                        
                        <div class="divide-y divide-gray-800 max-h-96 overflow-y-auto">
                            @foreach($courseVideos as $courseVideo)
                                <a 
                                    href="{{ route('user.videos.show', $courseVideo) }}" 
                                    class="block p-4 hover:bg-darker transition-colors duration-200 {{ $courseVideo->id === $video->id ? 'bg-accent-teal bg-opacity-10' : '' }}"
                                >
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($courseVideo->id === $video->id)
                                                <div class="w-8 h-8 rounded-full bg-accent-teal bg-opacity-20 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            @elseif($courseVideo->userProgress(auth()->id())->first() && $courseVideo->userProgress(auth()->id())->first()->completed)
                                                <div class="w-8 h-8 rounded-full bg-green-900 bg-opacity-20 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium {{ $courseVideo->id === $video->id ? 'text-accent-teal' : 'text-white' }}">
                                                {{ $courseVideo->title }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $courseVideo->duration ? gmdate('H:i:s', $courseVideo->duration) : 'Unknown duration' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <div class="p-4 bg-card border-t border-gray-800">
                            <a href="{{ route('user.courses.show', $video->course) }}" class="text-sm font-medium text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                                Back to Course Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- We'll include the JS for video tracking from the video-player component -->
@endpush