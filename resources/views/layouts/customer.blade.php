<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Sally Salon Management' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Poppins'] antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold text-green-600">
                                    Sally Salon
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden md:ml-6 md:flex md:space-x-8">
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
                            <!-- User dropdown -->
                            <div class="relative">
                                <button type="button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" id="user-menu-button">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-green-600">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                </button>

                                <!-- Dropdown menu -->
                                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 hidden" id="user-menu">
                                    <a href="{{ route('customer.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
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
