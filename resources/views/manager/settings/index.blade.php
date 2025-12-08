<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
                <p class="mt-2 text-lg text-gray-600">Configure Sally Salon settings and preferences</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('manager.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Salon Information -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Sally Salon Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="salon_name" class="block text-sm font-medium text-gray-700 mb-2">Salon Name *</label>
                            <input type="text"
                                   name="salon_name"
                                   id="salon_name"

                                   value="{{ old('salon_name', $settings['salon_name'] ?? 'Sally Salon') }}"

                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('salon_name') border-red-500 @enderror"
                                   required>
                            @error('salon_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="salon_email" class="block text-sm font-medium text-gray-700 mb-2">Salon Email *</label>
                            <input type="email"
                                   name="salon_email"
                                   id="salon_email"

                                   value="{{ old('salon_email', $settings['salon_email'] ?? 'info@beautysalon.com') }}"

                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('salon_email') border-red-500 @enderror"
                                   required>
                            @error('salon_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="salon_phone" class="block text-sm font-medium text-gray-700 mb-2">Salon Phone *</label>
                            <input type="tel"
                                   name="salon_phone"
                                   id="salon_phone"

                                   value="{{ old('salon_phone', $settings['salon_phone'] ?? '(555) 123-4567') }}"

                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('salon_phone') border-red-500 @enderror"
                                   required>
                            @error('salon_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="salon_address" class="block text-sm font-medium text-gray-700 mb-2">Salon Address *</label>
                            <input type="text"
                                   name="salon_address"
                                   id="salon_address"

                                   value="{{ old('salon_address', $settings['salon_address'] ?? '123 Beauty Street, Downtown, City 12345') }}"

                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('salon_address') border-red-500 @enderror"
                                   required>
                            @error('salon_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Working Hours -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Working Hours</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div class="flex items-center space-x-4">
                                <div class="w-20">
                                    <label class="text-sm font-medium text-gray-700 capitalize">{{ $day }}</label>
                                </div>
                                <div class="flex-1 flex items-center space-x-2">
                                    <input type="time"
                                           name="working_hours[{{ $day }}][start]"

                                           value="{{ old("working_hours.$day.start", $settings['working_hours'][$day]['start'] ?? '09:00') }}"

                                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span class="text-sm text-gray-500">to</span>
                                    <input type="time"
                                           name="working_hours[{{ $day }}][end]"

                                           value="{{ old("working_hours.$day.end", $settings['working_hours'][$day]['end'] ?? '17:00') }}"

                                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Booking Settings -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Booking Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="booking_advance_days" class="block text-sm font-medium text-gray-700 mb-2">Booking Advance Days *</label>
                            <input type="number" name="booking_advance_days" value="{{ $settings['booking_advance_days'] ?? 30 }}"
                                   name="booking_advance_days"
                                   id="booking_advance_days"
                                   value="{{ old('booking_advance_days', 30) }}"
                                   min="1"
                                   max="365"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('booking_advance_days') border-red-500 @enderror"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">How many days in advance can customers book?</p>
                            @error('booking_advance_days')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cancellation_hours" class="block text-sm font-medium text-gray-700 mb-2">Cancellation Hours *</label>
                            <input type="number" name="cancellation_hours" value="{{ $settings['cancellation_hours'] ?? 24 }}"
                                   name="cancellation_hours"
                                   id="cancellation_hours"
                                   value="{{ old('cancellation_hours', 24) }}"
                                   min="1"
                                   max="168"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('cancellation_hours') border-red-500 @enderror"
                                   required>
                            <p class="mt-1 text-sm text-gray-500">How many hours before appointment can customers cancel?</p>
                            @error('cancellation_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Notification Settings</h3>

                    @php
                        $notif = $settings['notification_settings'] ?? [];
                    @endphp

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="email_notifications"
                                   id="email_notifications"
                                   value="1"
                                   {{ old('email_notifications', $notif['email_notifications'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="email_notifications" class="ml-2 text-sm text-gray-700">
                                Enable Email Notifications
                            </label>
                        </div>



                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="appointment_reminders"
                                   id="appointment_reminders"
                                   value="1"
                                   {{ old('appointment_reminders', $notif['appointment_reminders'] ?? false) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="appointment_reminders" class="ml-2 text-sm text-gray-700">
                                Send Appointment Reminders
                            </label>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Social Media Settings -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">📱 Social Media & Promotion</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage your social media links to promote salon bookings</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">Facebook Page URL</label>
                            <input type="url"
                                   name="facebook_url"
                                   id="facebook_url"
                                   value="{{ old('facebook_url', $settings['facebook_url'] ?? 'https://facebook.com/sallysalon') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="https://facebook.com/yoursalon">
                            <p class="mt-1 text-xs text-gray-500">Customers can follow your Facebook page</p>
                        </div>

                        <div>
                            <label for="messenger_url" class="block text-sm font-medium text-gray-700 mb-2">Facebook Messenger URL</label>
                            <input type="url"
                                   name="messenger_url"
                                   id="messenger_url"
                                   value="{{ old('messenger_url', $settings['messenger_url'] ?? 'https://m.me/sallysalon') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="https://m.me/yoursalon">
                            <p class="mt-1 text-xs text-gray-500">Direct messaging for quick inquiries</p>
                        </div>

                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">Instagram Profile URL</label>
                            <input type="url"
                                   name="instagram_url"
                                   id="instagram_url"
                                   value="{{ old('instagram_url', $settings['instagram_url'] ?? 'https://instagram.com/sallysalon') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="https://instagram.com/yoursalon">
                            <p class="mt-1 text-xs text-gray-500">Showcase your work and attract customers</p>
                        </div>

                        <div>
                            <label for="tiktok_url" class="block text-sm font-medium text-gray-700 mb-2">TikTok Profile URL</label>
                            <input type="url"
                                   name="tiktok_url"
                                   id="tiktok_url"
                                   value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="https://tiktok.com/@yoursalon">
                            <p class="mt-1 text-xs text-gray-500">Share beauty tips and salon content</p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">💡 Promotion Tips</h4>
                        <ul class="text-xs text-blue-600 space-y-1">
                            <li>• Post before/after photos to showcase your work</li>
                            <li>• Share customer testimonials and reviews</li>
                            <li>• Promote special offers and new services</li>
                            <li>• Use hashtags like #SallySalon #BeautyBooking</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment Gateway Status -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment Gateway Status</h3>
                    
                    <div class="space-y-4">
                        <!-- Online Payment Status -->
                        <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800">Online Payment Gateway</h4>
                                    <p class="text-sm text-yellow-700">No online payment gateway configured</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Not Connected
                            </span>
                        </div>

                        <!-- Manual Payment Status -->
                        <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-green-800">Manual Payment Processing</h4>
                                    <p class="text-sm text-green-700">Cash and manual payment recording enabled</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>

                        <!-- Payment Methods Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">Available Payment Methods</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Cash</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Credit Card</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Debit Card</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Bank Transfer</span>
                            </div>
                            <p class="text-xs text-blue-600 mt-2">Payments are recorded manually by staff members</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                    Save Settings
                </button>
            </div>
        </form>


    </div>
</x-manager-layout>
