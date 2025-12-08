<x-manager-layout>

    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Appointments</h1>
                <p class="mt-2 text-lg text-gray-600">Manage all salon appointments</p>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('manager.appointments.index') }}" class="space-y-4" id="appointmentSearchForm">
            <!-- Search Bar -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Search by customer name, email, or service..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date"
                           name="date"
                           id="date"
                           value="{{ request('date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label for="specialist_id" class="block text-sm font-medium text-gray-700 mb-1">Specialist</label>
                    <select name="specialist_id" id="specialist_id" onchange="document.getElementById('appointmentSearchForm').submit()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Specialists</option>
                        @foreach($specialists as $specialist)
                            <option value="{{ $specialist->id }}" {{ request('specialist_id') == $specialist->id ? 'selected' : '' }}>
                                {{ $specialist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                        Filter
                    </button>
                    <a href="{{ route('manager.appointments.index') }}"
                       class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialist</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                            @if($appointment->user->profile_photo_path)
                                                <img class="h-8 w-8 sm:h-10 sm:w-10 rounded-full object-cover" src="{{ Storage::url($appointment->user->profile_photo_path) }}" alt="{{ $appointment->user->name }}">
                                            @else
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <span class="text-xs sm:text-sm font-medium text-green-600">{{ substr($appointment->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-2 sm:ml-4">
                                            <a href="{{ route('manager.users.show', $appointment->user) }}" class="hover:text-green-600">
                                                <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $appointment->user->name }}</div>
                                                <div class="text-xs sm:text-sm text-gray-500">{{ $appointment->user->email }}</div>
                                                <!-- Show service and specialist on mobile -->
                                                <div class="sm:hidden text-xs text-gray-500 mt-1">
                                                    {{ $appointment->service->name }} • {{ $appointment->specialist->name }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->service->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->service->category }}</div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->specialist->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->specialist->specialization }}</div>
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">
                                        @php
                                            $startTime = \Carbon\Carbon::parse($appointment->start_time);
                                            $endTime = \Carbon\Carbon::parse($appointment->end_time);
                                        @endphp
                                        {{ $startTime->format('g:i A') }} – {{ $endTime->format('g:i A') }}
                                    </div>
                                </td>
                                <td class="px-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($appointment->status === 'completed') bg-gray-100 text-gray-800
                                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₱{{ number_format($appointment->total_price, 2) }}
                                </td>
                                <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('manager.appointments.show', $appointment) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 hover:text-green-700 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>

                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{ route('manager.appointments.approve', $appointment) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($appointment->status, ['pending', 'confirmed']))
                                        <button type="button"
                                            onclick="openCancelModal({{ $appointment->id }})"
                                            class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Cancel
                                        </button>

                                        <form id="cancel-form-{{ $appointment->id }}" method="POST" action="{{ route('manager.appointments.cancel', $appointment) }}" class="hidden">
                                            @csrf
                                        </form>
                                        @endif

                                        @if($appointment->status === 'confirmed')
                                            <form method="POST" action="{{ route('manager.appointments.complete', $appointment) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Complete
                                                </button>
                                            </form>
                                        @endif

                                        @if(in_array($appointment->status, ['completed', 'cancelled']))
                                            <button type="button"
                                                onclick="openDeleteModal({{ $appointment->id }})"
                                                class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7-4h8a1 1 0 011 1v1H7V4a1 1 0 011-1z"></path>
                                                </svg>
                                                Delete
                                            </button>

                                            <form id="delete-form-{{ $appointment->id }}" method="POST" action="{{ route('manager.appointments.destroy', $appointment) }}" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($appointments->hasPages())
                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
<!-- Global Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-blue-50 rounded-lg shadow-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Cancel Appointment</h3>
        <p class="text-sm text-gray-600 mb-4">Please provide a reason for cancellation.</p>

        <form id="cancelForm" method="POST" onsubmit="handleCancelSubmit(event)">
            @csrf
            <textarea name="cancel_reason" rows="3" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                placeholder="Type your cancellation reason here..."></textarea>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeCancelModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button id="cancelSubmitBtn" type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Confirm Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Global Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-blue-50 rounded-lg shadow-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Appointment</h3>
        <p class="text-sm text-gray-600 mb-4">Please provide a reason for deletion. The customer will be notified.</p>
        
        <form id="deleteForm" onsubmit="handleDeleteSubmit(event)">
            <textarea id="deleteReason" rows="3" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 mb-4"
                placeholder="Enter deletion reason..."></textarea>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal />
    <script>
    let currentAppointmentId = null;
    let currentDeleteId = null;

    function openCancelModal(appointmentId) {
        currentAppointmentId = appointmentId;
        const form = document.getElementById('cancelForm');
        form.action = document.getElementById(`cancel-form-${appointmentId}`).action;
        document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
        currentAppointmentId = null;
    }

    function openDeleteModal(appointmentId) {
        currentDeleteId = appointmentId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        currentDeleteId = null;
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function handleDeleteSubmit(e) {
        e.preventDefault();
        if (currentDeleteId) {
            const reason = document.getElementById('deleteReason').value;
            const form = document.getElementById('delete-form-' + currentDeleteId);
            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'deletion_reason';
            reasonInput.value = reason;
            form.appendChild(reasonInput);
            form.submit();
        }
    }

    async function handleCancelSubmit(e) {
        e.preventDefault();
        if (!currentAppointmentId) return;

        const btn = document.getElementById('cancelSubmitBtn');
        btn.disabled = true;
        btn.textContent = 'Cancelling...';
        
        const cancelReason = e.target.querySelector('[name="cancel_reason"]').value;
        const form = document.getElementById(`cancel-form-${currentAppointmentId}`);
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'cancel_reason';
        reasonInput.value = cancelReason;
        form.appendChild(reasonInput);
        
        try {
            form.submit();
        } catch (err) {
            console.error(err);
            btn.disabled = false;
            btn.textContent = 'Confirm Cancel';
        }
    }
</script>

</x-manager-layout>
