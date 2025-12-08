<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Add New Specialist</h1>
                <p class="mt-2 text-lg text-gray-600">Add a new team member to your salon</p>
            </div>
            <a href="{{ route('manager.specialists.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                Back to Specialists
            </a>
        </div>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('manager.specialists.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-blue-100 shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
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
                               value="{{ old('phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Specialization -->
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Specialization *</label>
                        <select name="specialization"
                                id="specialization"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('specialization') border-red-500 @enderror"
                                required>
                            <option value="">Select Specialization</option>
                            <option value="Hair Stylist" {{ old('specialization') === 'Hair Stylist' ? 'selected' : '' }}>Hair Stylist</option>
                            <option value="Master Hair Stylist" {{ old('specialization') === 'Master Hair Stylist' ? 'selected' : '' }}>Master Hair Stylist</option>
                            <option value="Nail Artist" {{ old('specialization') === 'Nail Artist' ? 'selected' : '' }}>Nail Artist</option>
                            <option value="Beauty Specialist" {{ old('specialization') === 'Beauty Specialist' ? 'selected' : '' }}>Beauty Specialist</option>
                            <option value="Color Specialist" {{ old('specialization') === 'Color Specialist' ? 'selected' : '' }}>Color Specialist</option>
                        </select>
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
                               value="{{ old('experience_years', 0) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('experience_years') border-red-500 @enderror"
                               required>
                        @error('experience_years')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-2">Profile Image URL</label>
                        <input type="url"
                               name="profile_image"
                               id="profile_image"
                               value="{{ old('profile_image') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('profile_image') border-red-500 @enderror">
                        @error('profile_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea name="bio"
                                  id="bio"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('bio') border-red-500 @enderror"
                                  placeholder="Tell us about this specialist...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Working Hours -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Working Hours *</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox"
                                           name="working_hours[{{ $day }}][enabled]"
                                           id="working_hours_{{ $day }}_enabled"
                                           value="1"
                                           {{ old("working_hours.{$day}.enabled") ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <label for="working_hours_{{ $day }}_enabled" class="text-sm text-gray-700 capitalize">{{ $day }}</label>
                                    <div class="flex space-x-1">
                                        <input type="time"
                                               name="working_hours[{{ $day }}][start]"
                                               value="{{ old("working_hours.{$day}.start", '09:00') }}"
                                               class="text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                                        <span class="text-xs text-gray-500">to</span>
                                        <input type="time"
                                               name="working_hours[{{ $day }}][end]"
                                               value="{{ old("working_hours.{$day}.end", '17:00') }}"
                                               class="text-xs px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-green-500">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('working_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Services -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Services *</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($services as $service)
                                <div class="flex items-center">
                                    <input type="checkbox"
                                           name="services[]"
                                           id="service_{{ $service->id }}"
                                           value="{{ $service->id }}"
                                           {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <label for="service_{{ $service->id }}" class="ml-2 text-sm text-gray-700">{{ $service->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('services')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Available Status -->
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="is_available"
                                   id="is_available"
                                   value="1"
                                   {{ old('is_available', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="is_available" class="ml-2 text-sm text-gray-700">
                                Available (specialist can take appointments)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('manager.specialists.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Create Specialist
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-manager-layout>
