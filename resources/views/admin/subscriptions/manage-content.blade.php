@extends('layouts.admin')

@section('title', 'Manage Subscription Content')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.subscriptions.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Plans
        </a>
        <h3 class="text-xl font-medium text-white">Manage Content: <span class="text-accent-teal">{{ $subscription->name }}</span></h3>
    </div>
    
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    <form action="{{ route('admin.subscriptions.update-content', $subscription) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Courses Section -->
            <div class="glass-effect rounded-lg border border-gray-700 p-4">
                <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Courses
                </h4>
                
                <div class="relative">
                    <input type="text" id="course-search" placeholder="Search courses..." 
                           class="mb-2 bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent">
                </div>
                
                <div class="mt-2 max-h-96 overflow-y-auto p-2 border border-gray-700 rounded-md bg-card bg-opacity-50">
                    @if($courses->isEmpty())
                        <p class="text-gray-400 p-4 text-center">No courses available.</p>
                    @else
                        <div id="courses-container">
                            @foreach($courses as $course)
                                <div class="flex items-center p-2 hover:bg-card hover:bg-opacity-70 transition-colors duration-150 rounded-md course-item">
                                    <input type="checkbox" name="course_ids[]" id="course_{{ $course->id }}" value="{{ $course->id }}" 
                                           class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal" 
                                           {{ in_array($course->id, $planCourseIds) ? 'checked' : '' }}>
                                    <label for="course_{{ $course->id }}" class="ml-2 text-gray-300 cursor-pointer flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 mr-2 rounded bg-accent-teal bg-opacity-20 flex items-center justify-center text-accent-teal">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        {{ $course->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        <span id="courses-selected">{{ count($planCourseIds) }}</span> courses selected
                    </div>
                    <div>
                        <button type="button" id="select-all-courses" class="text-xs text-accent-teal hover:text-accent-light mr-2">Select All</button>
                        <button type="button" id="deselect-all-courses" class="text-xs text-accent-teal hover:text-accent-light">Deselect All</button>
                    </div>
                </div>
            </div>
            
            <!-- Digital Products Section -->
            <div class="glass-effect rounded-lg border border-gray-700 p-4">
                <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Digital Products
                </h4>
                
                <div class="relative">
                    <input type="text" id="product-search" placeholder="Search products..." 
                           class="mb-2 bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent">
                </div>
                
                <div class="mt-2 max-h-96 overflow-y-auto p-2 border border-gray-700 rounded-md bg-card bg-opacity-50">
                    @if($digitalProducts->isEmpty())
                        <p class="text-gray-400 p-4 text-center">No digital products available.</p>
                    @else
                        <div id="products-container">
                            @foreach($digitalProducts as $product)
                                <div class="flex items-center p-2 hover:bg-card hover:bg-opacity-70 transition-colors duration-150 rounded-md product-item">
                                    <input type="checkbox" name="product_ids[]" id="product_{{ $product->id }}" value="{{ $product->id }}" 
                                           class="rounded bg-darker border-gray-700 text-secondary-400 focus:ring-secondary-400" 
                                           {{ in_array($product->id, $planProductIds) ? 'checked' : '' }}>
                                    <label for="product_{{ $product->id }}" class="ml-2 text-gray-300 cursor-pointer flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 mr-2 rounded bg-secondary-400 bg-opacity-20 flex items-center justify-center text-secondary-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                        {{ $product->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        <span id="products-selected">{{ count($planProductIds) }}</span> products selected
                    </div>
                    <div>
                        <button type="button" id="select-all-products" class="text-xs text-secondary-400 hover:text-secondary-300 mr-2">Select All</button>
                        <button type="button" id="deselect-all-products" class="text-xs text-secondary-400 hover:text-secondary-300">Deselect All</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 p-4 border-t border-gray-700 pt-6 glass-effect rounded-lg bg-card bg-opacity-30">
            <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Plan Content Summary
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center p-3 bg-darker rounded-md">
                    <div class="h-10 w-10 rounded-md bg-accent-teal bg-opacity-20 flex items-center justify-center text-accent-teal">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-400">Total Courses</div>
                        <div class="text-xl font-medium text-white" id="course-count">{{ count($planCourseIds) }}</div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-darker rounded-md">
                    <div class="h-10 w-10 rounded-md bg-secondary-400 bg-opacity-20 flex items-center justify-center text-secondary-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-400">Total Digital Products</div>
                        <div class="text-xl font-medium text-white" id="product-count">{{ count($planProductIds) }}</div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.subscriptions.index') }}" class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800 transition duration-200 mr-3">
                    Cancel
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Content Selection
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update course count when checkboxes change
        const courseCheckboxes = document.querySelectorAll('input[name="course_ids[]"]');
        const courseCount = document.getElementById('course-count');
        const coursesSelected = document.getElementById('courses-selected');
        
        courseCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('input[name="course_ids[]"]:checked').length;
                courseCount.textContent = checkedCount;
                coursesSelected.textContent = checkedCount;
            });
        });
        
        // Update product count when checkboxes change
        const productCheckboxes = document.querySelectorAll('input[name="product_ids[]"]');
        const productCount = document.getElementById('product-count');
        const productsSelected = document.getElementById('products-selected');
        
        productCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('input[name="product_ids[]"]:checked').length;
                productCount.textContent = checkedCount;
                productsSelected.textContent = checkedCount;
            });
        });
        
        // Course search functionality
        const courseSearch = document.getElementById('course-search');
        const courseItems = document.querySelectorAll('.course-item');
        
        courseSearch.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            
            courseItems.forEach(item => {
                const courseTitle = item.querySelector('label').textContent.toLowerCase();
                if (courseTitle.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Product search functionality
        const productSearch = document.getElementById('product-search');
        const productItems = document.querySelectorAll('.product-item');
        
        productSearch.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            
            productItems.forEach(item => {
                const productName = item.querySelector('label').textContent.toLowerCase();
                if (productName.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Select/Deselect all courses
        const selectAllCourses = document.getElementById('select-all-courses');
        const deselectAllCourses = document.getElementById('deselect-all-courses');
        
        selectAllCourses.addEventListener('click', function() {
            courseCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            const checkedCount = courseCheckboxes.length;
            courseCount.textContent = checkedCount;
            coursesSelected.textContent = checkedCount;
        });
        
        deselectAllCourses.addEventListener('click', function() {
            courseCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            courseCount.textContent = 0;
            coursesSelected.textContent = 0;
        });
        
        // Select/Deselect all products
        const selectAllProducts = document.getElementById('select-all-products');
        const deselectAllProducts = document.getElementById('deselect-all-products');
        
        selectAllProducts.addEventListener('click', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            const checkedCount = productCheckboxes.length;
            productCount.textContent = checkedCount;
            productsSelected.textContent = checkedCount;
        });
        
        deselectAllProducts.addEventListener('click', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            productCount.textContent = 0;
            productsSelected.textContent = 0;
        });
    });
</script>
@endsection