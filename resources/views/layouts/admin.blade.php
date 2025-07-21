<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Cash Mind Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        dark: '#0D1117',
                        darker: '#05080E',
                        card: '#121b25',
                        primary: {
                            400: '#116466',
                            500: '#0a474a',
                            600: '#073739',
                        },
                        secondary: {
                            300: '#D9B08C',
                            400: '#FFCB9A',
                            500: '#D9B08C',
                        },
                        accent: {
                            light: '#D1E8E2',
                            teal: '#116466',
                            dark: '#2C3531',
                        },
                    }
                }
            }
        }
    </script>

    <!-- Additional Styles -->
    <style>
        [x-cloak] { display: none !important; }
        body {
            background-color: #0D1117;
            color: #ffffff;
        }
        
        .glass-effect {
            background: rgba(18, 27, 37, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .gradient-border {
            position: relative;
            border-radius: 0.375rem;
            background: linear-gradient(45deg, #116466, #D9B08C);
            padding: 1px;
        }
        
        .gradient-border > div {
            background: #121b25;
            border-radius: 0.325rem;
        }
        
        .animate-glow {
            box-shadow: 0 0 10px rgba(17, 100, 102, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            0% {
                box-shadow: 0 0 5px rgba(17, 100, 102, 0.5);
            }
            100% {
                box-shadow: 0 0 20px rgba(17, 100, 102, 0.8);
            }
        }
        
        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #0D1117;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #116466;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #0a474a;
        }
        
        /* Added transitions for sidebar */
        #sidebar {
            transition: width 0.3s ease;
        }
        
        #sidebar.w-16 .menu-text,
        #sidebar.w-16 #brand-text,
        #sidebar.w-16 #navigation-text,
        #sidebar.w-16 #content-text,
        #sidebar.w-16 #products-text,
        #sidebar.w-16 #sales-text,
        #sidebar.w-16 #comm-text {
            display: none;
        }
        
        main {
            transition: margin-left 0.3s ease;
        }
        
        /* Mobile sidebar styles */
        #mobile-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar-transition {
            transition: all 0.3s ease;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-dark text-white">
    <div class="min-h-screen flex">
        @include('components.admin-nav')

        <!-- Page Content -->
        <main class="flex-1 py-6 px-4 md:px-6 overflow-y-auto md:ml-64 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-white">@yield('title', 'Dashboard')</h1>
                    <div class="h-1 w-20 bg-accent-teal rounded mt-2"></div>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-900 bg-opacity-20 border border-green-800 text-green-300 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-900 bg-opacity-20 border border-red-800 text-red-300 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        // Add active class to current nav item and manage sidebar
        document.addEventListener('DOMContentLoaded', function() {
            // Active menu item
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.admin-nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath || currentPath.startsWith(href)) {
                    link.classList.add('bg-card', 'text-accent-teal', 'border-l-2', 'border-accent-teal');
                }
            });

            // Mobile menu toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const closeSidebar = document.getElementById('close-sidebar');
            
            if (sidebarToggle && mobileSidebar) {
                sidebarToggle.addEventListener('click', function() {
                    mobileSidebar.classList.remove('-translate-x-full');
                });
            }
            
            if (closeSidebar && mobileSidebar) {
                closeSidebar.addEventListener('click', function() {
                    mobileSidebar.classList.add('-translate-x-full');
                });
            }
            
            // Sidebar collapsing functionality for desktop
            const sidebar = document.getElementById('sidebar');
            const sidebarCollapse = document.getElementById('sidebar-collapse');
            const menuTexts = document.querySelectorAll('.menu-text');
            const brandText = document.getElementById('brand-text');
            const mainContent = document.querySelector('main');
            
            if (sidebarCollapse && sidebar) {
                sidebarCollapse.addEventListener('click', function() {
                    const isExpanded = !sidebar.classList.contains('w-16');
                    
                    if (isExpanded) {
                        // Collapse sidebar
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-16');
                        
                        // Hide texts
                        menuTexts.forEach(el => {
                            el.classList.add('hidden');
                        });
                        
                        document.querySelectorAll('#navigation-text, #content-text, #products-text, #sales-text, #comm-text').forEach(el => {
                            if (el) el.classList.add('hidden');
                        });
                        
                        if (brandText) brandText.classList.add('hidden');
                        
                        // Update toggle button
                        sidebarCollapse.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        `;
                        
                        // Update content margin
                        mainContent.classList.remove('md:ml-64');
                        mainContent.classList.add('md:ml-16');
                    } else {
                        // Expand sidebar
                        sidebar.classList.add('w-64');
                        sidebar.classList.remove('w-16');
                        
                        // Show texts
                        menuTexts.forEach(el => {
                            el.classList.remove('hidden');
                        });
                        
                        document.querySelectorAll('#navigation-text, #content-text, #products-text, #sales-text, #comm-text').forEach(el => {
                            if (el) el.classList.remove('hidden');
                        });
                        
                        if (brandText) brandText.classList.remove('hidden');
                        
                        // Update toggle button
                        sidebarCollapse.innerHTML = `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                            </svg>
                        `;
                        
                        // Update content margin
                        mainContent.classList.add('md:ml-64');
                        mainContent.classList.remove('md:ml-16');
                    }
                });
            }
        });
    </script>
</body>
</html>