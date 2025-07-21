<!-- resources/views/layouts/user.blade.php -->
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

        /* Sidebar transition */
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        
        .content-transition {
            transition: all 0.3s ease-in-out;
        }
        
        /* Collapsed sidebar styles */
        .sidebar-collapsed .nav-item {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        .sidebar-collapsed .nav-icon {
            margin-right: 0 !important;
            height: 1.75rem !important;
            width: 1.75rem !important;
        }
        
        /* Hover effect in collapsed sidebar */
        .sidebar-collapsed .nav-item:hover {
            background-color: rgba(17, 100, 102, 0.1);
        }
        
        .sidebar-collapsed .nav-item:hover .nav-icon {
            color: white !important;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-dark text-white min-h-screen">
    <!-- Include the user navigation sidebar directly in the layout -->
    @include('components.user-nav')
    
    <main id="main-content" class="content-transition">
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Get the toggle button and sidebar elements
    const toggleButton = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const menuTexts = document.querySelectorAll('.menu-text');
    const navIcons = document.querySelectorAll('.nav-icon');
    const brandText = document.getElementById('brand-text');
    const navigationText = document.getElementById('navigation-text');
    const accountText = document.getElementById('account-text');
    
    // Check for saved sidebar state in localStorage
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    // Function to apply collapsed state
    function applyCollapsedState(collapsed) {
        if (collapsed) {
            // Sidebar styling
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-24');
            sidebar.classList.add('sidebar-collapsed');
            
            // Update main content margin and width
            document.querySelectorAll('.md\\:ml-64').forEach(el => {
                el.classList.remove('md:ml-64');
                el.classList.add('md:ml-24');
                // Update max width for collapsed sidebar state
                if(el.classList.contains('md:max-w-[calc(100%-16rem)]')) {
                    el.classList.remove('md:max-w-[calc(100%-16rem)]');
                    el.classList.add('md:max-w-[calc(100%-6rem)]');
                }
            });
            
            // Hide texts
            menuTexts.forEach(text => {
                text.classList.add('hidden');
            });
            
            brandText.classList.add('hidden');
            navigationText.classList.add('hidden');
            accountText.classList.add('hidden');
            
            // Center icons and preserve active state styles
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.add('justify-center');
                item.classList.remove('px-4');
                item.classList.add('px-0');
            });
            
            // Preserve icon appearances but make them larger
            navIcons.forEach(icon => {
                icon.classList.remove('mr-3');
                icon.classList.add('h-7', 'w-7');
            });
        } else {
            // Sidebar styling
            sidebar.classList.add('w-64');
            sidebar.classList.remove('w-24');
            sidebar.classList.remove('sidebar-collapsed');
            
            // Update main content margin and width
            document.querySelectorAll('.md\\:ml-24').forEach(el => {
                el.classList.add('md:ml-64');
                el.classList.remove('md:ml-24');
                // Update max width for expanded sidebar state
                if(el.classList.contains('md:max-w-[calc(100%-6rem)]')) {
                    el.classList.remove('md:max-w-[calc(100%-6rem)]');
                    el.classList.add('md:max-w-[calc(100%-16rem)]');
                }
            });
            
            // Show texts
            menuTexts.forEach(text => {
                text.classList.remove('hidden');
            });
            
            brandText.classList.remove('hidden');
            navigationText.classList.remove('hidden');
            accountText.classList.remove('hidden');
            
            // Restore icon alignment
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('justify-center');
                item.classList.add('px-4');
                item.classList.remove('px-0');
            });
            
            // Restore icon styling
            navIcons.forEach(icon => {
                icon.classList.add('mr-3');
                icon.classList.remove('h-7', 'w-7');
            });
        }
    }
    
    // Set initial sidebar state based on localStorage
    applyCollapsedState(sidebarCollapsed);
    
    // Add click event listener to toggle button
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            const isCollapsed = !sidebar.classList.contains('sidebar-collapsed');
            
            // Toggle sidebar state
            applyCollapsedState(isCollapsed);
            
            // Save sidebar state to localStorage
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });
    }
    
    // Fix for any content that might have the wrong margin class
    const contentSections = document.querySelectorAll('.md\\:ml-64');
    if (sidebarCollapsed) {
        contentSections.forEach(section => {
            section.classList.remove('md:ml-64');
            section.classList.add('md:ml-24');
            
            // Update max width for collapsed sidebar state
            if(section.classList.contains('md:max-w-[calc(100%-16rem)]')) {
                section.classList.remove('md:max-w-[calc(100%-16rem)]');
                section.classList.add('md:max-w-[calc(100%-6rem)]');
            }
        });
    }
});
    </script>

    @stack('scripts')
</body>
</html>