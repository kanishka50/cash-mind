<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Cash Mind</title>

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
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        glow: {
                            '0%': { boxShadow: '0 0 5px rgba(17, 100, 102, 0.5)' },
                            '100%': { boxShadow: '0 0 20px rgba(17, 100, 102, 0.8)' }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Additional Styles -->
    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
        
        body {
            background-color: #0D1117;
            color: #ffffff;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(17, 100, 102, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(217, 176, 140, 0.05) 0%, transparent 30%);
        }
        
        .glass-effect {
            background: rgba(18, 27, 37, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glow-effect {
            box-shadow: 0 0 15px rgba(17, 100, 102, 0.5);
            transition: all 0.3s ease;
        }
        
        .glow-effect:hover {
            box-shadow: 0 0 25px rgba(17, 100, 102, 0.8);
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
        
        .animated-bg {
            animation: gradient 15s ease infinite;
            background: linear-gradient(-45deg, #0D1117, #121b25, #073739, #0D1117);
            background-size: 400% 400%;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-dark text-white min-h-screen">
    <header class="bg-darker border-b border-opacity-10 border-accent-teal sticky top-0 z-40 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white relative">
                        <span class="relative z-10">Cash<span class="text-accent-teal">Mind</span></span>
                        <span class="absolute -bottom-1 left-0 w-full h-[2px] bg-gradient-to-r from-accent-teal to-secondary-400 opacity-80"></span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-all duration-300 relative group">
                        Home
                        <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-accent-teal transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-white transition-all duration-300 relative group">
                        Courses
                        <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-accent-teal transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('subscription-plans.index') }}" class="text-gray-300 hover:text-white transition-all duration-300 relative group">
                        Subscriptions
                        <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-accent-teal transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('digital-products.index') }}" class="text-gray-300 hover:text-white transition-all duration-300 relative group">
                        Products
                        <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-accent-teal transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('user.dashboard') }}" class="text-gray-300 hover:text-white transition-all duration-300 group">
                            <span class="hidden md:inline group-hover:text-accent-teal">My Account</span>
                            <svg class="h-6 w-6 md:hidden text-gray-300 group-hover:text-accent-teal transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-300 hover:text-white transition-all duration-300 group">
                                <span class="hidden md:inline group-hover:text-accent-teal">Logout</span>
                                <svg class="h-6 w-6 md:hidden text-gray-300 group-hover:text-accent-teal transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-all duration-300 relative group">
                            <span>Login</span>
                            <span class="absolute -bottom-1 left-0 w-0 h-[2px] bg-accent-teal transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('register') }}" class="bg-accent-teal text-white px-4 py-2 rounded-md hover:bg-opacity-80 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-accent-teal/20">
                            Register
                        </a>
                    @endauth
                    
                    <!-- Mobile menu button -->
                    <button type="button" class="md:hidden text-gray-300 hover:text-white focus:outline-none" id="mobile-menu-button">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu, show/hide based on menu state -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="pt-4 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-card rounded-md transition-all duration-200">Home</a>
                    <a href="{{ route('courses.index') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-card rounded-md transition-all duration-200">Courses</a>
                    <a href="{{ route('subscription-plans.index') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-card rounded-md transition-all duration-200">Subscriptions</a>
                    <a href="{{ route('digital-products.index') }}" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-card rounded-md transition-all duration-200">Products</a>
                </div>
            </div>
        </div>
    </header>
    
    @auth
        @if(request()->routeIs('user.*') && !auth()->user()->is_admin)
            @include('components.user-nav')
        @elseif(request()->routeIs('admin.*') && auth()->user()->is_admin)
            @include('components.admin-nav')
        @endif
    @endauth
    
    <main>
        @yield('content')
    </main>
    
    <footer class="bg-darker border-t border-opacity-10 border-accent-teal text-white mt-12">
        <div class="container mx-auto px-6 py-10">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-2xl font-bold text-white">Cash<span class="text-accent-teal">Mind</span></h2>
                    <p class="mt-2 text-gray-400">Financial Education for Everyone</p>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@cashmindsl2004" target="_blank" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-3 text-gray-200">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Home</a></li>
                            <li><a href="{{ route('courses.index') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Courses</a></li>
                            <li><a href="{{ route('subscription-plans.index') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Subscriptions</a></li>
                            <li><a href="{{ route('digital-products.index') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Products</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-3 text-gray-200">Information</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">About Us</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Contact Us</a></li>
                            <li><a href="{{ route('faqs') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">FAQs</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-3 text-gray-200">Legal</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Terms & Conditions</a></li>
                            <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-accent-teal transition-colors duration-300">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">© {{ date('Y') }} Cash Mind. All rights reserved.</p>
                <div class="flex items-center mt-4 md:mt-0">
                    <span class="text-secondary-400 text-sm">Made with</span>
                    <svg class="h-5 w-5 mx-1 text-accent-teal" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-secondary-400 text-sm">in Sri Lanka</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>