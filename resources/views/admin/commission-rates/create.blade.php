<!-- resources/views/admin/commission-rates/create.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container px-6 py-8 mx-auto">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-white">Add Commission Rate</h2>
        <a href="{{ route('admin.commission-rates.index') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-md hover:bg-gray-600 transition duration-200">
            Back to Commission Rates
        </a>
    </div>

    @if(session('error'))
    <div class="mt-4 p-4 bg-red-500 bg-opacity-20 text-red-400 rounded-md">
        {{ session('error') }}
    </div>
    @endif

    <div class="mt-8 bg-card rounded-lg p-6">
        <form action="{{ route('admin.commission-rates.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="item_type" class="block text-sm font-medium text-gray-400 mb-1">Item Type</label>
                <select id="item_type" name="item_type" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                    <option value="" disabled {{ request()->has('item_type') ? '' : 'selected' }}>Select Item Type</option>
                    <option value="course" {{ request()->get('item_type') == 'course' ? 'selected' : '' }}>Course</option>
                    <option value="digital_product" {{ request()->get('item_type') == 'digital_product' ? 'selected' : '' }}>Digital Product</option>
                </select>
                @error('item_type')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4 course-select {{ request()->get('item_type') == 'course' ? '' : 'hidden' }}">
                <label for="course_id" class="block text-sm font-medium text-gray-400 mb-1">Course</label>
                <select id="course_id" name="item_id" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                    <option value="" disabled {{ request()->has('item_id') && request()->get('item_type') == 'course' ? '' : 'selected' }}>Select Course</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request()->get('item_id') == $course->id && request()->get('item_type') == 'course' ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('item_id')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4 product-select {{ request()->get('item_type') == 'digital_product' ? '' : 'hidden' }}">
                <label for="product_id" class="block text-sm font-medium text-gray-400 mb-1">Digital Product</label>
                <select id="product_id" name="item_id" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                    <option value="" disabled {{ request()->has('item_id') && request()->get('item_type') == 'digital_product' ? '' : 'selected' }}>Select Digital Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request()->get('item_id') == $product->id && request()->get('item_type') == 'digital_product' ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('item_id')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="rate" class="block text-sm font-medium text-gray-400 mb-1">Commission Rate (%)</label>
                <input type="number" id="rate" name="rate" min="0" max="100" step="0.01" value="{{ old('rate', 10) }}" class="w-full bg-darker border border-gray-700 rounded-md py-2 px-3 text-gray-300 focus:outline-none focus:ring-1 focus:ring-accent-teal">
                @error('rate')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal">
                    <span class="ml-2 text-sm text-gray-300">Active</span>
                </label>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-accent-teal text-white rounded-md hover:bg-opacity-90 transition duration-200">
                    Create Commission Rate
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemTypeSelect = document.getElementById('item_type');
        const courseSelect = document.querySelector('.course-select');
        const productSelect = document.querySelector('.product-select');
        
        itemTypeSelect.addEventListener('change', function() {
            if (this.value === 'course') {
                courseSelect.classList.remove('hidden');
                productSelect.classList.add('hidden');
            } else if (this.value === 'digital_product') {
                courseSelect.classList.add('hidden');
                productSelect.classList.remove('hidden');
            }
        });
    });
</script>
@endsection