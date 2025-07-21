@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-accent-teal/5 rounded-full filter blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary-400/5 rounded-full filter blur-3xl"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23116466\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Logo and title -->
        <div class="text-center">
            <h1 class="text-center text-3xl md:text-4xl font-bold text-white mb-2">
                Welcome to <span class="text-accent-teal">Cash</span>Mind
            </h1>
            <div class="h-1 w-20 bg-accent-teal mx-auto rounded"></div>
            <p class="mt-4 text-center text-gray-300">
                Sign in to access your account
            </p>
        </div>
        
        <!-- Login form -->
        <div class="glass-effect rounded-lg shadow-xl p-8 border border-gray-800">
            <form class="mt-2 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email address</label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               class="appearance-none block w-full pl-10 pr-3 py-3 bg-darker border border-gray-700 rounded-md shadow-sm placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-accent-teal transition-all duration-300 text-sm">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <a href="{{ route('password.request') }}" class="text-sm text-accent-teal hover:text-secondary-400 transition-colors duration-300">
                            Forgot password?
                        </a>
                    </div>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="appearance-none block w-full pl-10 pr-3 py-3 bg-darker border border-gray-700 rounded-md shadow-sm placeholder-gray-500 text-white focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-accent-teal transition-all duration-300 text-sm">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                               class="h-4 w-4 text-accent-teal focus:ring-accent-teal border-gray-700 rounded bg-darker">
                        <label for="remember" class="ml-2 block text-sm text-gray-300">
                            Remember me
                        </label>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-accent-teal to-secondary-400 hover:shadow-lg hover:shadow-accent-teal/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition-all duration-300">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign in
                    </button>
                </div>
                
                <div class="mt-6 relative flex items-center">
                    <div class="flex-grow border-t border-gray-700"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-sm">Or continue with</span>
                    <div class="flex-grow border-t border-gray-700"></div>
                </div>
                
                <div>
                    <a href="{{ route('login.google') }}" class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-700 rounded-md shadow-sm bg-darker text-sm font-medium text-white hover:bg-card transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" />
                        </svg>
                        Sign in with Google
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Registration link -->
        <div class="text-center">
            <p class="text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-medium text-accent-teal hover:text-secondary-400 transition-colors duration-300">
                    Register now
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .glass-effect {
        background: rgba(18, 27, 37, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>
@endpush