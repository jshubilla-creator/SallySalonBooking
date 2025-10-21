<x-admin-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Add Specialist</h1>
                        <p class="mt-2 text-lg text-gray-600">Create a new specialist profile</p>
                    </div>
                    <a href="{{ route('admin.staff.index') }}"
                       class="px-4 py-2 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Back to Staff
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Specialist Information</h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.staff.store-specialist') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('phone') border-red-500 @enderror"
                                   required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Specialization *</label>
                            <input type="text"
                                   name="specialization"
                                   id="specialization"
                                   value="{{ old('specialization') }}"
                                   placeholder="e.g., Hair Stylist, Nail Technician, Makeup Artist"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('specialization') border-red-500 @enderror"
                                   required>
                            @error('specialization')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Experience Years -->
                        <div>
                            <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">Years of Experience *</label>
                            <input type="number"
                                   name="experience_years"
                                   id="experience_years"
                                   value="{{ old('experience_years') }}"
                                   min="0"
                                   max="50"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('experience_years') border-red-500 @enderror"
                                   required>
                            @error('experience_years')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea name="bio"
                                      id="bio"
                                      rows="4"
                                      placeholder="Tell us about the specialist's background, skills, and expertise..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Services -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Services *</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($services as $service)
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="services[]"
                                               value="{{ $service->id }}"
                                               id="service_{{ $service->id }}"
                                               {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <label for="service_{{ $service->id }}" class="ml-2 text-sm text-gray-700">
                                            {{ $service->name }} - ${{ number_format($service->price, 2) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('services')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Working Hours -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Working Hours *</label>
                            <div class="space-y-3">
                                @php
                                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                    $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                @endphp
                                @foreach($days as $index => $day)
                                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-24">
                                            <label class="text-sm font-medium text-gray-700">{{ $dayNames[$index] }}</label>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox"
                                                   name="working_hours[{{ $index }}][is_available]"
                                                   value="1"
                                                   id="available_{{ $day }}"
                                                   {{ old("working_hours.{$index}.is_available") ? 'checked' : '' }}
                                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                            <label for="available_{{ $day }}" class="text-sm text-gray-700">Available</label>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <input type="time"
                                                   name="working_hours[{{ $index }}][start_time]"
                                                   value="{{ old("working_hours.{$index}.start_time", '09:00') }}"
                                                   class="px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                                            <span class="text-sm text-gray-500">to</span>
                                            <input type="time"
                                                   name="working_hours[{{ $index }}][end_time]"
                                                   value="{{ old("working_hours.{$index}.end_time", '17:00') }}"
                                                   class="px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                                        </div>
                                        <input type="hidden" name="working_hours[{{ $index }}][day]" value="{{ $day }}">
                                    </div>
                                @endforeach
                            </div>
                            @error('working_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.staff.index') }}"
                               class="px-6 py-2 bg-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                Create Specialist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
