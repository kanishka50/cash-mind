@extends('layouts.admin')

@section('title', 'Create Course')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.courses.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Courses
        </a>
        <h3 class="text-xl font-medium text-white">Create New Course</h3>
    </div>
    
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4">
            <label for="title" class="block text-gray-300 text-sm font-medium mb-2">Course Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                  class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('title') border-red-500 @enderror" 
                  placeholder="Enter course title" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="5" 
                     class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('description') border-red-500 @enderror"
                     placeholder="Describe the course content and objectives">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="price" class="block text-gray-300 text-sm font-medium mb-2">Price (LKR)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400">Rs.</span>
                    </div>
                    <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 pl-12 pr-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('price') border-red-500 @enderror"
                          placeholder="0.00" required>
                </div>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="category_id" class="block text-gray-300 text-sm font-medium mb-2">Category</label>
                <select name="category_id" id="category_id" 
                       class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('category_id') border-red-500 @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-4">
            <label for="tags" class="block text-gray-300 text-sm font-medium mb-2">Tags</label>
            <select name="tags[]" id="tags" multiple 
                   class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('tags') border-red-500 @enderror">
                @foreach($tags as $id => $name)
                    <option value="{{ $id }}" {{ (old('tags') && in_array($id, old('tags'))) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <p class="text-gray-500 text-xs mt-1">Hold Ctrl (PC) or Command (Mac) to select multiple tags</p>
            @error('tags')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="thumbnail" class="block text-gray-300 text-sm font-medium mb-2">Thumbnail Image</label>
            <div class="mt-1 flex items-center">
                <span class="inline-block h-20 w-20 rounded-md overflow-hidden bg-gray-800">
                    <svg class="h-full w-full text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </span>
                <input type="file" name="thumbnail" id="thumbnail" 
                      class="ml-5 py-2 @error('thumbnail') border-red-500 @enderror" 
                      accept="image/*">
            </div>
            @error('thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_featured" 
                      class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal" 
                      {{ old('is_featured') ? 'checked' : '' }}>
                <span class="ml-2 text-gray-300">Featured Course</span>
            </label>
        </div>
        
        <div class="flex items-center justify-end">
            <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                Create Course
            </button>
        </div>
    </form>
</div>
@endsection