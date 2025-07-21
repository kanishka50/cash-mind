<div class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl hover:shadow-accent-teal/10 transition-all duration-300 group">
    <div class="relative">
        @if($course->thumbnail)
            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-105 course-thumbnail">
        @else
            <div class="h-48 bg-darker flex items-center justify-center overflow-hidden">
                <svg class="h-16 w-16 text-accent-teal opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        
        @if($course->is_featured)
            <div class="absolute top-0 right-0 mt-2 mr-2">
                <span class="bg-accent-teal text-white text-xs px-2 py-1 rounded-md">Featured</span>
            </div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-dark to-transparent opacity-60"></div>
        
        @if(isset($course->category))
            <div class="absolute bottom-0 left-0 mb-4 ml-4">
                <span class="bg-secondary-400 bg-opacity-90 text-dark text-xs px-2 py-1 rounded-md">{{ $course->category->name }}</span>
            </div>
        @endif
    </div>
    
    <div class="p-5 relative z-10">
        <h3 class="text-xl font-semibold mb-2 line-clamp-2 group-hover:text-accent-teal transition-colors duration-300">{{ $course->title }}</h3>
        
        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $course->description }}</p>
        
        <div class="flex justify-between items-center">
            <span class="text-accent-teal font-semibold">Rs. {{ number_format($course->price, 2) }}</span>
            
            <a href="{{ route('courses.show', $course->slug) }}" class="inline-flex items-center text-secondary-400 hover:text-secondary-300 transition-colors duration-200">
                View Course
                <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
    
    @if(isset($footer))
        <div class="px-5 py-3 bg-gray-900 bg-opacity-30 border-t border-gray-800">
            {{ $footer }}
        </div>
    @endif
</div>