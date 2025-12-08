<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <img src="{{ asset('SallySalon.png') }}" alt="Sally Salon" class="mx-auto w-16 h-16 mb-4">
                <h2 class="text-2xl font-salon font-bold text-gray-900 mb-1">
                    🔐 Two-Factor Authentication
                </h2>
                <p class="text-sm text-gray-600">
                    Enter the 6-digit code sent to your phone
                </p>
            </div>

            <!-- 2FA Form -->
            <div class="bg-pink/90 backdrop-blur-md rounded-2xl shadow-xl p-8 space-y-6">
                @if (session('status'))
                    <div class="p-3 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-green-200 text-green-800 rounded-md text-sm session-message" data-type="success">
                        <div class="flex items-center">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-5">
                    @csrf

                    <!-- Verification Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            📱 Verification Code
                        </label>
                        <input id="code"
                               type="text"
                               name="code"
                               maxlength="6"
                               required
                               autofocus
                               class="w-full px-3 py-3 text-center text-2xl font-mono border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('code') border-red-500 @enderror"
                               placeholder="000000">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-green-500 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-150 ease-in-out shadow-sm">
                        ✨ Verify & Enter Salon
                    </button>
                </form>

                <!-- Resend Code -->
                <div class="text-center">
                    <form method="POST" action="{{ route('two-factor.resend') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-green-600 hover:text-green-500 font-medium">
                            📲 Resend Code
                        </button>
                    </form>
                </div>

                <!-- Logout -->
                <div class="text-center">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-500">
                            Sign out
                        </button>
                    </form>
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

            // Auto-format code input
            const codeInput = document.getElementById('code');
            codeInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        });
    </script>
</x-guest-layout>