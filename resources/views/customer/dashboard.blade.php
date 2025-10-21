<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8 border border-gray-200">
            <div class="text-gray-900">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-lg text-gray-600">Book your next beauty appointment with our expert specialists</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('customer.appointments.create') }}"
               class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200 border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Book Appointment</h3>
                        <p class="text-gray-600">Schedule your next visit</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('customer.services.index') }}"
               class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200 border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Our Services</h3>
                        <p class="text-gray-600">Explore beauty treatments</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('customer.specialists.index') }}"
               class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200 border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Our Specialists</h3>
                        <p class="text-gray-600">Meet our experts</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Appointments -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Your Recent Appointments</h2>
            </div>
            <div class="p-6">
                @if($appointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($appointments as $appointment)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50"
                        data-appointment-id="{{ $appointment->id }}"
                        data-appointment-address="{{ $appointment->home_address ?? 'N/A' }}"
                        data-appointment-tip="{{ $appointment->tip_amount ? number_format($appointment->tip_amount, 2) : '0.00' }}"
                        data-appointment-home-service="{{ $appointment->is_home_service ? 'Yes' : 'No' }}"
                        data-appointment-payment-method="{{ $appointment->payment_method ?? 'N/A' }}"
                        data-appointment-reason="{{ $appointment->cancellation_reason ?? 'No reason provided' }}">
                        



                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900"
                                            data-service-name="{{ $appointment->service->name }}">{{ $appointment->service->name }}</h3>
                                        <p class="text-sm text-gray-600"
                                           data-specialist-name="{{ $appointment->specialist->name }}">with {{ $appointment->specialist->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            <span data-appointment-date="{{ $appointment->appointment_date->format('M d, Y') }}">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                                            at <span data-appointment-time="{{ $appointment->start_time }}">{{ \App\Helpers\TimeHelper::formatTo12Hour($appointment->start_time) }}</span>
                                        </p>
                                        <p class="mt-1 text-sm font-medium">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                @switch(strtolower($appointment->payment_method))
                                                    @case('gcash') bg-blue-100 text-blue-800 @break
                                                    @case('maya') bg-green-100 text-green-800 @break
                                                    @case('cash') bg-yellow-100 text-yellow-800 @break
                                                    @case('debit' || 'credit') bg-purple-100 text-purple-800 @break
                                                    @default bg-gray-100 text-gray-800
                                                @endswitch">
                                                @switch(strtolower($appointment->payment_method))
                                                    @case('gcash') 💙 GCash @break
                                                    @case('maya') 💚 Maya @break
                                                    @case('cash') 💵 Cash @break
                                                    @case('debit' || 'credit') 💳 Debit / Credit @break
                                                    @default 💰 {{ ucfirst($appointment->payment_method ?? 'N/A') }}
                                                @endswitch
                                            </span>
                                        </p>

                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                            @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif"
                                            data-appointment-status="{{ ucfirst($appointment->status) }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        @if($appointment->status === 'pending')
                                            <button onclick="cancelAppointment({{ $appointment->id }})"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                Cancel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900"
                                          data-appointment-total="{{ number_format($appointment->total_price, 2) }}">₱{{ number_format($appointment->total_price, 2) }}</span>
                                    <div class="flex space-x-2">
                                        @if($appointment->status === 'completed' && !$appointment->feedback)
                                            <a href="{{ route('customer.feedback.create', $appointment) }}"
                                               class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                                Rate
                                            </a>
                                        @endif
                                        <button onclick="viewAppointmentDetails({{ $appointment->id }})"
                                                class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No appointments yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by booking your first appointment.</p>
                        <div class="mt-6">
                            <a href="{{ route('customer.appointments.create') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Book Appointment
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div id="appointmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Appointment Details</h3>
                </div>
                <div id="appointmentDetails" class="px-6 py-4">
                    <!-- Details will be loaded here -->
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                    <button onclick="closeAppointmentModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewAppointmentDetails(appointmentId) {
            // Find the appointment data from the current page
            const appointmentElement = document.querySelector(`[data-appointment-id="${appointmentId}"]`);
            if (!appointmentElement) {
                showNotification('Appointment details not found.', 'error');
                return;
            }

            // Extract data from the appointment element
            const serviceName = appointmentElement.querySelector('[data-service-name]')?.textContent || 'N/A';
            const specialistName = appointmentElement.querySelector('[data-specialist-name]')?.textContent || 'N/A';
            const appointmentDate = appointmentElement.querySelector('[data-appointment-date]')?.textContent || 'N/A';
            const appointmentTime = appointmentElement.querySelector('[data-appointment-time]')?.textContent || 'N/A';
            const appointmentStatus = appointmentElement.querySelector('[data-appointment-status]')?.textContent || 'N/A';
            const appointmentTotal = appointmentElement.querySelector('[data-appointment-total]')?.textContent || 'N/A';

            const appointmentAddress = appointmentElement.getAttribute('data-appointment-address') || 'N/A';
            const appointmentTip = appointmentElement.getAttribute('data-appointment-tip') || '0.00';
            const isHomeService = appointmentElement.getAttribute('data-appointment-home-service') || 'No';
            const cancellationReason = appointmentElement.getAttribute('data-appointment-reason') || '';
            const paymentMethod = appointmentElement.getAttribute('data-appointment-payment-method') || 'N/A';



            // Populate the modal with real data
            document.getElementById('appointmentDetails').innerHTML = `
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Service:</span>
                        <span class="text-gray-700">${serviceName}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Specialist:</span>
                        <span class="text-gray-700">${specialistName}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Date:</span>
                        <span class="text-gray-700">${appointmentDate}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Time:</span>
                        <span class="text-gray-700">${appointmentTime}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Home Service:</span>
                        <span class="text-gray-700">${isHomeService}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Address:</span>
                        <span class="text-gray-700 text-right">${appointmentAddress}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Tip:</span>
                        <span class="text-gray-700">₱${appointmentTip}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-900">Payment Method:</span>
                        <span class="text-gray-700">${getPaymentBadge(paymentMethod)}</span>
                    </div>

                    <div class="flex justify-between">
                    <span class="font-medium text-gray-900">Status:</span>
                    <span class="text-gray-700">${appointmentStatus}</span>
                </div>

                <div class="flex justify-between ${cancellationReason ? '' : 'hidden'} border-t border-gray-200 pt-2">
                    <span class="font-medium text-gray-900">Cancellation Reason:</span>
                    <span class="text-sm italic text-red-600 text-right">${cancellationReason || 'N/A'}</span>
                </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="font-medium text-gray-900">Total:</span>
                        <span class="text-gray-700">${appointmentTotal}</span>
                    </div>
                </div>
            `;
            document.getElementById('appointmentModal').classList.remove('hidden');
        }

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }

        function cancelAppointment(appointmentId) {
            // Create a custom confirmation modal instead of using alert/confirm
            showCancelConfirmation(appointmentId);
        }

            function showCancelConfirmation(appointmentId) {
            const existingModal = document.getElementById('cancelConfirmationModal');
            if (existingModal) existingModal.remove();

            const modal = document.createElement('div');
            modal.id = 'cancelConfirmationModal';
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Cancel Appointment</h3>
                    </div>
                    <div class="px-6 py-4 space-y-3">
                        <p class="text-sm text-gray-600">Please provide a reason for cancellation:</p>
                        <textarea id="cancelReason" rows="3" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none"
                            placeholder="Type your reason here (required)"></textarea>
                        <p id="cancelError" class="text-red-500 text-xs hidden">Please enter a reason before submitting.</p>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button onclick="closeCancelConfirmation()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Keep Appointment
                        </button>
                        <button onclick="confirmCancelAppointment(${appointmentId})"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                            Submit Cancellation
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }


        function closeCancelConfirmation() {
            const modal = document.getElementById('cancelConfirmationModal');
            if (modal) {
                modal.remove();
            }
        }

       async function confirmCancelAppointment(appointmentId) {
    const reason = document.getElementById('cancelReason').value.trim();
    const errorEl = document.getElementById('cancelError');
    const confirmBtn = event.target;

    if (!reason) {
        errorEl.classList.remove('hidden');
        return;
    }

    confirmBtn.disabled = true;
    confirmBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>Cancelling...`;

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(`/customer/appointments/${appointmentId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cancellation_reason: reason })
        });

        if (response.ok) {
            const result = await response.text();
            showNotification('Appointment cancelled successfully.', 'success');
            closeCancelConfirmation();

            // Instantly update UI without reloading page
            const appointmentCard = document.querySelector(`[data-appointment-id="${appointmentId}"]`);
            if (appointmentCard) {
                const statusEl = appointmentCard.querySelector('[data-appointment-status]');
                statusEl.textContent = 'Cancelled';
                statusEl.className =
                    'px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800';
                appointmentCard.setAttribute('data-appointment-reason', reason);
                appointmentCard.querySelector('button.text-red-600')?.remove(); // remove cancel button
            }
        } else {
            showNotification('Failed to cancel appointment.', 'error');
        }
    } catch (error) {
        console.error(error);
        showNotification('An error occurred while cancelling.', 'error');
    } finally {
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = 'Submit Cancellation';
    }
}



        // Notification system
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 z-50 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300 ease-in-out translate-x-full`;

            let iconColor = 'text-blue-400';
            let bgColor = 'bg-blue-50';
            let borderColor = 'border-blue-200';

            if (type === 'success') {
                iconColor = 'text-green-400';
                bgColor = 'bg-green-50';
                borderColor = 'border-green-200';
            } else if (type === 'error') {
                iconColor = 'text-red-400';
                bgColor = 'bg-red-50';
                borderColor = 'border-red-200';
            } else if (type === 'warning') {
                iconColor = 'text-yellow-400';
                bgColor = 'bg-yellow-50';
                borderColor = 'border-yellow-200';
            }

            notification.innerHTML = `
                <div class="p-4 ${bgColor} ${borderColor} border-l-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                                  type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                                  type === 'warning' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>' :
                                  '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'}
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">${message}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md p-1.5 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-gray-600">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }
            }, 5000);
        }

        // Show session messages as notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif

            @if(session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif
        });
 function getPaymentBadge(method) {
    const lower = method.toLowerCase();
    switch (lower) {
        case 'gcash':
            return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">💙 GCash</span>';
        case 'maya':
            return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">💚 Maya</span>';
        case 'cash':
            return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">💵 Cash</span>';
        case 'debit':
        case 'credit':
            return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">💳 Debit / Credit</span>';
        default:
            return `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">💰 ${method}</span>`;
            }
        }

    </script>
</x-customer-layout>
