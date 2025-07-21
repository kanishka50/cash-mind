@extends('layouts.user')

@section('title', 'My Messages')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                My Messages
            </h1>
            <a href="{{ route('user.messages.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Message
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
        
        @if($messages->isEmpty())
            <div class="glass-effect rounded-lg p-10 text-center border border-gray-800">
                <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No messages yet</h3>
                <p class="text-gray-400 mb-6">Get started by sending a message to our support team.</p>
                <div>
                    <a href="{{ route('user.messages.create') }}" class="inline-flex items-center px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Start a conversation
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($messages as $message)
                    <a href="{{ route('user.messages.show', $message) }}" class="block glass-effect rounded-lg border border-gray-800 p-4 hover:bg-darker transition-all duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-accent-teal/20 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium {{ $message->is_read ? 'text-white' : 'text-accent-teal' }}">{{ $message->subject }}</p>
                                    <p class="text-sm text-gray-400 mt-1">From: {{ $message->sender->name }}</p>
                                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ Str::limit($message->content, 120) }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-xs text-gray-500">{{ $message->created_at->format('M d, Y') }}</span>
                                <span class="text-xs text-gray-600">{{ $message->created_at->format('h:i A') }}</span>
                                @if(!$message->is_read)
                                    <span class="mt-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-accent-teal/20 text-accent-teal">
                                        New
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection