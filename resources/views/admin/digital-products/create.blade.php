@extends('layouts.admin')

@section('title', 'Create Digital Product')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.digital-products.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
        <h3 class="text-xl font-medium text-white">Create New Digital Product</h3>
    </div>
    
    <form action="{{ route('admin.digital-products.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('name') border-red-500 @enderror" 
                          placeholder="Windows 10 Pro License" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" 
                             class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('description') border-red-500 @enderror" 
                             placeholder="Provide details about this digital product...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-300 text-sm font-medium mb-2">Price (LKR)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">Rs.</span>
                        </div>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 pl-12 pr-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('price') border-red-500 @enderror" 
                              placeholder="1500.00" required>
                    </div>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="type" class="block text-gray-300 text-sm font-medium mb-2">Product Type</label>
                    <select name="type" id="type" 
                           class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('type') border-red-500 @enderror" 
                           required>
                        <option value="license_key" {{ old('type') === 'license_key' ? 'selected' : '' }}>License Key</option>
                        <option value="account_credentials" {{ old('type') === 'account_credentials' ? 'selected' : '' }}>Account Credentials</option>
                        <option value="digital_asset" {{ old('type') === 'digital_asset' ? 'selected' : '' }}>Digital Asset</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4 p-4 rounded-md bg-card bg-opacity-50">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" 
                              {{ old('is_featured') ? 'checked' : '' }} 
                              class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal">
                        <span class="ml-2 text-white">Feature this product</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-400 ml-6">Featured products appear prominently on the homepage.</p>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-6 pt-4 border-t border-gray-700">
            <a href="{{ route('admin.digital-products.index') }}" class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800 transition duration-200 mr-3">
                Cancel
            </a>
            <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Product
                </div>
            </button>
        </div>
    </form>
</div>
@endsection