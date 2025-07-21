@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
        <h3 class="text-xl font-medium text-white">Edit User: <span class="text-accent-teal">{{ $user->name }}</span></h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Picture Section -->
        <div class="glass-effect rounded-lg border border-gray-700 p-6">
            <h2 class="text-lg font-medium text-white mb-4">Profile Picture</h2>
            
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-card text-gray-500">
                            <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <form action="{{ route('admin.users.update-picture', $user) }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="profile_picture" class="block text-sm font-medium text-gray-300 mb-1">Upload New Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white @error('profile_picture') border-red-500 @enderror" 
                              accept="image/*">
                        @error('profile_picture')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="submit" name="update_picture" value="1" 
                                class="bg-accent-teal hover:bg-primary-500 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-200">
                            Update Picture
                        </button>
                        
                        @if($user->profile_picture)
                            <a href="{{ route('admin.users.delete-picture', $user) }}" 
                               onclick="return confirm('Are you sure you want to remove the profile picture?')" 
                               class="bg-gray-700 hover:bg-gray-600 text-gray-300 text-sm font-medium py-2 px-4 rounded-md transition duration-200">
                                Remove
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        
        <!-- User Information Section -->
        <div class="glass-effect rounded-lg border border-gray-700 p-6 md:col-span-2">
            <h2 class="text-lg font-medium text-white mb-4">User Information</h2>
            
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6 p-4 rounded-lg bg-card bg-opacity-70">
                    <h3 class="text-md font-medium text-white mb-2">Change Password</h3>
                    <p class="text-sm text-gray-400 mb-4">Leave blank if you don't want to change the password</p>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">New Password</label>
                        <input type="password" name="password" id="password" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('password') border-red-500 @enderror" 
                              placeholder="Enter new password">
                       @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent" 
                              placeholder="Confirm new password">
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-center p-4 rounded-lg bg-card bg-opacity-50">
                        <input type="checkbox" name="is_admin" id="is_admin" 
                              class="rounded bg-darker border-gray-700 text-accent-teal focus:ring-accent-teal" 
                              {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label for="is_admin" class="ml-2 block text-white">
                            Administrator
                        </label>
                        <div class="ml-auto">
                            @if($user->is_admin)
                                <span class="px-2 py-1 text-xs rounded-full bg-secondary-400 bg-opacity-20 text-secondary-400">Admin</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-accent-teal bg-opacity-20 text-accent-teal">Customer</span>
                            @endif
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400 ml-4">Administrators have full access to the management panel.</p>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- User Activity Section -->
    <div class="mt-6 glass-effect rounded-lg border border-gray-700 p-6">
        <h2 class="text-lg font-medium text-white mb-4">User Activity</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-card bg-opacity-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-400">Registered</h3>
                <p class="mt-1 text-lg font-semibold text-white">{{ $user->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
            </div>
            
            <div class="bg-card bg-opacity-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-400">Email Status</h3>
                @if($user->email_verified_at)
                    <p class="mt-1 text-lg font-semibold text-green-400">Verified</p>
                    <p class="text-xs text-gray-500">{{ $user->email_verified_at->format('M d, Y') }}</p>
                @else
                    <p class="mt-1 text-lg font-semibold text-yellow-400">Not Verified</p>
                    <button type="button" class="mt-1 text-xs text-accent-teal hover:text-accent-light">
                        Resend Verification Email
                    </button>
                @endif
            </div>
            
            <div class="bg-card bg-opacity-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-400">Courses Purchased</h3>
                <p class="mt-1 text-lg font-semibold text-white">{{ $user->userCourses->count() }}</p>
                <a href="#" class="text-xs text-accent-teal hover:text-accent-light flex items-center mt-1">
                    <span>View Courses</span>
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            <div class="bg-card bg-opacity-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-400">Total Orders</h3>
                <p class="mt-1 text-lg font-semibold text-white">{{ $user->orders->count() }}</p>
                <a href="#" class="text-xs text-accent-teal hover:text-accent-light flex items-center mt-1">
                    <span>View Orders</span>
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        @if(auth()->id() !== $user->id)
            <div class="mt-6 border-t border-gray-700 pt-6">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone and will delete all associated data.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="mr-2 -ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete User Account
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection