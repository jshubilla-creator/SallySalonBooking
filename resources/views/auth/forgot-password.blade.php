<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-sm w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">
                    Forgot Password?
                </h2>
                <p class="text-sm text-gray-600">
                    No problem! Enter your email and we'll send you a reset link.
                </p>
            </div>

            <!-- Forgot Password Form -->
            <div class="space-y-6">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded-md text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email Address
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
                                class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150 ease-in-out shadow-sm">
                            Send Reset Link
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Remember your password?
                        <a href="{{ route('login') }}"
                           class="font-medium text-green-600 hover:text-green-500 transition-colors duration-150 ease-in-out">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
