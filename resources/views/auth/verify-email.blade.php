<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon" class="mx-auto w-16 h-16 mb-4">
                <h2 class="text-2xl font-salon font-bold text-gray-900 mb-1">
                    💌 Verify Your Email
                </h2>
                <p class="text-sm text-gray-600">
                    We've sent a verification link to your email address
                </p>
            </div>

            <!-- Verification Form -->
            <div class="bg-pink/90 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Thanks for joining Sally Salon! 🌸 Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn't receive the email, we'll gladly send you another.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="p-3 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-green-200 text-green-800 rounded-md text-sm session-message" data-type="success">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ✨ A new verification link has been sent to your email address!
                        </div>
                    </div>
                @endif

                <div class="space-y-3">
                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-green-500 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-150 ease-in-out shadow-sm">
                            📧 Resend Verification Email
                        </button>
                    </form>

                    <!-- Log Out -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex justify-center py-2.5 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150 ease-in-out shadow-sm">
                            Log Out
                        </button>
                    </form>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already verified?
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
