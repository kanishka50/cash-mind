@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
        <h3 class="text-xl font-medium text-white">Create New User</h3>
    </div>
    
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('name') border-red-500 @enderror" 
                          placeholder="Enter user's full name" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-medium mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('email') border-red-500 @enderror" 
                          placeholder="user@example.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('password') border-red-500 @enderror" 
                          placeholder="Enter secure password" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-300 text-sm font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent" 
                          placeholder="Confirm password" required>
                </div>
            </div>
            
            <div>
                <div class="mb-4">
                    <label for="profile_picture" class="block text-gray-300 text-sm font-medium mb-2">Profile Picture</label>
                    <div class="flex items-center mt-2">
                        <div class="h-24 w-24 rounded-full bg-card flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                    </div>
                    <input type="file" name="profile_picture" id="profile_picture" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white @error('profile_picture') border-red-500 @enderror" 
                          accept="image/*">
                    <p class="mt-1 text-xs text-gray-500">Maximum file size: 1MB. Acceptable formats: JPEG, PNG, GIF.</p>
                    @error('profile_picture')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <div class="p-4 rounded-md bg-card bg-opacity-50">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_admin" id="is_admin" 
                                  class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal" 
                                  {{ old('is_admin') ? 'checked' : '' }}>
                            <span class="ml-2 text-white">Administrator</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-400">Administrators have full access to the management panel, including the ability to manage users, courses, and site content.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-6 pt-4 border-t border-gray-700">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800 transition duration-200 mr-3">
                Cancel
            </a>
            <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Create User
                </div>
            </button>
        </div>
    </form>
</div>
@endsection