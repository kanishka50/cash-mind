@props(['notification'])

<div class="bg-card rounded-lg shadow-md overflow-hidden border border-gray-800 {{ $notification->is_read ? '' : 'border-l-4 border-primary-500' }}">
    <div class="p-4">
        <div class="flex justify-between items-start">
            <div class="flex items-start">
                @switch($notification->type)
                    @case('welcome')
                        <div class="rounded-full bg-green-500/20 p-2 mr-3">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        @break
                    @case('subscription_expiring')
                        <div class="rounded-full bg-yellow-500/20 p-2 mr-3">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        @break
                    @case('new_course_added')
                        <div class="rounded-full bg-blue-500/20 p-2 mr-3">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        @break
                    @case('purchase_success')
                        <div class="rounded-full bg-green-500/20 p-2 mr-3">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        @break
                    @default
                        <div class="rounded-full bg-gray-700 p-2 mr-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                @endswitch
                
                <div>
                    <h3 class="font-medium text-gray-100">{{ $notification->title }}</h3>
                    <p class="mt-1 text-sm text-gray-300">{{ $notification->content }}</p>
                    <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </div>
            
            <form action="{{ route('user.notifications.mark-read', $notification) }}" method="POST">
                @csrf
                @method('PATCH')
                @if(!$notification->is_read)
                    <button type="submit" class="inline-flex items-center p-1 border border-transparent text-xs font-medium rounded text-primary-400 bg-primary-500/10 hover:bg-primary-500/20 transition-colors duration-200">
                        Mark as read
                    </button>
                @endif
            </form>
        </div>
        
        @if(isset($notification->data['url']))
            <div class="mt-3 flex justify-end">
                <a href="{{ $notification->data['url'] }}" class="inline-flex items-center px-3 py-1.5 text-sm leading-5 font-medium rounded-md text-primary-400 bg-primary-500/10 hover:bg-primary-500/20 transition-colors duration-200">
                    View Details
                </a>
            </div>
        @endif
    </div>
</div>