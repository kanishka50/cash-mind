@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.subscriptions.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Plans
        </a>
        <h3 class="text-xl font-medium text-white">Edit Plan: <span class="text-accent-teal">{{ $subscription->name }}</span></h3>
    </div>
    
    <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Plan Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $subscription->name) }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('name') border-red-500 @enderror" 
                          placeholder="Premium Plan" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-300 text-sm font-medium mb-2">Description</label>
                    <textarea name="description" id="description" rows="5" 
                             class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('description') border-red-500 @enderror" 
                             placeholder="Describe the benefits of this subscription plan...">{{ old('description', $subscription->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <div class="mb-4">
                    <label for="price_monthly" class="block text-gray-300 text-sm font-medium mb-2">Monthly Price (LKR)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">Rs.</span>
                        </div>
                        <input type="number" step="0.01" name="price_monthly" id="price_monthly" value="{{ old('price_monthly', $subscription->price_monthly) }}" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 pl-12 pr-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('price_monthly') border-red-500 @enderror" 
                              placeholder="1000.00" required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">The price charged for monthly billing cycle</p>
                    @error('price_monthly')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="price_yearly" class="block text-gray-300 text-sm font-medium mb-2">Yearly Price (LKR)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">Rs.</span>
                        </div>
                        <input type="number" step="0.01" name="price_yearly" id="price_yearly" value="{{ old('price_yearly', $subscription->price_yearly) }}" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 pl-12 pr-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('price_yearly') border-red-500 @enderror" 
                              placeholder="10000.00" required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Set a discounted annual price to encourage yearly subscriptions</p>
                    @error('price_yearly')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="p-4 rounded-md bg-purple-900 bg-opacity-10 border border-purple-900 border-opacity-20 mt-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-purple-400">Updating Price</h4>
                            <p class="text-xs text-gray-400 mt-1">
                                Changes to pricing will only affect new subscribers and renewals. Current subscribers will maintain their existing pricing until their next renewal date.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-between mt-6 pt-4 border-t border-gray-700">
            <a href="{{ route('admin.subscriptions.manage-content', $subscription) }}" class="px-4 py-2 bg-purple-900 bg-opacity-50 border border-purple-800 rounded-md text-white hover:bg-purple-900 hover:bg-opacity-70 transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Manage Content
            </a>
            
            <div class="flex">
                <a href="{{ route('admin.subscriptions.index') }}" class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800 transition duration-200 mr-3">
                    Cancel
                </a>
                <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Plan
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection