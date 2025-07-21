@extends('layouts.user')

@section('title', $message->subject)

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                </svg>
                View Message
            </h1>
            <a href="{{ route('user.messages.index') }}" class="inline-flex items-center px-4 py-2 bg-card border border-gray-800 text-white font-medium rounded-md hover:bg-darker transition-all duration-300">
                <svg class="mr-2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Messages
            </a>
        </div>
        
        @if(session('success'))
            <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        <div class="glass-effect rounded-lg border border-gray-800 p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-accent-teal/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-medium text-white">{{ $message->subject }}</h2>
                        <p class="text-sm text-gray-400 mt-1">
                            From: {{ $message->sender->name }} · {{ $message->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-4 bg-card border border-gray-800 rounded-lg p-5">
                <div class="text-gray-300 whitespace-pre-line">{{ $message->content }}</div>
            </div>
        </div>
        
        <div class="glass-effect rounded-lg border border-gray-800 p-6">
            <h2 class="text-lg font-medium text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                </svg>
                Reply to this message
            </h2>
            
            <form action="{{ route('user.messages.reply', $message) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-300 mb-2">Your Reply</label>
                    <textarea name="content" id="content" rows="4" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center py-2 px-4 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection