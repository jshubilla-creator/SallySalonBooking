<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Sally Salon') }} - Book Your Beauty Appointment</title>
        <link rel="icon" type="image/png" href="{{ asset('SallySalon.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('SallySalon.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Poppins', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-['Poppins'] antialiased">
        <!-- Hero Section -->
        <div class="relative min-h-screen bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100">
            <div class="absolute inset-0" style="background-image: url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80&brightness=1.2&contrast=0.8'); background-size: cover; background-position: center; opacity: 0.2;"></div>
            <div class="absolute inset-0 bg-black/5"></div>
            
            <!-- Navigation -->
            <nav class="relative z-10 bg-gradient-to-r from-purple-600 via-pink-500 to-indigo-600 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center">
                            <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon" class="h-16 w-16">
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-white hover:bg-white hover:bg-opacity-20 px-4 py-2 rounded-lg font-medium transition-all">Sign In</a>
                            <a href="{{ route('register') }}" class="bg-white text-purple-600 hover:bg-opacity-90 px-6 py-2 rounded-lg font-medium transition-all shadow-lg">Get Started</a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Content -->
            <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-4rem)]">
                <div class="text-center px-4 sm:px-6 lg:px-8">
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-500 mb-6 text-center">
                    Welcome to <span class="text-purple-600">Sally Salon</span>
                    </h1>
                    <p class="text-xl lg:text-2xl text-gray-700/90 mb-8 max-w-3xl mx-auto text-center">
                        Professional beauty services at your fingertips.<br>Schedule appointments with our expert stylists and specialists.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('customer.appointments.create') }}" class="bg-purple-600 text-white hover:bg-purple-700 px-6 py-2 rounded-full font-medium transition-colors shadow-lg">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <section class="py-20 bg-pink-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
                    <p class="text-xl text-gray-600">Professional beauty treatments tailored for you</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg group">
                        <div class="h-64 bg-gradient-to-br from-pink-400 to-purple-500" style="background-image: url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;"></div>
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-xl font-bold mb-2">Hair Styling</h3>
                            <p class="text-white/90">Cuts, colors, and treatments by expert stylists</p>
                        </div>
                    </div>
                    <div class="relative overflow-hidden rounded-2xl shadow-lg group">
                        <div class="h-64 bg-gradient-to-br from-blue-400 to-indigo-500" style="background-image: url('https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;"></div>
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-xl font-bold mb-2">Nail Care</h3>
                            <p class="text-white/90">Manicures, pedicures, and nail art</p>
                        </div>
                    </div>
                    <div class="relative overflow-hidden rounded-2xl shadow-lg group">
                        <div class="h-64 bg-gradient-to-br from-green-400 to-teal-500" style="background-image: url('https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;"></div>
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-xl font-bold mb-2">Facial Treatments</h3>
                            <p class="text-white/90">Skincare and beauty treatments</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-20 bg-pink-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
                    <p class="text-xl text-gray-600">Real reviews from satisfied customers</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                        $testimonials = \App\Models\Feedback::where('is_public', true)
                            ->where('rating', '>=', 4)
                            ->with('user')
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp
                    @foreach($testimonials as $testimonial)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex text-yellow-400 mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-700 mb-4">"{{ $testimonial->comment }}"</p>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">{{ $testimonial->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $testimonial->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Booking CTA -->
        <section class="py-20 bg-gradient-to-r from-purple-600 to-pink-600">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Transform Your Look?</h2>
                <p class="text-xl text-white/90 mb-8">Join thousands of satisfied customers who trust us with their beauty needs</p>
                <a href="{{ route('register') }}" class="bg-white text-purple-600 hover:bg-gray-50 px-8 py-4 rounded-full text-lg font-semibold transition-colors shadow-lg">
                    Create Account & Book Now
                </a>
            </div>
        </section>
    </body>
</html>
