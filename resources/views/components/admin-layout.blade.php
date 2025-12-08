<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Sally Salon Admin Panel</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Salon Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] antialiased bg-gray-100">
        <style>
            h1, h2, h3, .salon-heading { font-family: 'Playfair Display', serif !important; }
            .font-salon { font-family: 'Playfair Display', serif !important; }
        </style>
        <div class="relative min-h-screen flex bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100" x-data="{ sidebarOpen: $persist(true) }">
            <div class="absolute inset-0 pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80&brightness=1.2&contrast=0.8'); background-size: cover; background-position: center; opacity: 0.2;"></div>

            <!-- Sidebar -->
            <div class="hidden md:flex md:flex-col bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow-lg transition-all duration-300" :class="sidebarOpen ? 'md:w-64' : 'md:w-20'">
                <div class="flex flex-col flex-grow pt-5 overflow-y-auto shadow-lg">
                    <div class="flex items-center flex-shrink-0 px-4" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <a href="{{ route('admin.dashboard') }}">
                            <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon Logo" :class="sidebarOpen ? 'w-20 h-20' : 'w-10 h-10'">
                        </a>
                        <button @click="sidebarOpen = !sidebarOpen" class="p-1 rounded-md text-gray-600 hover:text-gray-900">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="mt-5 flex-grow flex flex-col">
                        <nav class="flex-1 px-2 pb-4 space-y-1">
                            <!-- Dashboard -->
                            <a href="{{ route('admin.dashboard') }}"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="sidebarOpen ? '' : 'justify-center'">
                                <svg class="h-6 w-6" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                <span x-show="sidebarOpen">Dashboard</span>
                            </a>

                            <!-- Staff Management -->
                            <a href="{{ route('admin.staff.index') }}"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.staff.*') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="sidebarOpen ? '' : 'justify-center'">
                                <svg class="h-6 w-6" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <span x-show="sidebarOpen">Staff Management</span>
                            </a>

                            <!-- Analytics -->
                            <a href="{{ route('admin.analytics') }}"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.analytics') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="sidebarOpen ? '' : 'justify-center'">
                                <svg class="h-6 w-6" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span x-show="sidebarOpen">Analytics</span>
                            </a>

                            <!-- System Settings -->
                            <a href="{{ route('admin.settings') }}"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.settings') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}" :class="sidebarOpen ? '' : 'justify-center'">
                                <svg class="h-6 w-6" :class="sidebarOpen ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span x-show="sidebarOpen">System Settings</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <!-- Top header -->
                <div class="relative z-10 flex-shrink-0 flex h-20 shadow bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100">
                    <div class="flex-1 px-4 flex justify-between">
                        <div class="flex-1 flex">
                            <div class="w-full flex md:ml-0">
                                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                          
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            @auth
                                <div class="ml-3 relative">
                                    <div>
                                        <button type="button" class="max-w-xs bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" id="user-menu-button">
                                            <span class="sr-only">Open user menu</span>
                                            @if (Auth::user()->profile_picture)
                                                <img src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture" class="h-8 w-8 rounded-full object-cover">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-purple-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                                </div>
                                            @endif

                                            <span class="ml-2 text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                        </button>
                                    </div>
                                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 ring-1 ring-black ring-opacity-5 hidden" id="user-menu">
                                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">Your Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm text-gray-700 hover:underline">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-3 py-2 text-sm text-gray-700 hover:underline">Register</a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Page content -->
                <main class="flex-1 relative overflow-y-auto focus:outline-none">
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            @if (session('success'))
                                <div class="mb-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-green-400 text-green-700 px-4 py-3 rounded session-message" data-type="success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="mb-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-red-400 text-red-700 px-4 py-3 rounded session-message" data-type="error">
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const userMenuButton = document.getElementById('user-menu-button');
                const userMenu = document.getElementById('user-menu');

                // Toggle user menu
                if (userMenuButton && userMenu) {
                    userMenuButton.addEventListener('click', function() {
                        userMenu.classList.toggle('hidden');
                    });

                    // Close user menu when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                            userMenu.classList.add('hidden');
                        }
                    });
                }

                // Auto-dismiss session messages after 3 seconds
                const sessionMessages = document.querySelectorAll('.session-message');
                sessionMessages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.transition = 'opacity 0.5s ease-out';
                        message.style.opacity = '0';
                        setTimeout(function() {
                            if (message.parentElement) {
                                message.remove();
                            }
                        }, 500);
                    }, 3000);
                });
            });
        </script>
    </body>
</html>
