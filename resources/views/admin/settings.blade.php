<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
                <p class="mt-2 text-lg text-gray-600">Configure global system settings and preferences</p>
            </div>

            <div class="space-y-6">
                <!-- General Settings -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">General Settings</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- System Name -->
                            <div>
                                <label for="system_name" class="block text-sm font-medium text-gray-700 mb-2">System Name</label>
                                <input type="text"
                                       name="system_name"
                                       id="system_name"
                                       value="{{ old('system_name', $settings['salon_name'] ?? 'Salon Booking System') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('system_name') border-red-500 @enderror"
                                       required>
                                @error('system_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- System Email -->
                            <div>
                                <label for="system_email" class="block text-sm font-medium text-gray-700 mb-2">System Email</label>
                                <input type="email"
                                       name="system_email"
                                       id="system_email"
                                       value="{{ old('system_email', $settings['salon_email'] ?? 'admin@salon.com') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('system_email') border-red-500 @enderror"
                                       required>
                                @error('system_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- System Phone -->
                            <div>
                                <label for="system_phone" class="block text-sm font-medium text-gray-700 mb-2">System Phone</label>
                                <input type="tel"
                                       name="system_phone"
                                       id="system_phone"
                                       value="{{ old('system_phone', $settings['salon_phone'] ?? '+1 (555) 123-4567') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('system_phone') border-red-500 @enderror">
                                @error('system_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- System Address -->
                            <div>
                                <label for="system_address" class="block text-sm font-medium text-gray-700 mb-2">System Address</label>
                                <textarea name="system_address"
                                          id="system_address"
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('system_address') border-red-500 @enderror">{{ old('system_address', '123 Beauty Street, City, State 12345') }}</textarea>
                                @error('system_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Notification Settings</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.settings.notifications') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Email Notifications</h3>
                                        <p class="text-sm text-gray-500">Send email notifications for system events</p>
                                    </div>
                                    <input type="checkbox"
                                           name="email_notifications"
                                           value="1"
                                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                           {{ old('email_notifications', true) ? 'checked' : '' }}>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">SMS Notifications</h3>
                                        <p class="text-sm text-gray-500">Send SMS notifications for appointments</p>
                                    </div>
                                    <input type="checkbox"
                                           name="sms_notifications"
                                           value="1"
                                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                           {{ old('sms_notifications', true) ? 'checked' : '' }}>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Appointment Reminders</h3>
                                        <p class="text-sm text-gray-500">Send automatic appointment reminders</p>
                                    </div>
                                    <input type="checkbox"
                                           name="appointment_reminders"
                                           value="1"
                                           class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                           {{ old('appointment_reminders', true) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Save Notification Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- System Maintenance -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">System Maintenance</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Clear Cache</h3>
                                    <p class="text-sm text-gray-500">Clear application cache to improve performance</p>
                                </div>
                                <button type="button"
                                        class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    Clear Cache
                                </button>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Backup Database</h3>
                                    <p class="text-sm text-gray-500">Create a backup of the system database</p>
                                </div>
                                <button type="button"
                                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Backup Now
                                </button>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">System Logs</h3>
                                    <p class="text-sm text-gray-500">View and download system logs</p>
                                </div>
                                <button type="button"
                                        class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    View Logs
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
