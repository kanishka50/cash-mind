@extends('layouts.user')

@section('title', 'Send New Message')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
            Send New Message
        </h1>
        
        <div class="glass-effect rounded-lg border border-gray-800 p-6">
            <form action="{{ route('user.messages.store') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label for="receiver_id" class="block text-sm font-medium text-gray-300 mb-2">Recipient</label>
                    <select name="receiver_id" id="receiver_id" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                        <option value="">Select recipient</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ (old('receiver_id') == $admin->id || (isset($replyTo) && $replyTo->sender_id == $admin->id)) ? 'selected' : '' }}>
                                {{ $admin->name }} (Support Team)
                            </option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject', isset($replyTo) ? 'Re: ' . $replyTo->subject : '') }}" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <label for="content" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                    <textarea name="content" id="content" rows="6" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                @if(isset($replyTo))
                    <div class="mb-5 p-4 bg-card rounded-lg border border-gray-800">
                        <h4 class="text-sm font-medium text-white mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                            Original Message:
                        </h4>
                        <div class="text-sm text-gray-300 ml-3 border-l-2 border-gray-700 pl-3">
                            <p class="italic">{{ $replyTo->content }}</p>
                            <p class="mt-1 text-xs text-gray-500">From: {{ $replyTo->sender->name }} - {{ $replyTo->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="flex justify-end gap-4">
                    <a href="{{ route('user.messages.index') }}" class="py-2 px-4 bg-card border border-gray-800 text-white font-medium rounded-md hover:bg-darker transition-all duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center py-2 px-4 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection