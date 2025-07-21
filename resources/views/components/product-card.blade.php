<div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group h-full flex flex-col border border-gray-800">
    <div class="relative">
        <!-- Product Icon/Image area -->
        <div class="h-48 bg-darker flex items-center justify-center p-6 overflow-hidden group-hover:bg-card transition-all duration-500">
            @if($product->type == 'license_key')
                <svg class="h-20 w-20 text-accent-teal opacity-70 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            @elseif($product->type == 'account_credentials')
                <svg class="h-20 w-20 text-accent-teal opacity-70 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @else
                <svg class="h-20 w-20 text-accent-teal opacity-70 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            @endif
            
            <!-- Subtle background accent -->
            <div class="absolute inset-0 opacity-5 bg-gradient-to-br from-accent-teal to-secondary-400"></div>
        </div>
        
        <!-- Product badge if featured -->
        @if(isset($product->is_featured) && $product->is_featured)
        <div class="absolute top-2 right-2">
            <span class="bg-accent-teal text-white text-xs px-2 py-1 rounded shadow-md">
                Featured
            </span>
        </div>
        @endif
        
        <!-- Product type badge -->
        <div class="absolute bottom-2 left-2">
            <span class="bg-secondary-400 bg-opacity-90 text-darker text-xs px-2 py-1 rounded-md">
                {{ ucfirst(str_replace('_', ' ', $product->type)) }}
            </span>
        </div>
    </div>
    
    <div class="p-5 flex-grow">
        <h3 class="text-lg font-semibold text-white group-hover:text-accent-teal transition-colors duration-300">{{ $product->name }}</h3>
        
        <div class="mt-3">
            <p class="text-gray-400 text-sm line-clamp-2">{{ $product->description }}</p>
        </div>
        
        <div class="mt-4">
            <!-- Stock and inventory status with icon -->
            <div class="inline-flex items-center px-2.5 py-1.5 rounded text-sm {{ $product->isInStock() ? 'bg-green-900/20 text-green-400' : 'bg-red-900/20 text-red-400' }}">
                @if($product->isInStock())
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>In Stock ({{ $product->inventory_count }})</span>
                @else
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Out of Stock</span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="p-5 pt-0 mt-auto border-t border-gray-800 bg-gradient-to-b from-transparent to-card bg-opacity-30">
        <div class="flex items-center justify-between mb-4">
            <span class="text-xl font-bold text-accent-teal">Rs. {{ number_format($product->price, 2) }}</span>
        </div>
        
        <div class="flex flex-col space-y-2">
            <a href="{{ route('digital-products.show', $product) }}" class="flex items-center justify-center py-2 px-4 bg-accent-teal text-white font-medium rounded hover:bg-opacity-80 transition-all duration-300 shadow-lg">
                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Details
            </a>
            
            @auth
            <form action="{{ route('wishlist.toggle') }}" method="POST" class="w-full">
                @csrf
                <input type="hidden" name="item_type" value="digital_product">
                <input type="hidden" name="item_id" value="{{ $product->id }}">
                <button type="submit" class="w-full flex items-center justify-center py-2 px-4 bg-card hover:bg-card/80 border border-gray-700 text-gray-300 hover:text-secondary-400 font-medium rounded transition-all duration-300">
                    @if(auth()->user()->hasInWishlist($product->id, 'digital_product'))
                        <svg class="h-5 w-5 mr-1.5 text-secondary-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                        </svg>
                        <span class="text-sm">Remove from Wishlist</span>
                    @else
                        <svg class="h-5 w-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        <span class="text-sm">Add to Wishlist</span>
                    @endif
                </button>
            </form>
            @endauth
        </div>
    </div>
</div>