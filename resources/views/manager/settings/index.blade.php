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

    <div class="max-w-4xl">
        <form action="{{ route('manager.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Salon Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Sally Salon Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="salon_name" class="block text-sm font-medium text-gray-700 mb-2">Salon Name *</label>
                            <input type="text"
                                   name="salon_name"
                                   id="salon_name"
                                   value="{{ old('salon_name', 'Sally Salon') }}"
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
                                   value="{{ old('salon_email', 'info@beautysalon.com') }}"
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
                                   value="{{ old('salon_phone', '(555) 123-4567') }}"
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
                                   value="{{ old('salon_address', '123 Beauty Street, Downtown, City 12345') }}"
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
            <div class="bg-white shadow rounded-lg">
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
                                           value="{{ old("working_hours.{$day}.start", '09:00') }}"
                                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span class="text-sm text-gray-500">to</span>
                                    <input type="time"
                                           name="working_hours[{{ $day }}][end]"
                                           value="{{ old("working_hours.{$day}.end", '17:00') }}"
                                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Booking Settings -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Booking Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="booking_advance_days" class="block text-sm font-medium text-gray-700 mb-2">Booking Advance Days *</label>
                            <input type="number"
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
                            <input type="number"
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

            <!-- SMS Settings -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">SMS Settings</h3>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="sms_enabled"
                                   id="sms_enabled"
                                   value="1"
                                   {{ old('sms_enabled', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="sms_enabled" class="ml-2 text-sm text-gray-700">
                                Enable SMS notifications
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="sms_reminders"
                                   id="sms_reminders"
                                   value="1"
                                   {{ old('sms_reminders', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="sms_reminders" class="ml-2 text-sm text-gray-700">
                                Send appointment reminders
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="sms_confirmations"
                                   id="sms_confirmations"
                                   value="1"
                                   {{ old('sms_confirmations', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="sms_confirmations" class="ml-2 text-sm text-gray-700">
                                Send appointment confirmations
                            </label>
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
