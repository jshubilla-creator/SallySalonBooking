<x-customer-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Appointment Details</h1>
        <p class="mt-2 text-lg text-gray-600">View your appointment information</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Information</h3>
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
                            <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                            <dd class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm">
                                @if($appointment->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending Approval
                                    </span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Confirmed
                                    </span>
                                @elseif($appointment->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Completed
                                    </span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Service Price</dt>
                            <dd class="text-sm text-gray-900">₱{{ number_format($appointment->total_price, 2) }}</dd>
                        </div>
                        @if($appointment->tip_amount > 0)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tip</dt>
                            <dd class="text-sm text-gray-900">₱{{ number_format($appointment->tip_amount, 2) }}</dd>
                        </div>
                        @endif
                        <div class="border-t pt-3">
                            <dt class="text-sm font-medium text-gray-500">Total</dt>
                            <dd class="text-lg font-semibold text-gray-900">₱{{ number_format($appointment->grand_total ?? $appointment->total_price + $appointment->tip_amount, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($appointment->notes)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Notes</h3>
                <p class="text-sm text-gray-600">{{ $appointment->notes }}</p>
            </div>
            @endif

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('customer.appointments.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Back to Appointments
                </a>
                
                @if($appointment->status === 'pending' || $appointment->status === 'confirmed')
                <form method="POST" action="{{ route('customer.appointments.cancel', $appointment) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to cancel this appointment?')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Cancel Appointment
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</x-customer-layout>