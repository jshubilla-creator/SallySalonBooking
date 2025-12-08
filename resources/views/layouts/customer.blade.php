<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Sally Salon Management' }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

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
            <nav class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                  <a href="{{ route('customer.dashboard') }}">
                                     <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon Logo" class="inline-block w-20 h-20">
                                  </a>
                                </div>

                            <!-- Navigation Links -->
                            <div class="hidden md:ml-6 md:flex md:space-x-8 back">
                                <a href="{{ route('customer.dashboard') }}"
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.dashboard') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Home
                                </a>
                                <a href="{{ route('customer.services.index') }}"
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.services.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Services
                                </a>
                                <a href="{{ route('customer.specialists.index') }}"
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.specialists.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Specialists
                                </a>
                                <a href="{{ route('customer.appointments.create') }}"
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.appointments.create') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Book Appointment
                                </a>
                                <a href="{{ route('customer.contact') }}"
                                   class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('customer.contact') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                                    Contact
                                </a>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            @auth
                                <!-- User dropdown -->
                                <div class="relative">
                                    <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" id="user-menu-button">
                                        <span class="sr-only">Open user menu</span>
                                        @if (Auth::user()->profile_picture)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <span class="ml-2 text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 ring-1 ring-black ring-opacity-5 hidden z-50" id="user-menu">
                                        <a href="{{ route('customer.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">Your Profile</a>

                                        {{-- Feedback link: visible to customers only --}}
                                        @if(Auth::user() && Auth::user()->hasRole('customer'))
                                            <a href="{{ route('customer.feedback.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">Feedback</a>
                                        @endif

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
