<x-admin-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Specialist Details</h1>
                        <p class="mt-2 text-lg text-gray-600">View specialist information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.staff.index', ['tab' => 'specialists']) }}"
                           class="flex items-center justify-center px-4 py-2 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            Back to Specialists
                        </a>
                    </div>
                </div>
            </div>

            <!-- Specialist Information -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Personal Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-lg text-gray-900">{{ $specialist->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p class="text-lg text-gray-900">{{ $specialist->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-lg text-gray-900">{{ $specialist->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Specialization</label>
                            <p class="text-lg text-gray-900">{{ $specialist->specialization }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Experience</label>
                            <p class="text-lg text-gray-900">{{ $specialist->experience_years }} years</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $specialist->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $specialist->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </div>

                    @if($specialist->bio)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Bio</label>
                            <p class="text-lg text-gray-900">{{ $specialist->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Services -->
            <div class="mt-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Services</h2>
                </div>
                <div class="p-6">
                    @if($specialist->services->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($specialist->services as $service)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $service->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No services assigned</p>
                    @endif
                </div>
            </div>

            <!-- Working Hours -->
            <div class="mt-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Working Hours</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @php
                            $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            $dayKeys = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        @endphp
                        @foreach($dayKeys as $index => $dayKey)
                            @php
                                $dayData = $specialist->working_hours[$dayKey] ?? null;
                                $isOpen = $dayData && ($dayData['enabled'] ?? false);
                            @endphp
                            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded">
                                <span class="text-sm font-medium text-gray-700">{{ $dayNames[$index] }}</span>
                                <span class="text-sm {{ $isOpen ? 'text-gray-900' : 'text-gray-500' }}">
                                    @if($isOpen)
                                        {{ $dayData['start'] ?? '09:00' }} - {{ $dayData['end'] ?? '17:00' }}
                                    @else
                                        Closed
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="mt-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Account Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Added Since</label>
                            <p class="text-lg text-gray-900">{{ $specialist->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-lg text-gray-900">{{ $specialist->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Actions</h2>
                </div>
                <div class="p-6">
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.staff.edit-specialist', $specialist) }}"
                           class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Specialist
                        </a>
                        <button type="button"
                                onclick="openDeleteModal()"
                                class="flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            Delete Specialist
                        </button>
                        <form id="delete-form" method="POST" action="{{ route('admin.staff.destroy-specialist', $specialist) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-blue-50 rounded-lg shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Delete Specialist</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-700">Are you sure you want to delete specialist "{{ $specialist->name }}"? This action cannot be undone.</p>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function confirmDelete() {
            document.getElementById('delete-form').submit();
        }

        // Close modal when clicking outside
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-admin-layout>