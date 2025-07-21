@extends('layouts.admin')

@section('title', 'All Videos')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-medium text-white">Video Management</h3>
        <a href="{{ route('admin.videos.create') }}" class="px-4 py-2 bg-accent-teal hover:bg-primary-500 text-white rounded-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Video
            </div>
        </a>
    </div>
    
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Course
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Duration
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Order
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Preview
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($videos as $video)
                <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded bg-blue-500 bg-opacity-20 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-white">{{ $video->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.courses.videos', $video->course_id) }}" class="text-accent-teal hover:text-accent-light">
                            {{ $video->course->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($video->duration)
                            <span class="px-2 py-1 rounded-md bg-blue-900 bg-opacity-30 text-blue-400">
                                {{ gmdate('H:i:s', $video->duration) }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-md bg-gray-800 text-gray-400">Unknown</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        <span class="px-2 py-1 rounded-md bg-gray-800 text-gray-300">{{ $video->order_number }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($video->is_preview)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900 bg-opacity-30 text-green-400">
                                Preview
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-800 text-gray-400">
                                Members Only
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.videos.edit', $video) }}" class="text-accent-teal hover:text-accent-light mr-3" title="Edit Video">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400" 
                                    onclick="return confirm('Are you sure you want to delete this video?')" title="Delete Video">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-400">
                        No videos found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection