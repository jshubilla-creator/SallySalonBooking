<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Specialists Management</h1>
                <p class="mt-2 text-lg text-gray-600">Manage salon specialists and their services</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('manager.specialists.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                    Add New Specialist
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('manager.specialists.index') }}" class="space-y-4">
            <!-- Search Bar -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, specialization, or bio..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
                    <select name="specialization" id="specialization" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization }}" {{ request('specialization') === $specialization ? 'selected' : '' }}>
                                {{ $specialization }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="availability" class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                    <select name="availability" id="availability" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Availability</option>
                        <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                        Search & Filter
                    </button>
                    <a href="{{ route('manager.specialists.index') }}"
                       class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Specialists Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($specialists as $specialist)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12">
                            @if($specialist->profile_image)
                                <img class="h-12 w-12 rounded-full object-cover" src="{{ $specialist->profile_image }}" alt="{{ $specialist->name }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-lg font-medium text-green-600">{{ substr($specialist->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-medium text-gray-900">{{ $specialist->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $specialist->specialization }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            @if($specialist->is_available)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Unavailable
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-600">{{ $specialist->bio }}</p>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $specialist->experience_years }} years experience
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Services</h4>
                        <div class="flex flex-wrap gap-1">
                            @forelse($specialist->services->take(3) as $service)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $service->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-500">No services assigned</span>
                            @endforelse
                            @if($specialist->services->count() > 3)
                                <span class="text-xs text-gray-500">+{{ $specialist->services->count() - 3 }} more</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-2 sm:justify-between sm:items-center">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('manager.specialists.show', $specialist) }}"
                               class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 hover:text-green-700 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            <a href="{{ route('manager.specialists.edit', $specialist) }}"
                               class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                        <button type="button"
                                onclick="showConfirmation('Delete Specialist', 'Are you sure you want to delete this specialist? This action cannot be undone.', function() { document.getElementById('delete-form-{{ $specialist->id }}').submit(); })"
                                class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                        <form id="delete-form-{{ $specialist->id }}" method="POST" action="{{ route('manager.specialists.destroy', $specialist) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No specialists</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new specialist.</p>
                    <div class="mt-6">
                        <a href="{{ route('manager.specialists.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Add New Specialist
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($specialists->hasPages())
        <div class="mt-8">
            {{ $specialists->links() }}
        </div>
    @endif

    <!-- Confirmation Modal -->
    <x-confirmation-modal />
</x-manager-layout>
