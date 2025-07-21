@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.categories.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
        <h3 class="text-xl font-medium text-white">Create New Category</h3>
    </div>
    
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Category Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                  class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('name') border-red-500 @enderror" 
                  placeholder="Enter category name" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="3" 
                     class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('description') border-red-500 @enderror"
                     placeholder="Provide a description for this category">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-end">
            <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Category
                </div>
            </button>
        </div>
    </form>
</div>
@endsection