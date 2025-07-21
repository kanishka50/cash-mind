@extends('layouts.user')

@section('title', 'Edit Profile')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Edit Profile
        </h1>
        
        @if (session('success'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        @if (session('error'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-red-500 text-red-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif
        
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Picture Section -->
            <div class="glass-effect rounded-lg border border-gray-800 p-6">
                <h2 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Profile Picture
                </h2>
                
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 bg-darker rounded-full overflow-hidden mb-4 border-2 border-accent-teal/30">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-darker text-accent-teal/70">
                                <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <form action="{{ route('user.profile.update-picture') }}" method="POST" enctype="multipart/form-data" class="w-full">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="profile_picture" class="block text-sm font-medium text-gray-300 mb-2">Upload New Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent-teal/20 file:text-accent-teal hover:file:bg-accent-teal/30 cursor-pointer">
                            @error('profile_picture')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between flex-wrap gap-3">
                            <button type="submit" name="update_picture" value="1" class="py-2 px-4 bg-accent-teal hover:bg-opacity-80 text-white rounded-md text-sm font-medium transition-all duration-300">
                                Update Picture
                            </button>
                            
                            @if($user->profile_picture)
                                <a href="{{ route('user.profile.delete-picture') }}" onclick="return confirm('Are you sure you want to remove your profile picture?')" class="py-2 px-4 bg-red-900/20 text-red-400 hover:bg-red-900/30 rounded-md text-sm font-medium transition-all duration-300">
                                    Remove
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Profile Information Section -->
            <div class="glass-effect rounded-lg border border-gray-800 p-6 md:col-span-2">
                <h2 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Profile Information
                </h2>
                
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6 border-t border-gray-800 pt-6 mt-6">
                        <h3 class="text-md font-medium text-white mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Change Password
                        </h3>
                        <p class="text-sm text-gray-400 mb-4">Leave blank if you don't want to change your password</p>
                        
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                            <input type="password" name="password" id="password" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                            @error('password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 bg-darker text-white border border-gray-800 rounded-md focus:outline-none focus:ring-accent-teal focus:border-accent-teal">
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="py-2 px-4 bg-accent-teal hover:bg-opacity-80 text-white rounded-md text-sm font-medium transition-all duration-300">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Account Information Section -->
            <div class="glass-effect rounded-lg border border-gray-800 p-6 md:col-span-3">
                <h2 class="text-lg font-medium text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Account Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-card p-4 rounded-lg border border-gray-800">
                        <p class="text-sm text-gray-400 mb-1">Member Since</p>
                        <p class="text-md font-medium text-white">{{ $user->created_at->format('F j, Y') }}</p>
                    </div>
                    
                    @if($user->email_verified_at)
                    <div class="bg-card p-4 rounded-lg border border-gray-800">
                        <p class="text-sm text-gray-400 mb-1">Email Verified</p>
                        <p class="text-md font-medium text-green-400">{{ $user->email_verified_at->format('F j, Y') }}</p>
                    </div>
                    @else
                    <div class="bg-card p-4 rounded-lg border border-gray-800">
                        <p class="text-sm text-gray-400 mb-1">Email Verification</p>
                        <p class="text-md font-medium text-yellow-400 mb-2">Not Verified</p>
                        <form action="{{ route('verification.send') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm text-accent-teal hover:text-accent-teal/80 transition-colors duration-200 inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Resend Verification Email
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection