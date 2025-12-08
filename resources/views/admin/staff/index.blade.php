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
                           class="flex items-center  justify-center px-4 py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Staff Member
                        </a>
                        <a href="{{ route('admin.staff.create-specialist') }}"
                           class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Specialist
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg p-6 mb-6">
                <!-- Staff Search Form -->
                <form method="GET" action="{{ route('admin.staff.index') }}" class="space-y-4">
                    <input type="hidden" name="tab" value="staff">
                    <div id="staff-search" class="search-section {{ $activeTab === 'staff' ? '' : 'hidden' }}">
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
                                <a href="{{ route('admin.staff.index', ['tab' => 'staff']) }}"
                                   class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Specialists Search Form -->
                <form method="GET" action="{{ route('admin.staff.index') }}" class="space-y-4">
                    <input type="hidden" name="tab" value="specialists">
                    <div id="specialists-search" class="search-section {{ $activeTab === 'specialists' ? '' : 'hidden' }}">
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
                                <a href="{{ route('admin.staff.index', ['tab' => 'specialists']) }}"
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
                                class="tab-button py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'staff' ? 'active' : '' }}"
                                data-tab="staff">
                            Staff Members ({{ $staff->total() }})
                        </button>
                        <button onclick="showTab('specialists')"
                                class="tab-button py-2 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'specialists' ? 'active' : '' }}"
                                data-tab="specialists">
                            Specialists ({{ $specialists->total() }})
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Staff Members Tab -->
            <div id="staff-tab" class="tab-content {{ $activeTab === 'staff' ? '' : 'hidden' }}">
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow-md border border-gray-200 rounded-lg">
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
                            <tbody class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 divide-y divide-gray-200">
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
                                                        onclick="openDeleteModal('staff', {{ $member->id }}, '{{ $member->name }}')"
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
            <div id="specialists-tab" class="tab-content {{ $activeTab === 'specialists' ? '' : 'hidden' }}">
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow-md border border-gray-200 rounded-lg">
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
                            <tbody class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 divide-y divide-gray-200">
                                @forelse($specialists as $specialist)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 flex items-center justify-center">
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
                                                <a href="{{ route('admin.staff.show-specialist', $specialist) }}"
                                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 hover:text-green-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('admin.staff.edit-specialist', $specialist) }}"
                                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button type="button"
                                                        onclick="openDeleteModal('specialist', {{ $specialist->id }}, '{{ $specialist->name }}')"
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

        // Initialize with correct tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('{{ $activeTab }}');
        });
    </script>

    <style>
        .tab-button.active {
            border-color: #8b5cf6;
            color: #8b5cf6;
        }
    </style>

    <!-- Specialist View Modal -->
    <div id="specialist-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-blue-50 shadow-lg max-w-2xl w-full max-h-[90vh] flex flex-col rounded-lg overflow-hidden">
            <div class="bg-blue-50 rounded-lg px-6 py-4 border-b border-gray-200 flex justify-between items-center flex-shrink-0">
                <h3 class="text-xl font-semibold text-gray-900">Specialist Details</h3>
                <button type="button" onclick="closeSpecialistModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-4 space-y-6 overflow-y-auto flex-1">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-medium text-gray-900">Basic Information</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500">Name</label>
                            <p id="modal-name" class="text-gray-900 font-medium"></p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p id="modal-email" class="text-gray-900 font-medium"></p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Phone</label>
                            <p id="modal-phone" class="text-gray-900 font-medium"></p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Specialization</label>
                            <p id="modal-specialization" class="text-gray-900 font-medium"></p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Experience</label>
                            <p id="modal-experience" class="text-gray-900 font-medium"></p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Status</label>
                            <p id="modal-status" class="text-gray-900 font-medium"></p>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label class="text-sm text-gray-500">Bio</label>
                    <p id="modal-bio" class="text-gray-900 text-sm mt-1"></p>
                </div>

                <!-- Services -->
                <div>
                    <label class="text-sm font-medium text-gray-900 mb-2 block">Services</label>
                    <div id="modal-services" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- Working Hours -->
                <div>
                    <label class="text-sm font-medium text-gray-900 mb-3 block">Working Hours</label>
                    <div id="modal-working-hours" class="space-y-2"></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 px-6 py-4 border-t border-gray-200 bg-blue-100 flex-shrink-0 rounded-b-lg">
                <button type="button" onclick="closeSpecialistModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Close
                </button>
                <a id="modal-edit-link" href="#" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                    Edit
                </a>
            </div>
        </div>
    </div>

    <script>
        function openSpecialistModal(id, name, email, phone, specialization, experience, bio, workingHours, services, isAvailable) {
            // Basic info
            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-email').textContent = email;
            document.getElementById('modal-phone').textContent = phone || 'N/A';
            document.getElementById('modal-specialization').textContent = specialization;
            document.getElementById('modal-experience').textContent = experience + ' years';
            document.getElementById('modal-status').innerHTML = isAvailable 
                ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Available</span>'
                : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Unavailable</span>';
            document.getElementById('modal-bio').textContent = bio || 'No bio provided';

            // Services
            const servicesContainer = document.getElementById('modal-services');
            servicesContainer.innerHTML = '';
            if (services && services.length > 0) {
                services.forEach(service => {
                    const badge = document.createElement('span');
                    badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                    badge.textContent = service;
                    servicesContainer.appendChild(badge);
                });
            } else {
                servicesContainer.innerHTML = '<span class="text-gray-500 text-sm">No services assigned</span>';
            }

            // Working Hours
            const hoursContainer = document.getElementById('modal-working-hours');
            hoursContainer.innerHTML = '';
            const dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const dayKeys = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            
            dayKeys.forEach((dayKey, index) => {
                const dayData = workingHours[dayKey];
                const isOpen = dayData && dayData.enabled;
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-2 px-3 bg-gray-50 rounded';
                row.innerHTML = `
                    <span class="text-sm font-medium text-gray-700">${dayNames[index]}</span>
                    <span class="text-sm ${isOpen ? 'text-gray-900' : 'text-gray-500'}">
                        ${isOpen ? (dayData.start + ' - ' + dayData.end) : 'Closed'}
                    </span>
                `;
                hoursContainer.appendChild(row);
            });

            // Edit link
            document.getElementById('modal-edit-link').href = '/admin/staff/' + id + '/edit-specialist';

            // Show modal
            document.getElementById('specialist-modal').classList.remove('hidden');
        }

        function closeSpecialistModal() {
            document.getElementById('specialist-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('specialist-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSpecialistModal();
            }
        });
    </script>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-blue-50 rounded-lg shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="delete-modal-title">Confirm Deletion</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-700" id="delete-modal-message">Are you sure you want to delete this item? This action cannot be undone.</p>
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
        let deleteType = '';
        let deleteId = '';
        let deleteName = '';

        function openDeleteModal(type, id, name) {
            deleteType = type;
            deleteId = id;
            deleteName = name;
            
            const modal = document.getElementById('delete-modal');
            const title = document.getElementById('delete-modal-title');
            const message = document.getElementById('delete-modal-message');
            
            if (type === 'staff') {
                title.textContent = 'Delete Staff Member';
                message.textContent = `Are you sure you want to delete staff member "${name}"? This action cannot be undone.`;
            } else {
                title.textContent = 'Delete Specialist';
                message.textContent = `Are you sure you want to delete specialist "${name}"? This action cannot be undone.`;
            }
            
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function confirmDelete() {
            if (deleteType === 'staff') {
                document.getElementById(`delete-form-${deleteId}`).submit();
            } else {
                document.getElementById(`delete-specialist-form-${deleteId}`).submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>

    <!-- Confirmation Modal -->
    <x-confirmation-modal />
</x-admin-layout>