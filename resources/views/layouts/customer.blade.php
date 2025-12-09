<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Sally Salon Management' }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('SallySalon.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('SallySalon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('SallySalon.png') }}">

        <!-- Salon Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Inter'] antialiased">
        <style>
            h1, h2, h3, .salon-heading { font-family: 'Playfair Display', serif !important; }
            .font-salon { font-family: 'Playfair Display', serif !important; }
        </style>
        <!-- Hero Section -->
        <div class="relative min-h-screen bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100">
            <div class="absolute inset-0 pointer-events-none" style="background-image: url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80&brightness=1.2&contrast=0.8'); background-size: cover; background-position: center; opacity: 0.2;"></div>
            <div class="absolute z-10 inset-0 bg-black/5 pointer-events-none"></div>

            <!-- Top Navigation -->
            <nav class="bg-gradient-to-r from-purple-600 via-pink-500 to-indigo-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20 items-center">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                  <a href="{{ route('customer.dashboard') }}">
                                     <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon Logo" class="inline-block w-20 h-20">
                                  </a>
                                </div>

                            <!-- Navigation Links -->
                            <div class="hidden md:ml-6 md:flex md:space-x-6">
                                <a href="{{ route('customer.dashboard') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('customer.dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:bg-white hover:bg-opacity-10' }}">
                                    Home
                                </a>
                                <a href="{{ route('customer.services.index') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('customer.services.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:bg-white hover:bg-opacity-10' }}">
                                    Services
                                </a>
                                <a href="{{ route('customer.specialists.index') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('customer.specialists.*') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:bg-white hover:bg-opacity-10' }}">
                                    Specialists
                                </a>
                                <a href="{{ route('customer.appointments.create') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('customer.appointments.create') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:bg-white hover:bg-opacity-10' }}">
                                    Book Appointment
                                </a>
                                <a href="{{ route('customer.contact') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('customer.contact') ? 'bg-white bg-opacity-20 text-white' : 'text-white hover:bg-white hover:bg-opacity-10' }}">
                                    Contact
                                </a>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            @auth
                                <!-- User dropdown -->
                                <div class="relative">
                                    <button type="button" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-white bg-opacity-20 hover:bg-opacity-30 transition-all focus:outline-none focus:ring-2 focus:ring-white" id="user-menu-button">
                                        @if (Auth::user()->profile_picture)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-white" src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center border-2 border-white">
                                                <span class="text-lg font-bold text-purple-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <span class="text-sm font-medium text-white">{{ Auth::user()->name }}</span>
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-xl py-2 bg-white ring-1 ring-black ring-opacity-5 hidden z-50" id="user-menu">
                                        <a href="{{ route('customer.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 transition-colors">
                                            <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Your Profile
                                        </a>

                                        {{-- Feedback link: visible to customers only --}}
                                        @if(Auth::user() && Auth::user()->hasRole('customer'))
                                            <a href="{{ route('customer.feedback.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 transition-colors">
                                                <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                Feedback
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 transition-colors">
                                                <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-white hover:bg-white hover:bg-opacity-20 rounded-lg transition-all">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-white text-purple-600 rounded-lg hover:bg-opacity-90 transition-all">Register</a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden" id="mobile-menu">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('customer.dashboard') }}"
                           class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('customer.dashboard') ? 'text-green-600 bg-green-50' : 'text-gray-500 hover:text-gray-700' }}">
                            Home
                        </a>
                        <a href="{{ route('customer.services.index') }}"
                           class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('customer.services.*') ? 'text-green-600 bg-green-50' : 'text-gray-500 hover:text-gray-700' }}">
                            Services
                        </a>
                        <a href="{{ route('customer.specialists.index') }}"
                           class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('customer.specialists.*') ? 'text-green-600 bg-green-50' : 'text-gray-500 hover:text-gray-700' }}">
                            Specialists
                        </a>
                        <a href="{{ route('customer.appointments.create') }}"
                           class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('customer.appointments.create') ? 'text-green-600 bg-green-50' : 'text-gray-500 hover:text-gray-700' }}">
                            Book Appointment
                        </a>
                        <a href="{{ route('customer.contact') }}"
                           class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('customer.contact') ? 'text-green-600 bg-green-50' : 'text-gray-500 hover:text-gray-700' }}">
                            Contact
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6">
                {{ $slot }}
            </main>

            <!-- Copyright Footer -->
            <footer class="bg-white/80 backdrop-blur-sm border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="text-center text-sm text-gray-600">
                        <p>&copy; {{ date('Y') }} Sally Salon. All rights reserved.</p>
                        <p class="mt-1">Professional Salon Booking Management System</p>
                    </div>
                </div>
            </footer>
        </div>

        <script>
            // Mobile menu toggle
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                const userMenuButton = document.getElementById('user-menu-button');
                const userMenu = document.getElementById('user-menu');

                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', function() {
                        mobileMenu.classList.toggle('hidden');
                    });
                }

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
            });
        </script>
    </body>
</html>
