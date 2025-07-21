@extends('layouts.admin')

@section('title', 'Send New Message')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Send New Message</h1>
            <div class="h-1 w-20 bg-accent-teal rounded mt-2"></div>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 bg-card text-white font-medium rounded-md hover:bg-gray-800 transition duration-200 flex items-center border border-gray-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
            </svg>
            Back to Messages
        </a>
    </div>
    
    <!-- Message Form Container -->
    <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
        <form action="{{ route('admin.messages.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="receiver_id" class="block text-gray-300 text-sm font-medium mb-2">Recipient</label>
                <select name="receiver_id" id="receiver_id" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white">
                    <option value="">Select recipient</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ (old('receiver_id') == $user->id || (isset($replyTo) && $replyTo->sender_id == $user->id)) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('receiver_id')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="subject" class="block text-gray-300 text-sm font-medium mb-2">Subject</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject', isset($replyTo) ? 'Re: ' . $replyTo->subject : '') }}" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white">
                @error('subject')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="content" class="block text-gray-300 text-sm font-medium mb-2">Message</label>
                <textarea name="content" id="content" rows="6" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            @if(isset($replyTo))
                <div class="mb-4 p-4 bg-gray-800 bg-opacity-50 rounded-md border border-gray-700">
                    <h4 class="text-sm font-medium text-white mb-2">Original Message:</h4>
                    <div class="text-sm text-gray-300 ml-3 border-l-2 border-accent-teal pl-3">
                        <p class="italic">{{ $replyTo->content }}</p>
                        <p class="mt-1 text-xs text-gray-400">From: {{ $replyTo->sender->name }} - {{ $replyTo->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            @endif
            
            <div class="flex justify-end">
                <a href="{{ route('admin.messages.index') }}" class="mr-3 py-2 px-4 border border-gray-700 rounded-md text-sm font-medium text-gray-300 bg-card hover:bg-gray-800 transition duration-200">
                    Cancel
                </a>
                <button type="submit" class="py-2 px-4 rounded-md text-sm font-medium text-white bg-accent-teal hover:bg-opacity-90 transition duration-200 animate-glow">
                    Send Message
                </button>
            </div>
        </form>
    </div>
@endsection