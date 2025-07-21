@extends('layouts.admin')

@section('title', 'Edit Video')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.courses.videos', $video->course_id) }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Course Videos
        </a>
        <h3 class="text-xl font-medium text-white">Edit Video: <span class="text-accent-teal">{{ $video->title }}</span></h3>
    </div>
    
    <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data" id="video-upload-form">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="course_id" class="block text-gray-300 text-sm font-medium mb-2">Course</label>
            <select name="course_id" id="course_id" 
                   class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('course_id') border-red-500 @enderror" 
                   required>
                <option value="">Select Course</option>
                @foreach($courses as $id => $title)
                    <option value="{{ $id }}" {{ old('course_id', $video->course_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                @endforeach
            </select>
            @error('course_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="title" class="block text-gray-300 text-sm font-medium mb-2">Video Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" 
                  class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('title') border-red-500 @enderror" 
                  placeholder="Enter video title" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="3" 
                     class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('description') border-red-500 @enderror"
                     placeholder="Provide a description of the video content">{{ old('description', $video->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-300 text-sm font-medium mb-2">Current Video File</label>
            <div class="p-3 rounded-md bg-card flex items-center">
                <div class="rounded-md bg-blue-900 bg-opacity-20 p-2 mr-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-gray-300">{{ basename($video->file_path) }}</span>
            </div>
            
            <label for="video" class="block text-gray-300 text-sm font-medium mt-4 mb-2">Replace Video File</label>
            <input type="file" name="video" id="video" 
                  class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('video') border-red-500 @enderror" 
                  accept="video/mp4,video/x-m4v,video/*">
            <p class="text-gray-500 text-xs mt-1">Accepted formats: MP4, MOV, AVI (up to 2GB). Leave empty to keep current video.</p>
            @error('video')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            
            <!-- Progress bar (hidden by default) -->
            <div id="upload-progress-container" class="hidden mt-4">
                <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-blue-400">Uploading...</span>
                    <span class="text-sm font-medium text-blue-400" id="progress-percentage">0%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2.5">
                    <div class="bg-accent-teal h-2.5 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                </div>
                <p class="text-sm text-gray-400 mt-2" id="upload-status">Preparing upload...</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="duration" class="block text-gray-300 text-sm font-medium mb-2">Duration (seconds)</label>
                <input type="number" name="duration" id="duration" value="{{ old('duration', $video->duration) }}" 
                      class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('duration') border-red-500 @enderror" 
                      placeholder="e.g. 300 for 5 minutes">
                <p class="text-gray-500 text-xs mt-1">Leave empty to auto-detect duration</p>
                @error('duration')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="order_number" class="block text-gray-300 text-sm font-medium mb-2">Order Number</label>
                <input type="number" name="order_number" id="order_number" value="{{ old('order_number', $video->order_number) }}" min="1" 
                      class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('order_number') border-red-500 @enderror" 
                      placeholder="e.g. 1">
                <p class="text-gray-500 text-xs mt-1">Sequence in course (1 = first video)</p>
                @error('order_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_preview" 
                      class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal" 
                      {{ old('is_preview', $video->is_preview) ? 'checked' : '' }}>
                <span class="ml-2 text-gray-300">Make this video available as a free preview</span>
            </label>
            <p class="text-gray-500 text-xs mt-1 ml-6">Preview videos can be watched without purchasing the course</p>
        </div>
        
        <div class="flex items-center justify-end">
            <button type="submit" id="upload-button" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Update Video
                </div>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="{{ asset('js/chunked-upload.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('video-upload-form');
    const videoInput = document.getElementById('video');
    const uploadButton = document.getElementById('upload-button');
    const progressContainer = document.getElementById('upload-progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressPercentage = document.getElementById('progress-percentage');
    const uploadStatus = document.getElementById('upload-status');

    form.addEventListener('submit', async function(e) {
        const file = videoInput.files[0];
        
        // Use chunked upload for files larger than 30MB (to avoid PHP post_max_size limits)
        if (file && file.size > 30 * 1024 * 1024) {
            e.preventDefault();
            
            // Show progress container
            progressContainer.classList.remove('hidden');
            uploadButton.disabled = true;
            uploadButton.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...';
            
            const upload = new ChunkedUpload(file, {
                uploadUrl: '{{ route("admin.videos.upload-chunk") }}',
                completeUrl: '{{ route("admin.videos.complete-upload") }}',
                onProgress: (progress) => {
                    progressBar.style.width = progress + '%';
                    progressPercentage.textContent = Math.round(progress) + '%';
                    uploadStatus.textContent = `Uploading... ${Math.round(progress)}%`;
                },
                onComplete: (data) => {
                    uploadStatus.textContent = 'Upload complete! Processing...';
                    
                    // Add the uploaded file path as a hidden input
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'uploaded_file_path';
                    hiddenInput.value = data.filePath;
                    form.appendChild(hiddenInput);
                    
                    // Remove required attribute from file input
                    videoInput.removeAttribute('required');
                    videoInput.value = '';
                    
                    // Submit the form
                    form.submit();
                },
                onError: (error) => {
                    alert('Upload failed: ' + error.message);
                    uploadButton.disabled = false;
                    uploadButton.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>Update Video';
                    progressContainer.classList.add('hidden');
                }
            });
            
            upload.start();
        }
    });
});
</script>
@endpush
@endsection