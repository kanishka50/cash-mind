@extends('layouts.admin')

@section('title', 'Create Subscription Plan')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.subscriptions.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Plans
        </a>
        <h3 class="text-xl font-medium text-white">Create New Subscription Plan</h3>
    </div>
    
    <form action="{{ route('admin.subscriptions.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-medium mb-2">Plan Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
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
                             placeholder="Describe the benefits of this subscription plan...">{{ old('description') }}</textarea>
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
                        <input type="number" step="0.01" name="price_monthly" id="price_monthly" value="{{ old('price_monthly') }}" 
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
                        <input type="number" step="0.01" name="price_yearly" id="price_yearly" value="{{ old('price_yearly') }}" 
                              class="bg-darker border border-gray-700 rounded-md w-full py-2 pl-12 pr-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('price_yearly') border-red-500 @enderror" 
                              placeholder="10000.00" required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Set a discounted annual price to encourage yearly subscriptions</p>
                    @error('price_yearly')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="p-4 rounded-md bg-card bg-opacity-50 mt-4">
                    <h4 class="text-sm font-medium text-white mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Subscription Tips
                    </h4>
                    <ul class="text-xs text-gray-400 list-disc list-inside space-y-1">
                        <li>Set yearly prices about 15-20% lower than monthly × 12 to encourage annual commitments</li>
                        <li>After creating the plan, use "Manage Content" to assign courses and products</li>
                        <li>Keep plan names simple and benefits clear to avoid confusion</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-6 pt-4 border-t border-gray-700">
            <a href="{{ route('admin.subscriptions.index') }}" class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-800 transition duration-200 mr-3">
                Cancel
            </a>
            <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Plan
                </div>
            </button>
        </div>
    </form>
</div>
@endsection