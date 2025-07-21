@extends('layouts.admin')

@section('title', 'Course Videos')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="{{ route('admin.courses.index') }}" class="text-accent-teal hover:text-accent-light flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Courses
            </a>
            <h3 class="text-xl font-medium text-white mt-2">
                <span class="text-gray-400 text-sm">Course:</span> 
                <span class="text-accent-teal">{{ $course->title }}</span>
            </h3>
        </div>
        <a href="{{ route('admin.videos.create', ['course_id' => $course->id]) }}" class="px-4 py-2 bg-accent-teal hover:bg-primary-500 text-white rounded-md transition duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Video
        </a>
    </div>
    
  @if($videos->isEmpty())
    <div class="text-center py-12 glass-effect rounded-lg">
        <svg class="mx-auto h-16 w-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-white">No videos found</h3>
        <p class="mt-1 text-gray-500">This course doesn't have any videos yet.</p>
        <div class="mt-6">
            <a href="{{ route('admin.videos.create', ['course_id' => $course->id]) }}" class="px-4 py-2 bg-accent-teal hover:bg-primary-500 text-white rounded-md transition duration-200 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add First Video
            </a>
        </div>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Order
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Duration
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
                @foreach ($videos as $video)
                <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        <span class="px-2 py-1 rounded-md bg-gray-800 text-gray-300">{{ $video->order_number }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded bg-primary-400 bg-opacity-20 flex items-center justify-center">
                                <svg class="h-6 w-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-white">{{ $video->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        @if($video->duration)
                            <span class="px-2 py-1 rounded-md bg-blue-900 bg-opacity-30 text-blue-400">
                                {{ gmdate('H:i:s', $video->duration) }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-md bg-gray-800 text-gray-400">Unknown</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($video->is_preview)
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-green-900 bg-opacity-30 text-green-400">
                                Preview
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-gray-800 text-gray-400">
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
                @endforeach
            </tbody>
        </table>
    </div>
@endif
</div>
@endsection