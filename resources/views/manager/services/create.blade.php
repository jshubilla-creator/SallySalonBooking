<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Add New Service</h1>
                <p class="mt-2 text-lg text-gray-600">Create a new salon service</p>
            </div>
            <a href="{{ route('manager.services.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                Back to Services
            </a>
        </div>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('manager.services.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Service Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Service Name *</label>
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

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select name="category"
                                id="category"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('category') border-red-500 @enderror"
                                required>
                            <option value="">Select Category</option>
                            <option value="Hair" {{ old('category') === 'Hair' ? 'selected' : '' }}>Hair</option>
                            <option value="Nail" {{ old('category') === 'Nail' ? 'selected' : '' }}>Nail</option>
                            <option value="Treatment" {{ old('category') === 'Treatment' ? 'selected' : '' }}>Treatment</option>
                            <option value="Beauty" {{ old('category') === 'Beauty' ? 'selected' : '' }}>Beauty</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₱</span>
                            </div>
                            <input type="number"
                                   name="price"
                                   id="price"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('price') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Duration -->
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes) *</label>
                        <input type="number"
                               name="duration_minutes"
                               id="duration_minutes"
                               value="{{ old('duration_minutes', 60) }}"
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('duration_minutes') border-red-500 @enderror"
                               required>
                        @error('duration_minutes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                        <input type="url"
                               name="image"
                               id="image"
                               value="{{ old('image') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 @error('image') border-red-500 @enderror">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Active (service is available for booking)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('manager.services.index') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Create Service
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-manager-layout>
