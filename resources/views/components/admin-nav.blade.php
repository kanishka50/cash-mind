<!-- Sidebar Navigation -->
<div class="bg-darker w-64 hidden md:block overflow-y-auto border-r border-gray-800 h-screen fixed sidebar-transition" id="sidebar">
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
            <span class="text-xl font-bold text-white" id="brand-text">Cash<span class="text-accent-teal">Mind</span></span>
        </a>
        <p class="text-xs text-gray-500 mt-1">Administration Panel</p>
    </div>
    
    <nav class="mt-2">
        <div class="px-4 py-2">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider" id="navigation-text">General</p>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="menu-text">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="menu-text">Users</span>
        </a>
        
        <div class="px-4 py-2 mt-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider" id="content-text">Content</p>
        </div>
        
        <a href="{{ route('admin.categories.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <span class="menu-text">Categories</span>
        </a>
        
        <a href="{{ route('admin.tags.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span class="menu-text">Tags</span>
        </a>
        
        <a href="{{ route('admin.courses.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span class="menu-text">Courses</span>
        </a>
        
        <a href="{{ route('admin.videos.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <span class="menu-text">Videos</span>
        </a>
        
        <div class="px-4 py-2 mt-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider" id="products-text">Products</p>
        </div>
        
        <a href="{{ route('admin.digital-products.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span class="menu-text">Digital Products</span>
        </a>
        
        <a href="{{ route('admin.subscriptions.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="menu-text">Subscriptions</span>
        </a>
        
        <div class="px-4 py-2 mt-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider" id="sales-text">Sales</p>
        </div>
        
        <a href="{{ route('admin.orders.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span class="menu-text">Orders</span>
        </a>
        
        <a href="{{ route('admin.coupons.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <span class="menu-text">Coupons</span>
        </a>
        
        <div class="px-4 py-2 mt-4">
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider" id="comm-text">Communication</p>
        </div>
        
        <a href="{{ route('admin.messages.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <span class="menu-text">Messages</span>
        </a>
        
        <a href="{{ route('admin.faqs.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
            <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="menu-text">FAQs</span>
        </a>



        {{-- In admin navigation --}}
<a href="{{ route('admin.payment-verifications.index') }}" class="...">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    Payment Verifications
    @if($pendingPaymentsCount > 0)
        <span class="ml-2 px-2 py-1 text-xs bg-yellow-500 text-white rounded-full">{{ $pendingPaymentsCount }}</span>
    @endif
</a>



        <!-- Add this right after the FAQs link in admin-nav.blade.php -->
<div class="px-4 py-2 mt-4">
    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider" id="affiliate-text">Affiliate Program</p>
</div>

<a href="{{ route('admin.commission-rates.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
    <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="menu-text">Commission Rates</span>
</a>

<a href="{{ route('admin.payouts.index') }}" class="admin-nav-link nav-item flex items-center px-6 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200">
    <svg class="nav-icon mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    <span class="menu-text">Affiliate Payouts</span>
</a>
    </nav>
    
    <div class="p-6 mt-6">
        <div class="gradient-border">
            <div class="p-4">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-accent-teal animate-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-white">Need Help?</h3>
                        <p class="text-xs text-gray-400 mt-1">Check our documentation</p>
                    </div>
                </div>
                <a href="#" class="mt-4 block w-full bg-accent-teal text-white text-center px-4 py-2 rounded-md text-sm hover:bg-opacity-90 transition duration-200">
                    View Docs
                </a>
            </div>
        </div>
    </div>
    
    <!-- Toggle button for sidebar -->
    <button id="sidebar-collapse" class="absolute right-0 top-6 text-gray-400 hover:text-white focus:outline-none p-1 rounded-l-md bg-card transform translate-x-full">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
        </svg>
    </button>
</div>

<!-- Mobile admin navigation - top bar -->
<div class="md:hidden bg-darker border-b border-gray-800 fixed top-0 w-full z-40">
    <div class="px-4 py-3 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-white">Cash<span class="text-accent-teal">Mind</span></a>
        
        <div class="flex items-center space-x-4">
            <button type="button" id="sidebar-toggle" class="text-gray-300 hover:text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Mobile sidebar -->
<div class="fixed inset-0 z-50 bg-darker bg-opacity-90 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden" id="mobile-sidebar">
    <div class="flex justify-between items-center p-4 border-b border-gray-800">
        <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-white">Cash<span class="text-accent-teal">Mind</span></a>
        <button id="close-sidebar" class="p-2 text-gray-300 hover:text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="overflow-y-auto h-full pb-20">
        <nav class="px-4 py-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            
           <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Users
            </a>
            
            <div class="pt-4 pb-1 border-t border-gray-800">
                <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Content</p>
            </div>
            
            <a href="{{ route('admin.courses.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Courses
            </a>
            
            <a href="{{ route('admin.videos.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Videos
            </a>
            
            <div class="pt-4 pb-1 border-t border-gray-800">
                <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Products</p>
            </div>
            
            <a href="{{ route('admin.digital-products.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Digital Products
            </a>
            
            <a href="{{ route('admin.subscriptions.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a2 2 0 10-4 0v5a2 2 0 01-2 2h6m-6-4h4m8 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Subscriptions
            </a>
            
            <div class="pt-4 pb-1 border-t border-gray-800">
                <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Sales</p>
            </div>
            
            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Orders
            </a>
            
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Coupons
            </a>

            <div class="pt-4 pb-1 border-t border-gray-800">
                <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Communication</p>
            </div>
            
            <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                Messagessssss
            </a>
            
            <a href="{{ route('admin.faqs.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                FAQs
            </a>
            <!-- Add this after the FAQs link in the mobile sidebar section -->
<div class="pt-4 pb-1 border-t border-gray-800">
    <p class="px-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Affiliate Program</p>
</div>

<a href="{{ route('admin.commission-rates.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Commission Rates
</a>

<a href="{{ route('admin.payouts.index') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-card hover:text-white transition-all duration-200 rounded-md">
    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    Affiliate Payouts
</a>
        </nav>
    </div>
</div>