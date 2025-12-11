<x-customer-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Appointments</h1>
        <p class="mt-2 text-lg text-gray-600">View and manage your salon appointments</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            @if($appointments->count() > 0)
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $appointment->service->name }}</h3>
                                    <p class="text-sm text-gray-600">with {{ $appointment->specialist->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                    <p class="text-sm font-medium text-gray-900">₱{{ number_format($appointment->total_price, 2) }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($appointment->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending Approval
                                        </span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Confirmed
                                        </span>
                                        @if(!isset($appointment->payment_status) || $appointment->payment_status !== 'paid')
                                            <a href="{{ route('customer.payments.show', $appointment) }}" 
                                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                Pay Now
                                            </a>
                                        @endif
                                    @elseif($appointment->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Completed
                                        </span>
                                    @elseif($appointment->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @endif
                                    
                                    <a href="{{ route('customer.appointments.show', $appointment) }}" 
                                       class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">No appointments found.</p>
                    <a href="{{ route('customer.appointments.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Book Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-customer-layout>