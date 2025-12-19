<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <p class="mt-2 text-lg text-gray-600">Manage your account information and preferences</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('status') === 'profile-updated')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ Profile updated successfully!
            </div>
        @endif
        
        @if (session('status') === 'password-updated')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ Password updated successfully!
            </div>
        @endif
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                ❌ {{ session('error') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Profile Information -->
            <div class="bg-pink/90 backdrop-blur-md rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Profile Information</h2>
                </div>
                <div class="p-6">
                    <form method="post" action="{{ route('customer.profile.update') }}" class="space-y-6" enctype="multipart/form-data" onsubmit="console.log('Form onsubmit triggered'); return validateForm();">
                        @csrf
                        @method('patch')

                        <!-- Profile Picture -->
                            <div class="flex items-center space-x-4">
                                <img id="profile_preview" src="{{ $user->profile_picture_url ?: 'https://via.placeholder.com/80x80/e5e7eb/6b7280?text=No+Image' }}" alt="Profile Picture" class="rounded-full h-20 w-20 object-cover border-2 border-gray-200">
                                <div>
                                    <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                                    <input type="file"
                                           name="profile_picture"
                                           id="profile_picture"
                                           accept="image/*"
                                           onchange="previewImage(this)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    @error('profile_picture')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $user->name ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', $user->email ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', $user->phone ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <textarea name="address"
                                      id="address"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                            <input type="date"
                                   name="date_of_birth"
                                   id="date_of_birth"
                                   value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select name="gender"
                                    id="gender"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Two-Factor Authentication -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="two_factor_enabled" 
                                       value="1" 
                                       {{ ($user->two_factor_enabled ?? false) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                                <span class="ml-2 text-sm text-gray-700">Enable Two-Factor Authentication (Email)</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">Receive email codes for enhanced security</p>
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    onclick="console.log('Form submitting...'); return true;">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-pink/90 backdrop-blur-md rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Change Password</h2>
                </div>
                <div class="p-6">
                    <form method="post" action="{{ route('customer.profile.password') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('current_password') border-red-500 @enderror" required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror" required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        </div>

                        @if($user->two_factor_enabled ?? false)
                        <!-- 2FA Code -->
                        <div>
                            <label for="two_factor_code_password" class="block text-sm font-medium text-gray-700 mb-2">Verification Code</label>
                            <div class="flex space-x-2">
                                <input type="text"
                                       name="two_factor_code"
                                       id="two_factor_code_password"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                       placeholder="Enter 6-digit code"
                                       maxlength="6"
                                       required>
                                <button type="button" onclick="sendPasswordCode()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Send Email Code</button>
                            </div>
                            @error('two_factor_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Save Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-6 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-pink/90 backdrop-blur-md rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Delete Account</h2>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    <form method="post" action="{{ route('customer.profile.destroy') }}" class="space-y-6">
                        @csrf
                        @method('delete')

                        <!-- Password Confirmation -->
                        <div>
                            <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" id="delete_password" placeholder="Enter your password to confirm" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 @error('password') border-red-500 @enderror" required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($user->two_factor_enabled ?? false)
                        <!-- 2FA Code -->
                        <div>
                            <label for="two_factor_code_delete" class="block text-sm font-medium text-gray-700 mb-2">Verification Code</label>
                            <div class="flex space-x-2">
                                <input type="text"
                                       name="two_factor_code"
                                       id="two_factor_code_delete"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                       placeholder="Enter 6-digit code"
                                       maxlength="6"
                                       required>
                                <button type="button" onclick="sendDeleteCode()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Send Email Code</button>
                            </div>
                            @error('two_factor_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Delete Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                                Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('profile_preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function sendPasswordCode() {
            fetch('{{ route('customer.profile.send-2fa-code') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ action: 'password_change' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Verification code sent to your email!');
                } else {
                    alert('Failed to send code. Please try again.');
                }
            });
        }

        function sendDeleteCode() {
            fetch('{{ route('customer.profile.send-2fa-code') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ action: 'account_deletion' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Verification code sent to your email!');
                } else {
                    alert('Failed to send code. Please try again.');
                }
            });
        }
        
        function validateForm() {
            console.log('Form validation called');
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            
            if (!name.trim()) {
                alert('Name is required');
                return false;
            }
            
            if (!email.trim()) {
                alert('Email is required');
                return false;
            }
            
            console.log('Form validation passed');
            return true;
        }
    </script>
</x-customer-layout>