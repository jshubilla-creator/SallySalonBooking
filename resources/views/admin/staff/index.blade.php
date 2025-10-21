<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Staff Management</h1>
                        <p class="mt-2 text-lg text-gray-600">Manage staff members and specialists</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.staff.create') }}"
                           class="px-4 py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            Add Staff Member
                        </a>
                        <a href="{{ route('admin.staff.create-specialist') }}"
                           class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Specialist
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('admin.staff.index') }}" class="space-y-4">
                    <!-- Staff Search -->
                    <div id="staff-search" class="search-section">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Search Staff Members</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="staff_search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text"
                                       name="staff_search"
                                       id="staff_search"
                                       value="{{ request('staff_search') }}"
                                       placeholder="Search by name, email, or phone..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>
                            <div>
                                <label for="staff_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select name="staff_role" id="staff_role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="">All Roles</option>
                                    @foreach($staffRoles as $role)
                                        <option value="{{ $role }}" {{ request('staff_role') === $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                        class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors duration-200">
                                    Search Staff
                                </button>
                                <a href="{{ route('admin.staff.index') }}"
                                   class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Specialists Search -->
                    <div id="specialists-search" class="search-section hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Search Specialists</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="specialist_search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text"
                                       name="specialist_search"
                                       id="specialist_search"
                                       value="{{ request('specialist_search') }}"
                                       placeholder="Search by name, email, or specialization..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="specialist_specialization" class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
                                <select name="specialist_specialization" id="specialist_specialization" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Specializations</option>
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization }}" {{ request('specialist_specialization') === $specialization ? 'selected' : '' }}>
                                            {{ $specialization }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit"
                                        class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                    Search Specialists
                                </button>
                                <a href="{{ route('admin.staff.index') }}"
                                   class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="showTab('staff')"
                                class="tab-button py-2 px-1 border-b-2 font-medium text-sm active"
                                data-tab="staff">
                            Staff Members ({{ $staff->total() }})
                        </button>
                        <button onclick="showTab('specialists')"
                                class="tab-button py-2 px-1 border-b-2 font-medium text-sm"
                                data-tab="specialists">
                            Specialists ({{ $specialists->total() }})
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Staff Members Tab -->
            <div id="staff-tab" class="tab-content">
                <div class="bg-white shadow-md border border-gray-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Staff Members</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($staff as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-purple-600">
                                                            {{ substr($member->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $member->hasRole('admin') ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $member->roles->first()->name ?? 'No Role' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->phone ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('admin.staff.show', $member) }}"
                                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 border border-purple-200 rounded-md hover:bg-purple-100 hover:text-purple-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('admin.staff.edit', $member) }}"
                                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button type="button"
                                                        onclick="showConfirmation('Delete Staff Member', 'Are you sure you want to delete this staff member? This action cannot be undone.', function() { document.getElementById('delete-form-{{ $member->id }}').submit(); })"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                                <form id="delete-form-{{ $member->id }}" method="POST" action="{{ route('admin.staff.destroy', $member) }}" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No staff members found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $staff->links() }}
                    </div>
                </div>
            </div>

            <!-- Specialists Tab -->
            <div id="specialists-tab" class="tab-content hidden">
                <div class="bg-white shadow-md border border-gray-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Specialists</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialization</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($specialists as $specialist)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600">
                                                            {{ substr($specialist->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $specialist->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $specialist->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $specialist->specialization }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $specialist->experience_years }} years</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $specialist->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $specialist->is_available ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('admin.staff.edit-specialist', $specialist) }}"
                                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button type="button"
                                                        onclick="showConfirmation('Delete Specialist', 'Are you sure you want to delete this specialist? This action cannot be undone.', function() { document.getElementById('delete-specialist-form-{{ $specialist->id }}').submit(); })"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                                <form id="delete-specialist-form-{{ $specialist->id }}" method="POST" action="{{ route('admin.staff.destroy-specialist', $specialist) }}" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No specialists found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $specialists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Hide all search sections
            document.querySelectorAll('.search-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-purple-500', 'text-purple-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');

            // Show corresponding search section
            document.getElementById(tabName + '-search').classList.remove('hidden');

            // Add active class to selected tab button
            const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
            activeButton.classList.add('active', 'border-purple-500', 'text-purple-600');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }

        // Initialize with staff tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('staff');
        });
    </script>

    <style>
        .tab-button.active {
            border-color: #8b5cf6;
            color: #8b5cf6;
        }
    </style>

    <!-- Confirmation Modal -->
    <x-confirmation-modal />
</x-admin-layout>
