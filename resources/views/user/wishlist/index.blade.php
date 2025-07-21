@extends('layouts.user')

@section('title', 'My Wishlist')

@section('content')
<div class="md:ml-64 content-transition min-h-screen bg-dark">
    <div class="container px-6 py-8 mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            My Wishlist
        </h1>
        
        @if (session('success'))
        <div class="mb-6 p-4 glass-effect border-l-4 border-green-500 text-green-400 rounded-md flex items-center">
            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        <div class="mt-6">
            @if($wishlistItems->isEmpty())
                <div class="glass-effect rounded-lg p-10 text-center border border-gray-800">
                    <svg class="h-16 w-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">Your Wishlist is Empty</h3>
                    <p class="text-gray-400 mb-6">Start adding courses and digital products to your wishlist for future reference.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Browse Courses
                        </a>
                        <a href="{{ route('digital-products.index') }}" class="inline-flex items-center px-4 py-2 bg-card border border-gray-800 text-white font-medium rounded-md hover:bg-darker transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Browse Digital Products
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($wishlistItems as $wishlistItem)
                        <div class="bg-card rounded-lg overflow-hidden shadow-lg border border-gray-800 hover:shadow-accent-teal/10 transition-all duration-300 group">
                            <div class="h-48 bg-darker flex items-center justify-center">
                                @if($wishlistItem->wishlist_type === 'course')
                                    <svg class="h-16 w-16 text-accent-teal/50 group-hover:text-accent-teal transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                @else
                                    <svg class="h-16 w-16 text-accent-teal/50 group-hover:text-accent-teal transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-white group-hover:text-accent-teal transition-colors duration-300">
                                    {{ $wishlistItem->wishlist_type === 'course' ? $wishlistItem->item->title : $wishlistItem->item->name }}
                                </h3>
                                
                                <div class="mt-2">
                                    <p class="text-sm text-gray-400">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-card border border-gray-800">
                                            {{ $wishlistItem->wishlist_type === 'course' ? 'Course' : 'Digital Product' }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="mt-3">
                                    <p class="text-lg font-bold text-accent-teal">
                                        Rs. {{ number_format($wishlistItem->wishlist_type === 'course' ? $wishlistItem->item->price : $wishlistItem->item->price, 2) }}
                                    </p>
                                </div>
                                
                                <div class="mt-5 grid grid-cols-2 gap-3">
                                    <a href="{{ $wishlistItem->wishlist_type === 'course' ? route('courses.show', $wishlistItem->item->slug) : route('digital-products.show', $wishlistItem->item) }}" class="text-center py-2 bg-accent-teal text-white font-medium rounded-md hover:bg-opacity-80 transition-all duration-300">
                                        View Details
                                    </a>
                                    <form action="{{ route('user.wishlist.destroy', $wishlistItem) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full py-2 bg-red-900/20 text-red-400 font-medium rounded-md hover:bg-red-900/30 transition-all duration-300">
                                            <span class="flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Remove
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection