@extends('layouts.admin')

@section('title', 'Create Coupon')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Create Coupon</h1>
            <div class="h-1 w-20 bg-accent-teal rounded mt-2"></div>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 bg-card text-white font-medium rounded-md hover:bg-gray-800 transition duration-200 flex items-center border border-gray-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
            </svg>
            Back to Coupons
        </a>
    </div>
    
    <!-- Form Container -->
    <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <div class="mb-4">
                        <label for="code" class="block text-gray-300 text-sm font-medium mb-2">Coupon Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white @error('code') border-red-500 @enderror" placeholder="SUMMER20" required>
                        @error('code')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="type" class="block text-gray-300 text-sm font-medium mb-2">Discount Type</label>
                        <select name="type" id="type" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white @error('type') border-red-500 @enderror" required>
                            <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                        @error('type')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="value" class="block text-gray-300 text-sm font-medium mb-2">Discount Value</label>
                        <input type="number" name="value" id="value" value="{{ old('value') }}" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white @error('value') border-red-500 @enderror" placeholder="20" step="0.01" min="0" required>
                        @error('value')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">For percentage type, enter a value between 0 and 100.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="valid_from" class="block text-gray-300 text-sm font-medium mb-2">Valid From</label>
                        <input type="date" name="valid_from" id="valid_from" value="{{ old('valid_from') }}" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white @error('valid_from') border-red-500 @enderror">
                        @error('valid_from')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="valid_until" class="block text-gray-300 text-sm font-medium mb-2">Valid Until</label>
                        <input type="date" name="valid_until" id="valid_until" value="{{ old('valid_until') }}" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white @error('valid_until') border-red-500 @enderror">
                        @error('valid_until')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="max_uses" class="block text-gray-300 text-sm font-medium mb-2">Maximum Uses</label>
                        <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses') }}" class="w-full px-3 py-2 bg-darker border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-accent-teal text-white @error('max_uses') border-red-500 @enderror" placeholder="Leave empty for unlimited" min="1">
                        @error('max_uses')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="w-4 h-4 bg-darker border-gray-700 rounded text-accent-teal focus:ring-accent-teal focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-300">Activate coupon</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <h4 class="text-lg font-medium text-white mb-2">Applicable Courses</h4>
                        <p class="text-sm text-gray-400 mb-2">Select courses this coupon can be applied to. Leave empty for all courses.</p>
                        
                        <div class="max-h-60 overflow-y-auto bg-darker border border-gray-700 rounded-md p-3">
                            @foreach($courses as $course)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="course_ids[]" id="course_{{ $course->id }}" value="{{ $course->id }}" {{ in_array($course->id, old('course_ids', [])) ? 'checked' : '' }} class="w-4 h-4 bg-darker border-gray-700 rounded text-accent-teal focus:ring-accent-teal focus:ring-opacity-50">
                                    <label for="course_{{ $course->id }}" class="ml-2 text-sm text-gray-300">{{ $course->title }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="text-lg font-medium text-white mb-2">Applicable Digital Products</h4>
                        <p class="text-sm text-gray-400 mb-2">Select digital products this coupon can be applied to. Leave empty for all products.</p>
                        
                        <div class="max-h-60 overflow-y-auto bg-darker border border-gray-700 rounded-md p-3">
                            @foreach($digitalProducts as $product)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="product_ids[]" id="product_{{ $product->id }}" value="{{ $product->id }}" {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }} class="w-4 h-4 bg-darker border-gray-700 rounded text-accent-teal focus:ring-accent-teal focus:ring-opacity-50">
                                    <label for="product_{{ $product->id }}" class="ml-2 text-sm text-gray-300">{{ $product->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-90 transition duration-200 animate-glow">
                    Create Coupon
                </button>
            </div>
        </form>
    </div>
@endsection