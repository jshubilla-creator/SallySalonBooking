<x-manager-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Appointment Details</h1>
                <p class="mt-2 text-lg text-gray-600">View and manage appointment information</p>
            </div>
            <a href="{{ route('manager.appointments.index') }}"
               class="flex items-center justify-center bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200 text-center">
               <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Appointments
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- MAIN CONTENT -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Appointment Information -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Customer</label>
                            <div class="mt-1 flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-green-600">{{ substr($appointment->user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $appointment->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Service -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Service</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->service->name }}</p>
                            <p class="text-sm text-gray-500">{{ $appointment->service->category }}</p>
                        </div>

                        <!-- Specialist -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Specialist</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->specialist->name }}</p>
                            <p class="text-sm text-gray-500">{{ $appointment->specialist->specialization }}</p>
                        </div>

                        <!-- Date & Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Date & Time</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $appointment->appointment_date->format('M d, Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ \App\Helpers\TimeHelper::formatTimeRange($appointment->start_time, $appointment->end_time) }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 block text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($appointment->status === 'completed') bg-gray-100 text-gray-800
                                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-purple-100 text-purple-800 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Total Price</label>
                            <p class="mt-1 text-sm font-medium text-gray-900">
                                ₱{{ number_format($appointment->total_price, 2) }}
                            </p>
                        </div>
                    </div>

                    @if($appointment->notes)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500">Notes</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->notes }}</p>
                        </div>
                    @endif

                    @if($appointment->is_home_service)
                        <div class="mt-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Home Service
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->user->email }}</p>
                        </div>

                        @if($appointment->user->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $appointment->user->phone }}</p>
                            </div>
                        @endif

                        @if($appointment->user->address)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Address</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $appointment->user->address }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- SIDEBAR -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        @if($appointment->status === 'pending')
                            <form method="POST" action="{{ route('manager.appointments.approve', $appointment) }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center justify-center w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve Appointment
                                </button>
                            </form>
                        @endif

                            @if(in_array($appointment->status, ['pending', 'confirmed']))
                                <button type="button"
                                    onclick="openCancelModal()"
                                    class="flex items-center justify-center w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel Appointment
                                </button>
                            @endif


                        @if($appointment->status === 'confirmed')
                            <form method="POST" action="{{ route('manager.appointments.complete', $appointment) }}">
                                @csrf
                                <button type="submit"
                                        class="flex items-center justify-center w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    Mark as Complete
                                </button>
                            </form>
                        @endif

                        <!-- Delete with Modal -->
                        @if(in_array($appointment->status, ['completed', 'cancelled']))
                            <button type="button"
                                    onclick="openDeleteModal()"
                                    class="flex items-center justify-center w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7-4h8a1 1 0 011 1v1H7V4a1 1 0 011-1z"></path>
                                </svg>
                                Delete Appointment
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Service Details</h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Service Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->service->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Category</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->service->category }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Price</label>
                            <p class="mt-1 text-sm text-gray-900">₱{{ number_format($appointment->service->price, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Duration</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $appointment->service->duration_minutes }} minutes</p>
                        </div>

                        @if($appointment->service->description)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Description</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $appointment->service->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-blue-50 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Appointment</h3>
            <p class="text-sm text-gray-600 mb-4">
                Please provide a reason for deleting this appointment. The customer will be notified via email.
            </p>

            <form id="delete-form" method="POST" action="{{ route('manager.appointments.destroy', $appointment) }}"
                onsubmit="handleDeleteSubmit(event)">
                @csrf
                @method('DELETE')

                <textarea name="deletion_reason" rows="3" required
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                        placeholder="Type your reason here..."></textarea>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button id="delete-submit-btn" type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Confirm Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-blue-50 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Cancel Appointment</h3>
            <p class="text-sm text-gray-600 mb-4">
                Please provide a reason for cancelling this appointment. The customer will receive an email notification.
            </p>

            <form id="cancel-form" method="POST" action="{{ route('manager.appointments.cancel', $appointment) }}" onsubmit="handleCancelSubmit(event)">
                @csrf

                <textarea name="cancel_reason" rows="3" required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                    placeholder="Type your cancellation reason here..."></textarea>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeCancelModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button id="cancel-submit-btn" type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Confirm Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        async function handleDeleteSubmit(e) {
            e.preventDefault();

            const button = document.getElementById('delete-submit-btn');
            button.disabled = true;
            button.textContent = 'Deleting...';

            try {
                await e.target.submit();
            } catch (err) {
                console.error(err);
                button.disabled = false;
                button.textContent = 'Confirm Delete';
            }
        }
    </script>
    <script>
    function openCancelModal() {
        document.getElementById('cancelModal').classList.remove('hidden');
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }

    async function handleCancelSubmit(e) {
        e.preventDefault();

        const button = document.getElementById('cancel-submit-btn');
        button.disabled = true;
        button.textContent = 'Cancelling...';

        try {
            e.target.submit();
        } catch (err) {
            console.error(err);
            button.disabled = false;
            button.textContent = 'Confirm Cancel';
        }
    }
</script>

</x-manager-layout>
