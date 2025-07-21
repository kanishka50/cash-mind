@extends('layouts.admin')

@section('title', 'Manage Messages')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Messages</h1>
            <div class="h-1 w-20 bg-accent-teal rounded mt-2"></div>
        </div>
        <a href="{{ route('admin.messages.create') }}" class="px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-90 transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            New Message
        </a>
    </div>
    
    <!-- Message Tabs & Search -->
    <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-4 mb-6">
        <div class="flex justify-between items-center">
            <div class="flex">
                <button class="px-4 py-2 {{ request()->get('filter') !== 'sent' ? 'text-accent-teal border-b-2 border-accent-teal' : 'text-gray-400 hover:text-white border-b-2 border-transparent hover:border-gray-700' }}" onclick="window.location='{{ route('admin.messages.index') }}'">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Inbox
                    </div>
                </button>
                <button class="ml-4 px-4 py-2 {{ request()->get('filter') === 'sent' ? 'text-accent-teal border-b-2 border-accent-teal' : 'text-gray-400 hover:text-white border-b-2 border-transparent hover:border-gray-700' }}" onclick="window.location='{{ route('admin.messages.index', ['filter' => 'sent']) }}'">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Sent
                    </div>
                </button>
            </div>
            
            <form action="{{ route('admin.messages.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Search messages" value="{{ request()->get('search') }}" class="px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white text-sm">
                <button type="submit" class="ml-2 p-2 bg-accent-teal bg-opacity-20 text-accent-teal rounded-md hover:bg-opacity-30 transition duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Content -->
    @if($messages->isEmpty())
        <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-10 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-white">No messages found</h3>
            <p class="mt-2 text-gray-400">
                {{ request()->get('filter') === 'sent' ? 'You haven\'t sent any messages yet.' : 'Your inbox is empty.' }}
            </p>
            <div class="mt-6">
                <a href="{{ route('admin.messages.create') }}" class="px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-90 transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Compose New Message
                </a>
            </div>
        </div>
    @else
        <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-800">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                {{ request()->get('filter') === 'sent' ? 'To' : 'From' }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-900 hover:bg-opacity-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-white">
                                        {{ request()->get('filter') === 'sent' ? $message->receiver->name : $message->sender->name }}
                                    </div>
                                    <div class="text-sm text-gray-400">
                                        {{ request()->get('filter') === 'sent' ? $message->receiver->email : $message->sender->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="text-accent-teal hover:text-white transition duration-200">
                                        {{ Str::limit($message->subject, 50) }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                    {{ $message->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($message->receiver_id === auth()->id() && !$message->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-teal bg-opacity-10 text-accent-teal">
                                            Unread
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 bg-opacity-50 text-gray-300">
                                            {{ $message->receiver_id === auth()->id() ? 'Read' : 'Sent' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="text-accent-teal hover:text-white transition duration-200 mr-3">
                                        View
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition duration-200">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $messages->appends(request()->query())->links() }}
        </div>
    @endif
@endsection