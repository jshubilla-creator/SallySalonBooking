<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-block">
                    <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon" class="mx-auto w-20 h-20 mb-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                </a>
                <h2 class="mt-2 text-3xl font-salon font-bold text-gray-900">
                    Join Sally Salon
                </h2>
                <p class="mt-2 text-gray-600">
                    🌸 Begin your beauty transformation journey
                </p>
            </div>

            <!-- Registration Form -->
            <div class="bg-pink/90 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
        @csrf

        <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            💄 Full Name
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus
                                   autocomplete="name"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('name') border-red-500 @enderror"
                                   placeholder="Enter your full name">
                        </div>
                        @error('name')
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
        </div>

        <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            💌 Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="username"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email">
                        </div>
                        @error('email')
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            📱 Phone Number <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input id="phone"
                                   type="tel"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   autocomplete="tel"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('phone') border-red-500 @enderror"
                                   placeholder="Enter your phone number">
                        </div>
                        @error('phone')
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
        </div>

        <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            🔐 Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password"
                            type="password"
                            name="password"
                                   required
                                   autocomplete="new-password"
                                   class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('password') border-red-500 @enderror"
                                   placeholder="Create a password">
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="password_eye_closed" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                                <svg id="password_eye_open" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
        </div>

        <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            ✓ Confirm Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password_confirmation"
                            type="password"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200 @error('password_confirmation') border-red-500 @enderror"
                                   placeholder="Confirm your password">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="password_confirmation_eye_closed" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                                <svg id="password_confirmation_eye_open" class="h-5 w-5 text-gray-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="space-y-2">
                        <label class="flex items-start">
                            <input type="checkbox"
                                   name="terms_accepted"
                                   id="terms_accepted"
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mt-1"
                                   required>
                            <span class="ml-3 text-sm text-gray-600">
                                I agree to the <button type="button" onclick="showTerms()" class="text-green-600 hover:text-green-500 font-medium transition-colors duration-200 underline">Terms and Conditions</button> and <button type="button" onclick="showPrivacy()" class="text-green-600 hover:text-green-500 font-medium transition-colors duration-200 underline">Privacy Policy</button>
                            </span>
                        </label>
                        @error('terms_accepted')
                            <p class="text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
        </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                id="registerButton"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-semibold rounded-lg text-green-500 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <svg id="registerIcon" class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <svg id="registerSpinner" class="hidden animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="registerButtonText">✨ Join Beauty Community</span>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already part of our salon family?
                        <a href="{{ route('login') }}"
                           class="font-semibold text-green-600 hover:text-green-500 transition-colors duration-200">
                            💅 Welcome Back
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border-2 border-gray-50 rounded-lg max-w-md w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Terms and Conditions</h3>
                        <button onclick="closeTerms()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-sm text-gray-700 space-y-3">
                        <h4 class="font-semibold">1. Acceptance of Terms</h4>
                        <p>By accessing and using Sally Salon's booking system, you accept and agree to be bound by the terms and provision of this agreement.</p>
                        
                        <h4 class="font-semibold">2. Booking and Appointments</h4>
                        <ul class="list-disc pl-5">
                            <li>All appointments must be booked through our online system</li>
                            <li>Cancellations must be made at least 24 hours in advance</li>
                            <li>Late arrivals may result in shortened service time or rescheduling</li>
                        </ul>
                        
                        <h4 class="font-semibold">3. Payment Terms</h4>
                        <ul class="list-disc pl-5">
                            <li>Payment is due at the time of service</li>
                            <li>We accept cash, credit cards, and digital payments</li>
                            <li>Prices are subject to change without notice</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div id="privacyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border-2 border-gray-50 rounded-lg max-w-md w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Privacy Policy</h3>
                        <button onclick="closePrivacy()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-sm text-gray-700 space-y-3">
                        <h4 class="font-semibold">1. Information We Collect</h4>
                        <ul class="list-disc pl-5">
                            <li>Personal information (name, email, phone number)</li>
                            <li>Appointment history and preferences</li>
                            <li>Payment information (processed securely)</li>
                        </ul>
                        
                        <h4 class="font-semibold">2. How We Use Your Information</h4>
                        <ul class="list-disc pl-5">
                            <li>Schedule and manage appointments</li>
                            <li>Send appointment reminders and confirmations</li>
                            <li>Process payments</li>
                            <li>Improve our services</li>
                        </ul>
                        
                        <h4 class="font-semibold">3. Data Security</h4>
                        <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            const button = document.getElementById('registerButton');
            const icon = document.getElementById('registerIcon');
            const spinner = document.getElementById('registerSpinner');
            const text = document.getElementById('registerButtonText');

            // Disable button and show loading state
            button.disabled = true;
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            text.textContent = 'Creating Account...';
        });

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeClosed = document.getElementById(fieldId + '_eye_closed');
            const eyeOpen = document.getElementById(fieldId + '_eye_open');
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                field.type = 'password';
                eyeClosed.classList.remove('hidden');
                eyeOpen.classList.add('hidden');
            }
        }

        // Modal functions
        function showTerms() {
            document.getElementById('termsModal').classList.remove('hidden');
        }

        function closeTerms() {
            document.getElementById('termsModal').classList.add('hidden');
        }

        function showPrivacy() {
            document.getElementById('privacyModal').classList.remove('hidden');
        }

        function closePrivacy() {
            document.getElementById('privacyModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.getElementById('termsModal').addEventListener('click', function(e) {
            if (e.target === this) closeTerms();
        });

        document.getElementById('privacyModal').addEventListener('click', function(e) {
            if (e.target === this) closePrivacy();
        });
    </script>
</x-guest-layout>
