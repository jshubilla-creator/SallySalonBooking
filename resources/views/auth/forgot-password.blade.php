<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-block">
                    <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon" class="mx-auto w-16 h-16 mb-4 hover:scale-105 transition-transform duration-200 cursor-pointer">
                </a>
                <h2 class="text-2xl font-salon font-bold text-gray-900 mb-1">
                    🔑 Reset Your Password
                </h2>
                <p class="text-sm text-gray-600">
                    Don't worry! We'll help you get back to your beauty appointments.
                </p>
            </div>

            <!-- Forgot Password Form -->
            <div class="bg-pink/90 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="p-3 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-green-200 text-green-800 rounded-md text-sm session-message" data-type="status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            💌 Your Email Address
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror"
                               placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-green-500 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            ✨ Send Magic Link
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Remembered your password?
                        <a href="{{ route('login') }}"
                           class="font-medium text-green-600 hover:text-green-500 transition-colors duration-150 ease-in-out">
                            💅 Back to Salon
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
</x-guest-layout>
