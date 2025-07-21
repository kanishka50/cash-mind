@extends('layouts.admin')

@section('title', $message->subject)

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">View Message</h1>
            <div class="h-1 w-20 bg-accent-teal rounded mt-2"></div>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 bg-card text-white font-medium rounded-md hover:bg-gray-800 transition duration-200 flex items-center border border-gray-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
            </svg>
            Back to Messages
        </a>
    </div>
    
    <!-- Message Container -->
    <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
        <div class="p-6">
            <h2 class="text-xl font-medium text-white">{{ $message->subject }}</h2>
            
            <div class="mt-4 flex flex-wrap items-center text-sm text-gray-400 border-b border-gray-700 pb-4">
                <div class="mr-6 mb-2">
                    <span class="font-medium text-gray-300">From:</span> {{ $message->sender->name }} <span class="text-gray-500">({{ $message->sender->email }})</span>
                </div>
                <div class="mr-6 mb-2">
                    <span class="font-medium text-gray-300">To:</span> {{ $message->receiver->name }} <span class="text-gray-500">({{ $message->receiver->email }})</span>
                </div>
                <div class="mb-2">
                    <span class="font-medium text-gray-300">Date:</span> {{ $message->created_at->format('M d, Y h:i A') }}
                </div>
            </div>
            
            <div class="mt-6 p-5 bg-gray-800 bg-opacity-50 rounded-md border border-gray-700">
                <div class="text-gray-300">
                    {!! nl2br(e($message->content)) !!}
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <div>
                    @if($message->sender_id !== auth()->id())
                        <a href="{{ route('admin.messages.create', ['reply_to' => $message->id]) }}" class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white bg-accent-teal hover:bg-opacity-90 transition duration-200">
                            <svg class="mr-2 -ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                            Reply
                        </a>
                    @endif
                </div>
                
                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-700 rounded-md text-sm font-medium text-red-400 bg-card hover:bg-gray-800 transition duration-200">
                        <svg class="mr-2 -ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Reply Form -->
    @if($message->sender_id !== auth()->id())
        <div class="mt-6 glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
            <h2 class="text-lg font-medium text-white mb-4">Reply to this message</h2>
            
            <form action="{{ route('admin.messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">
                <input type="hidden" name="subject" value="Re: {{ Str::limit(str_replace('Re: ', '', $message->subject), 190) }}">
                
                <div class="mb-4">
                    <label for="content" class="block text-gray-300 text-sm font-medium mb-2">Your Reply</label>
                    <textarea name="content" id="content" rows="5" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="py-2 px-4 rounded-md text-sm font-medium text-white bg-accent-teal hover:bg-opacity-90 transition duration-200 animate-glow">
                        Send Reply
                    </button>
                </div>
            </form>
        </div>
    @endif
@endsection