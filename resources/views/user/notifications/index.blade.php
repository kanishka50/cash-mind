@extends('layouts.user')

@section('title', 'My Notifications')

@section('content')
<div class="md:ml-64 min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                My Notifications
            </h1>
            
            @if($notifications->isNotEmpty())
                <form action="{{ route('user.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-accent-teal text-white px-4 py-2 rounded-md hover:bg-opacity-80 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-accent-teal/20">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>
        
        @if(session('success'))
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
            @if($notifications->isEmpty())
                <div class="glass-effect rounded-lg p-10 text-center border border-gray-800">
                    <svg class="h-16 w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="text-gray-400 mb-6">You don't have any notifications at the moment.</p>
                </div>
            @else
                <div class="glass-effect rounded-lg overflow-hidden border border-gray-800">
                    <div class="divide-y divide-gray-800">
                        @foreach($notifications as $notification)
                            <div class="hover:bg-darker transition-colors duration-200 {{ $notification->is_read ? 'bg-opacity-50' : '' }}">
                                <div class="block p-4 relative">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full {{ $notification->is_read ? 'bg-gray-700/20' : 'bg-accent-teal/20' }} flex items-center justify-center">
                                                <svg class="h-5 w-5 {{ $notification->is_read ? 'text-gray-400' : 'text-accent-teal' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <h4 class="text-sm font-medium {{ $notification->is_read ? 'text-gray-400' : 'text-white' }}">{{ $notification->title }}</h4>
                                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-400">{{ $notification->content }}</p>
                                            
                                            @if(!$notification->is_read)
                                                <div class="mt-3">
                                                    <form action="{{ route('user.notifications.mark-read', $notification) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-xs text-accent-teal hover:text-accent-teal/80 transition-colors duration-200">
                                                            Mark as read
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-6">
                    {{ $notifications->links() }}
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
</style>
@endpush