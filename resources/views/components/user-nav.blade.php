<div id="sidebar" class="bg-darker h-screen sidebar-transition w-64 fixed left-0 top-0 overflow-y-auto hidden md:block border-r border-gray-800 z-30">
    <div class="p-6">
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('home') }}" class="flex items-center">
                <span id="brand-text" class="text-xl font-bold text-white">Cash<span class="text-accent-teal">Mind</span></span>
            </a>
            <button id="sidebar-toggle" class="text-white hover:text-accent-teal focus:outline-none transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
        
        <p id="navigation-text" class="text-xs uppercase tracking-wider text-gray-500 mb-4">Navigation</p>
        
        <nav class="space-y-1">
            <a href="{{ route('user.dashboard') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.dashboard') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="menu-text">Dashboard</span>
            </a>
            
            <a href="{{ route('user.courses.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.courses.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.courses.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="menu-text">My Courses</span>
            </a>
            
            <a href="{{ route('user.subscriptions.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.subscriptions.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.subscriptions.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="menu-text">Subscriptions</span>
            </a>
            
            <a href="{{ route('user.digital-products.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.digital-products.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.digital-products.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="menu-text">Products</span>
            </a>
            
            <a href="{{ route('user.orders.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.orders.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.orders.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="menu-text">Orders</span>
            </a>
            
            <a href="{{ route('user.wishlist.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.wishlist.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.wishlist.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span class="menu-text">Wishlist</span>
            </a>
            
            <a href="{{ route('user.notifications.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.notifications.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.notifications.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="menu-text">Notifications</span>
            </a>
            
            <a href="{{ route('user.messages.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.messages.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
                <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.messages.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <span class="menu-text">Messages</span>
            </a>
            <a href="{{ route('user.referrals.index') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.referrals.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
    <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.referrals.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>
    <span class="menu-text">Affiliate Program</span>
</a>
        </nav>
    </div>
    
    <div class="p-4 mt-4">
        <p id="account-text" class="text-xs uppercase tracking-wider text-gray-500 mb-4">Account</p>
        
        <a href="{{ route('user.profile.edit') }}" class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 {{ request()->routeIs('user.profile.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }}">
            <svg class="nav-icon w-6 h-6 mr-3 {{ request()->routeIs('user.profile.*') ? 'text-accent-teal' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="menu-text">Profile</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="nav-item group flex w-full items-center px-4 py-3 text-sm font-medium rounded-md transition-all duration-200 text-gray-400 hover:text-white hover:bg-card">
                <svg class="nav-icon w-6 h-6 mr-3 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Mobile Navigation Menu -->
<div class="md:hidden bg-darker fixed bottom-0 left-0 right-0 z-30 border-t border-gray-800">
    <div class="grid grid-cols-5 h-16">
        <a href="{{ route('user.dashboard') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('user.dashboard') ? 'text-accent-teal' : 'text-gray-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-xs mt-1">Dashboard</span>
        </a>
        
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center text-gray-400 hover:text-white">
            <div class="w-6 h-6 flex items-center justify-center">
                <span class="text-white font-bold text-base">C<span class="text-accent-teal">M</span></span>
            </div>
            <span class="text-xs mt-1">Website</span>
        </a>
        
        <button id="mobile-more-btn" class="flex flex-col items-center justify-center text-gray-400 hover:text-white relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <span class="text-xs mt-1">More</span>
        </button>
        
        <a href="{{ route('user.notifications.index') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('user.notifications.*') ? 'text-accent-teal' : 'text-gray-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="text-xs mt-1">Alerts</span>
        </a>
        
        <a href="{{ route('user.profile.edit') }}" class="flex flex-col items-center justify-center {{ request()->routeIs('user.profile.*') ? 'text-accent-teal' : 'text-gray-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-xs mt-1">Profile</span>
        </a>
    </div>
    
    <!-- Mobile More Menu - Improved Design -->
    <div id="mobile-more-menu" class="hidden fixed bottom-16 left-0 right-0 bg-darker z-40 border-t border-gray-800 shadow-xl transition-all duration-300 transform translate-y-full overflow-hidden">
        <div class="p-4">
            <!-- Menu Header -->
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-800">
                <h3 class="text-lg font-medium text-white">Menu</h3>
                <button id="mobile-menu-close" class="p-1 rounded-full hover:bg-gray-800 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Menu Items -->
            <div class="grid grid-cols-1 gap-2">
                <!-- Add Courses as the first item -->
                <a href="{{ route('user.courses.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('user.courses.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }} transition-colors duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">My Courses</span>
                        <p class="text-xs text-gray-500">Access your purchased courses</p>
                    </div>
                </a>
                
                <a href="{{ route('user.subscriptions.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('user.subscriptions.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }} transition-colors duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Subscriptions</span>
                        <p class="text-xs text-gray-500">Manage your subscription plans</p>
                    </div>
                </a>
                
                <a href="{{ route('user.digital-products.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('user.digital-products.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }} transition-colors duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Products</span>
                        <p class="text-xs text-gray-500">View your digital products</p>
                    </div>
                </a>
                
                <a href="{{ route('user.orders.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('user.orders.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }} transition-colors duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Orders</span>
                        <p class="text-xs text-gray-500">View your order history</p>
                    </div>
                </a>
                
                <a href="{{ route('user.wishlist.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('user.wishlist.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }} transition-colors duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Wishlist</span>
                        <p class="text-xs text-gray-500">Saved items for later</p>
                    </div>
                </a>
                
                <a href="{{ route('user.messages.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('user.messages.*') ? 'bg-accent-teal bg-opacity-10 text-accent-teal' : 'text-gray-400 hover:text-white hover:bg-card' }} transition-colors duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="font-medium">Messages</span>
                        <p class="text-xs text-gray-500">View your conversations</p>
                    </div>
                </a>
                
                <div class="border-t border-gray-800 my-2 pt-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center p-3 rounded-lg text-gray-400 hover:text-white hover:bg-card transition-colors duration-200">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="font-medium">Logout</span>
                                <p class="text-xs text-gray-500">Sign out of your account</p>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Overlay for Mobile More Menu -->
    <div id="mobile-menu-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-30"></div>
</div>

<!-- Add JavaScript for Mobile Menu Toggle -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const moreBtn = document.getElementById('mobile-more-btn');
        const moreMenu = document.getElementById('mobile-more-menu');
        const overlay = document.getElementById('mobile-menu-overlay');
        const closeBtn = document.getElementById('mobile-menu-close');
        
        function openMenu() {
            moreMenu.classList.remove('hidden');
            overlay.classList.remove('hidden');
            
            // Use setTimeout to ensure the transition happens after the display change
            setTimeout(() => {
                moreMenu.classList.add('translate-y-0');
                moreMenu.classList.remove('translate-y-full');
            }, 10);
        }
        
        function closeMenu() {
            moreMenu.classList.remove('translate-y-0');
            moreMenu.classList.add('translate-y-full');
            
            // Use setTimeout to delay hiding until after the transition completes
            setTimeout(() => {
                moreMenu.classList.add('hidden');
                overlay.classList.add('hidden');
            }, 300);
        }
        
        if (moreBtn && moreMenu && overlay) {
            moreBtn.addEventListener('click', openMenu);
            overlay.addEventListener('click', closeMenu);
            
            if (closeBtn) {
                closeBtn.addEventListener('click', closeMenu);
            }
        }
    });
</script>
@endpush