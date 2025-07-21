<header class="bg-darker border-b border-gray-800">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div>
                <a href="{{ route('home') }}" class="text-xl font-bold text-primary-500">
                    {{ config('app.name', 'Cash Mind') }}
                </a>
            </div>
            
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">Home</a>
                <a href="{{ route('courses') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">Courses</a>
                <a href="{{ route('digital-products') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">Digital Products</a>
                <a href="{{ route('subscription-plans') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">Subscriptions</a>
                <a href="{{ route('about') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">About</a>
                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">Contact</a>
            </nav>
            
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-primary-400 transition duration-200">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 transition duration-200">Register</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-300 hover:text-primary-400 transition duration-200">
                            {{ Auth::user()->name }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-card rounded-md shadow-lg py-1 z-10 border border-gray-800">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">My Dashboard</a>
                            <a href="{{ route('user.courses.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">My Courses</a>
                            <a href="{{ route('user.subscriptions.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">My Subscriptions</a>
                            <a href="{{ route('user.orders.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">My Orders</a>
                            <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">Profile</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-300 hover:bg-gray-800 hover:text-primary-400">Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>