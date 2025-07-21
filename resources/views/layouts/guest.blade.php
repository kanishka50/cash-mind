<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cash Mind') }} - @yield('title', 'Financial Education')</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
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
                }
            }
        }
    </script>
    
    <!-- Additional Styles -->
    <style>
        body {
            background-color: #0D1117;
            color: #ffffff;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(17, 100, 102, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(217, 176, 140, 0.05) 0%, transparent 30%);
        }
        
        .glass-card {
            background: rgba(18, 27, 37, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
        }
        
        .animated-gradient {
            background: linear-gradient(-45deg, #116466, #0a474a, #D9B08C, #FFCB9A);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
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
        
        .input-glow:focus {
            box-shadow: 0 0 15px rgba(17, 100, 102, 0.5);
        }
    </style>
</head>
<body class="font-sans antialiased bg-dark text-white">
    <div id="app" class="min-h-screen flex flex-col">
        <main class="flex-grow">
            @yield('content')
        </main>
        
        <footer class="py-4 text-center text-gray-400 text-sm">
            <p>© {{ date('Y') }} Cash Mind. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>