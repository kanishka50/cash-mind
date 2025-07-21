@props(['message', 'showActions' => true])

<div class="bg-card rounded-lg shadow-md overflow-hidden border border-gray-800 {{ $message->is_read ? '' : 'border-l-4 border-accent-teal' }} transition-all duration-300 hover:shadow-xl hover:shadow-accent-teal/10">
    <div class="p-5">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-medium text-white group-hover:text-accent-teal transition-colors duration-300">
                    {{ $message->subject }}
                </h3>
                <div class="text-sm text-gray-400 mt-1">
                    @if($message->sender_id === auth()->id())
                        <span>To: <span class="text-secondary-400">{{ $message->receiver->name }}</span></span>
                    @else
                        <span>From: <span class="text-secondary-400">{{ $message->sender->name }}</span></span>
                    @endif
                    <span class="mx-1">&bullet;</span>
                    <span>{{ $message->created_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>
            @if(!$message->is_read && $message->receiver_id === auth()->id())
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-teal/20 text-accent-teal animate-pulse">
                    New
                </span>
            @endif
        </div>

        @if(isset($preview) && $preview)
            <p class="mt-3 text-sm text-gray-300 line-clamp-2">
                {{ Str::limit($message->content, 100) }}
            </p>
        @else
            <div class="mt-4 text-sm text-gray-300 prose max-w-none">
                {!! nl2br(e($message->content)) !!}
            </div>
        @endif

        @if($showActions)
            <div class="mt-5 flex justify-end space-x-3">
                @if($message->receiver_id === auth()->id())
                    <a href="{{ auth()->user()->is_admin ? route('admin.messages.create', ['reply_to' => $message->id]) : route('user.messages.create', ['reply_to' => $message->id]) }}" 
                       class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-accent-teal hover:bg-opacity-80 transition-all duration-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Reply
                    </a>
                @endif
                <form action="{{ auth()->user()->is_admin ? route('admin.messages.destroy', $message) : route('user.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md text-white bg-red-600 bg-opacity-50 hover:bg-opacity-70 transition-all duration-300">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>