@extends('layouts.admin')

@section('title', 'Manage Product Keys')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.digital-products.index') }}" class="text-accent-teal hover:text-accent-light flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
        <h3 class="text-xl font-medium text-white">Manage Keys: <span class="text-accent-teal">{{ $digitalProduct->name }}</span></h3>
    </div>
    
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    @if (session('error'))
    <div class="mb-4 p-4 bg-red-900 bg-opacity-20 border border-red-800 text-red-300 rounded-md">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
        <div class="glass-effect rounded-lg border border-gray-700 p-6">
            <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Single Key
            </h4>
            <form action="{{ route('admin.digital-products.keys.store', $digitalProduct) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="key_value" class="block text-gray-300 text-sm font-medium mb-2">Key Value</label>
                    <input type="text" name="key_value" id="key_value" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent font-mono @error('key_value') border-red-500 @enderror" 
                          placeholder="XXXXX-XXXXX-XXXXX-XXXXX" required>
                    @error('key_value')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="key_count" class="block text-gray-300 text-sm font-medium mb-2">Number of Keys (same value)</label>
                    <input type="number" name="key_count" id="key_count" value="1" min="1" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent @error('key_count') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Create multiple copies of the same key</p>
                    @error('key_count')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="bg-accent-teal hover:bg-primary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-teal transition duration-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Key
                        </div>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="glass-effect rounded-lg border border-gray-700 p-6">
            <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Add Bulk Keys
            </h4>
            <form action="{{ route('admin.digital-products.keys.store', $digitalProduct) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="bulk_keys" class="block text-gray-300 text-sm font-medium mb-2">Paste Keys (one per line)</label>
                    <textarea name="bulk_keys" id="bulk_keys" rows="8" 
                             class="bg-darker border border-gray-700 rounded-md w-full py-2 px-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent font-mono @error('bulk_keys') border-red-500 @enderror" 
                             placeholder="XXXXX-XXXXX-XXXXX-XXXXX
YYYYY-YYYYY-YYYYY-YYYYY"></textarea>
                    @error('bulk_keys')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="bg-secondary-400 hover:bg-secondary-500 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-400 transition duration-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Add Bulk Keys
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-8">
        <h4 class="text-lg font-medium text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            Product Keys ({{ $productKeys->total() }})
        </h4>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Key Value
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Used By
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Used At
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($productKeys as $key)
                    <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-mono text-white">{{ $key->key_value }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $key->is_used ? 'bg-red-900 bg-opacity-30 text-red-400' : 'bg-green-900 bg-opacity-30 text-green-400' }}">
                                {{ $key->is_used ? 'Used' : 'Available' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-300">
                                @if($key->user)
                                    <div class="flex items-center">
                                        <div class="h-6 w-6 rounded-full bg-secondary-400 bg-opacity-20 flex items-center justify-center text-secondary-400 text-xs mr-2">
                                            {{ substr($key->user->name, 0, 1) }}
                                        </div>
                                        <span>{{ $key->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-300">
                                @if($key->used_at)
                                    <span class="flex items-center text-gray-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $key->used_at->format('M d, Y H:i') }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if(!$key->is_used)
                            <form action="{{ route('admin.digital-products.keys.destroy', [$digitalProduct, $key]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400" 
                                        onclick="return confirm('Are you sure you want to delete this key?')" title="Delete Key">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-gray-400">
                            <div class="flex flex-col items-center">
                                <svg class="h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                <p>No product keys found.</p>
                                <p class="text-sm text-gray-500 mt-1">Add keys to make this product available for purchase.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $productKeys->links() }}
        </div>
    </div>
</div>
@endsection