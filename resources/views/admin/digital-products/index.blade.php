@extends('layouts.admin')

@section('title', 'Digital Products')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-medium text-white">Digital Products</h3>
        <a href="{{ route('admin.digital-products.create') }}" class="px-4 py-2 bg-accent-teal hover:bg-primary-500 text-white rounded-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Product
            </div>
        </a>
    </div>
    
    @if (session('success'))
    <div class="mt-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    
    @if (session('error'))
    <div class="mt-4 p-4 bg-red-900 bg-opacity-20 border border-red-800 text-red-300 rounded-md">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Inventory
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Featured
                    </th>
                    <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($digitalProducts as $product)
                <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded bg-blue-900 bg-opacity-20 flex items-center justify-center text-blue-400">
                                @if($product->type === 'license_key')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                @elseif($product->type === 'account_credentials')
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-4 font-medium text-white">{{ $product->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($product->type === 'license_key') 
                                bg-blue-900 bg-opacity-30 text-blue-400
                            @elseif($product->type === 'account_credentials') 
                                bg-purple-900 bg-opacity-30 text-purple-400
                            @else 
                                bg-indigo-900 bg-opacity-30 text-indigo-400
                            @endif">
                            @if($product->type === 'license_key')
                                License Key
                            @elseif($product->type === 'account_credentials')
                                Account Credentials
                            @else
                                Digital Asset
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-secondary-400 font-medium">Rs. {{ number_format($product->price, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-sm rounded-md
                                @if($product->availableKeysCount === 0) 
                                    bg-red-900 bg-opacity-30 text-red-400
                                @elseif($product->availableKeysCount < 5) 
                                    bg-yellow-900 bg-opacity-30 text-yellow-400
                                @else 
                                    bg-green-900 bg-opacity-30 text-green-400
                                @endif">
                                {{ $product->availableKeysCount }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full 
                            {{ $product->is_featured ? 'bg-secondary-400 bg-opacity-20 text-secondary-400' : 'bg-gray-700 text-gray-400' }}">
                            {{ $product->is_featured ? 'Featured' : 'Regular' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.digital-products.edit', $product) }}" class="text-accent-teal hover:text-accent-light mr-3" title="Edit Product">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.digital-products.keys', $product) }}" class="text-blue-400 hover:text-blue-300 mr-3" title="Manage Keys">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.digital-products.destroy', $product) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400" 
                                    onclick="return confirm('Are you sure you want to delete this product?')" title="Delete Product">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 whitespace-nowrap text-center text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p>No digital products found.</p>
                            <a href="{{ route('admin.digital-products.create') }}" class="mt-2 text-accent-teal hover:text-accent-light transition duration-200">Create your first product</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection