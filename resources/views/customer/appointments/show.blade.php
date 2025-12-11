<x-customer-layout>
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Appointment Details</h1>
                <p class="mt-2 text-lg text-gray-600">View your appointment information</p>
            </div>
            <a href="{{ route('customer.appointments.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                Back to Appointments
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $appointment->service->name }}</h2>
                    @if($appointment->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Pending Approval
                        </span>
                    @elseif($appointment->status === 'confirmed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Confirmed
                        </span>
                    @elseif($appointment->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            Completed
                        </span>
                    @elseif($appointment->status === 'cancelled')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Cancelled
                        </span>
                    @endif
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Service Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Service Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Service</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->service->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Specialist</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->specialist->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->service->duration_minutes }} minutes</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Price</dt>
                                <dd class="text-sm text-gray-900">₱{{ number_format($appointment->service->price, 2) }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Appointment Details -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Details</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Time</dt>
                                <dd class="text-sm text-gray-900">{{ $appointment->start_time->format('g:i A') }} - {{ $appointment->end_time->format('g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Service Type</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($appointment->is_home_service)
                                        Home Service
                                    @else
                                        In-Salon
                                    @endif
                                </dd>
                            </div>
                            @if($appointment->is_home_service && $appointment->home_address)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="text-sm text-gray-900">{{ $appointment->home_address }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                @if($appointment->notes)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md">{{ $appointment->notes }}</p>
                    </div>
                @endif

                <!-- Payment Information -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Service Price:</span>
                            <span class="text-sm text-gray-900">₱{{ number_format($appointment->service->price, 2) }}</span>
                        </div>
                        @if($appointment->tip_amount > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Tip:</span>
                                <span class="text-sm text-gray-900">₱{{ number_format($appointment->tip_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center font-medium border-t pt-2">
                            <span class="text-sm text-gray-900">Total:</span>
                            <span class="text-sm text-gray-900">₱{{ number_format($appointment->total_price + $appointment->tip_amount, 2) }}</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-sm text-gray-600">Payment Method: </span>
                            <span class="text-sm text-gray-900">{{ $appointment->payment_method }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if($appointment->status === 'pending' || $appointment->status === 'confirmed')
                    <div class="mt-6 flex space-x-3">
                        @if($appointment->status === 'confirmed' && (!isset($appointment->payment_status) || $appointment->payment_status !== 'paid'))
                            <a href="{{ route('customer.payments.show', $appointment) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Pay Now
                            </a>
                        @endif
                        
                        <button type="button" 
                                onclick="openCancelModal()"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Cancel Appointment
                        </button>
                    </div>
                @endif

                @if($appointment->status === 'cancelled' && $appointment->cancellation_reason)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Cancellation Reason</h3>
                        <p class="text-sm text-gray-700 bg-red-50 p-3 rounded-md">{{ $appointment->cancellation_reason }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cancel Appointment</h3>
                <form action="{{ route('customer.appointments.cancel', $appointment) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for cancellation *
                        </label>
                        <textarea name="cancellation_reason" 
                                  id="cancellation_reason" 
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeCancelModal()"
                                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Confirm Cancellation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
        }
        
        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
        }
    </script>
</x-customer-layout>