@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Stats Overview -->
    <div class="mt-4">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Users -->
            <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-semibold text-white mb-1">{{ $stats['total_users'] }}</h3>
                            <p class="text-gray-400">Total Users</p>
                        </div>
                        <div class="p-3 bg-accent-teal bg-opacity-20 rounded-md">
                            <svg class="w-6 h-6 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">30% from last month</span>
                            <span class="text-xs text-green-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                12.5%
                            </span>
                        </div>
                        <div class="w-full h-1 bg-gray-700 rounded-full mt-2">
                            <div class="h-1 bg-accent-teal rounded-full" style="width: 30%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Courses -->
            <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-semibold text-white mb-1">{{ $stats['total_courses'] }}</h3>
                            <p class="text-gray-400">Total Courses</p>
                        </div>
                        <div class="p-3 bg-secondary-400 bg-opacity-20 rounded-md">
                            <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">18% from last month</span>
                            <span class="text-xs text-green-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                8.2%
                            </span>
                        </div>
                        <div class="w-full h-1 bg-gray-700 rounded-full mt-2">
                            <div class="h-1 bg-secondary-400 rounded-full" style="width: 18%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total Videos -->
            <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-semibold text-white mb-1">{{ $stats['total_videos'] }}</h3>
                            <p class="text-gray-400">Total Videos</p>
                        </div>
                        <div class="p-3 bg-blue-500 bg-opacity-20 rounded-md">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">45% from last month</span>
                            <span class="text-xs text-green-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                22.5%
                            </span>
                        </div>
                        <div class="w-full h-1 bg-gray-700 rounded-full mt-2">
                            <div class="h-1 bg-blue-500 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Featured Courses -->
            <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-semibold text-white mb-1">{{ $stats['featured_courses'] }}</h3>
                            <p class="text-gray-400">Featured Courses</p>
                        </div>
                        <div class="p-3 bg-yellow-500 bg-opacity-20 rounded-md">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">15% from last month</span>
                            <span class="text-xs text-green-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                5.8%
                            </span>
                        </div>
                        <div class="w-full h-1 bg-gray-700 rounded-full mt-2">
                            <div class="h-1 bg-yellow-500 rounded-full" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Section -->
    <div class="mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Chart -->
            <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-lg font-semibold text-white">Revenue Overview</h4>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-xs bg-accent-teal bg-opacity-20 text-accent-teal rounded-md">Day</button>
                            <button class="px-3 py-1 text-xs bg-accent-teal rounded-md text-white">Week</button>
                            <button class="px-3 py-1 text-xs bg-accent-teal bg-opacity-20 text-accent-teal rounded-md">Month</button>
                        </div>
                    </div>
                    <div class="h-64 flex items-end">
                        <div class="flex-1 h-full flex items-end">
                            @for($i = 1; $i <= 7; $i++)
                                @php
                                    $heights = [60, 85, 40, 70, 90, 60, 80];
                                    $height = $heights[($i - 1) % 7];
                                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                @endphp
                                <div class="flex-1 mx-1 flex flex-col items-center">
                                    <div class="w-full bg-accent-teal bg-opacity-20 rounded-t-sm" style="height: {{ $height }}%">
                                        <div class="w-full bg-accent-teal rounded-t-sm" style="height: 40%"></div>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-400">{{ $days[($i - 1) % 7] }}</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sales by Category -->
            <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-white mb-6">Sales by Category</h4>
                    <div class="h-64 flex items-center justify-center">
                        <div class="relative w-48 h-48 rounded-full border-8 border-gray-800">
                            <!-- Pie chart segments - Using SVG for better reliability -->
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <!-- Background circle -->
                                <circle cx="50" cy="50" r="40" fill="#121b25" />
                                
                                <!-- Segment 1: 45% (Courses) - 162 degrees -->
                                <path d="M50,50 L90,50 A40,40 0 0,1 65.5,85.5 L50,50 Z" fill="#116466" />
                                
                                <!-- Segment 2: 30% (Digital Products) - 108 degrees -->
                                <path d="M50,50 L65.5,85.5 A40,40 0 0,1 13.4,67.4 L50,50 Z" fill="#D9B08C" />
                                
                                <!-- Segment 3: 25% (Subscriptions) - 90 degrees -->
                                <path d="M50,50 L13.4,67.4 A40,40 0 0,1 10,50 A40,40 0 0,1 50,10 A40,40 0 0,1 90,50 L50,50 Z" fill="#3B82F6" />
                            </svg>
                            
                            <!-- Center label -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <span class="block text-3xl font-bold text-white">75%</span>
                                    <span class="text-xs text-gray-400">Courses</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mt-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-accent-teal rounded-full mr-2"></div>
                            <div>
                                <span class="block text-xs text-gray-400">Courses</span>
                                <span class="text-sm text-white">45%</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-secondary-400 rounded-full mr-2"></div>
                            <div>
                                <span class="block text-xs text-gray-400">Digital Products</span>
                                <span class="text-sm text-white">30%</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <div>
                                <span class="block text-xs text-gray-400">Subscriptions</span>
                                <span class="text-sm text-white">25%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Latest Data Section -->
    <div class="mt-8 mb-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Courses -->
        <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-lg font-semibold text-white">Latest Courses</h4>
                    <a href="{{ route('admin.courses.index') }}" class="text-accent-teal hover:text-accent-teal hover:underline text-sm flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($latest_courses as $course)
                            <tr class="hover:bg-gray-900 hover:bg-opacity-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-card rounded-md overflow-hidden flex-shrink-0">
                                            @if($course->thumbnail)
                                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="h-8 w-8 object-cover">
                                            @else
                                                <div class="h-8 w-8 flex items-center justify-center bg-accent-teal bg-opacity-20">
                                                    <svg class="h-4 w-4 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-white">{{ Str::limit($course->title, 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($course->category)
                                        <span class="px-2 py-1 text-xs bg-accent-teal bg-opacity-10 text-accent-teal rounded-full">
                                            {{ $course->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">--</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-secondary-400 font-medium">
                                    Rs. {{ number_format($course->price, 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-400">
                                    {{ $course->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Latest Users -->
        <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-lg font-semibold text-white">Latest Users</h4>
                    <a href="{{ route('admin.users.index') }}" class="text-accent-teal hover:text-accent-teal hover:underline text-sm flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Joined</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($latest_users as $user)
                            <tr class="hover:bg-gray-900 hover:bg-opacity-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-card rounded-full overflow-hidden flex-shrink-0">
                                            @if($user->profile_picture)
                                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="h-8 w-8 object-cover">
                                            @else
                                                <div class="h-8 w-8 flex items-center justify-center bg-secondary-400 bg-opacity-20 rounded-full">
                                                    <span class="text-xs font-medium text-secondary-400">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-400">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-400">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($user->is_admin)
                                        <span class="px-2 py-1 text-xs bg-secondary-400 bg-opacity-10 text-secondary-400 rounded-full">
                                            Admin
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-accent-teal bg-opacity-10 text-accent-teal rounded-full">
                                            User
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Section -->
    <div class="mb-12">
        <h4 class="text-lg font-semibold text-white mb-4">Quick Actions</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.courses.create') }}" class="glass-effect rounded-lg overflow-hidden border border-gray-800 p-4 flex items-center hover:bg-card transition-colors duration-200">
                <div class="p-3 bg-accent-teal bg-opacity-20 rounded-md mr-4">
                    <svg class="w-6 h-6 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="text-white font-medium">New Course</h5>
                    <p class="text-xs text-gray-400">Add a new course</p>
                </div>
            </a>
            
            <a href="{{ route('admin.digital-products.create') }}" class="glass-effect rounded-lg overflow-hidden border border-gray-800 p-4 flex items-center hover:bg-card transition-colors duration-200">
                <div class="p-3 bg-secondary-400 bg-opacity-20 rounded-md mr-4">
                    <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="text-white font-medium">New Product</h5>
                    <p class="text-xs text-gray-400">Add digital product</p>
                </div>
            </a>
            
            <a href="{{ route('admin.users.create') }}" class="glass-effect rounded-lg overflow-hidden border border-gray-800 p-4 flex items-center hover:bg-card transition-colors duration-200">
                <div class="p-3 bg-blue-500 bg-opacity-20 rounded-md mr-4">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="text-white font-medium">New User</h5>
                    <p class="text-xs text-gray-400">Add user account</p>
                </div>
            </a>
            
            <a href="{{ route('admin.coupons.create') }}" class="glass-effect rounded-lg overflow-hidden border border-gray-800 p-4 flex items-center hover:bg-card transition-colors duration-200">
                <div class="p-3 bg-yellow-500 bg-opacity-20 rounded-md mr-4">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <h5 class="text-white font-medium">New Coupon</h5>
                    <p class="text-xs text-gray-400">Create discount</p>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 mb-12">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-semibold text-white">Recent Activity</h4>
                <a href="#" class="text-accent-teal hover:text-accent-teal hover:underline text-sm">View All</a>
            </div>
            
            <div class="space-y-4">
                <!-- Activity Item 1 -->
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-accent-teal bg-opacity-20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-white">
                            <span class="font-medium text-accent-teal">John Doe</span> registered as a new user
                        </p>
                        <p class="text-xs text-gray-400 mt-1">10 minutes ago</p>
                    </div>
                </div>
                
                <!-- Activity Item 2 -->
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-secondary-400 bg-opacity-20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-white">
                            <span class="font-medium text-secondary-400">Jane Smith</span> purchased <span class="font-medium text-secondary-400">Financial Management 101</span> course
                        </p>
                        <p class="text-xs text-gray-400 mt-1">45 minutes ago</p>
                    </div>
                </div>
                
                <!-- Activity Item 3 -->
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-500 bg-opacity-20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-white">
                            <span class="font-medium text-blue-500">Admin</span> uploaded <span class="font-medium text-blue-500">5 new videos</span> to Investing Basics course
                        </p>
                        <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                    </div>
                </div>
                
                <!-- Activity Item 4 -->
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-yellow-500 bg-opacity-20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-white">
                            <span class="font-medium text-yellow-500">New coupon</span> created: <span class="font-medium text-yellow-500">WELCOME25</span> with 25% discount
                        </p>
                        <p class="text-xs text-gray-400 mt-1">5 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Additional styles for dashboard */
    .glass-effect {
        background: rgba(18, 27, 37, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    @keyframes glow {
        0% {
            box-shadow: 0 0 5px rgba(17, 100, 102, 0.5);
        }
        100% {
            box-shadow: 0 0 20px rgba(17, 100, 102, 0.8);
        }
    }
    
    .animate-glow {
        animation: glow 2s ease-in-out infinite alternate;
    }
</style>
@endpush