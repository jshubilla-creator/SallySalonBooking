<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="mt-2 text-lg text-gray-600">Customer profile and information</p>
            </div>
            <a href="{{ route('manager.users.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                Back to Customers
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Customer Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Information</h3>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Gender</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($user->gender ?? 'Not specified') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terms Accepted</dt>
                            <dd class="mt-1">
                                @if($user->terms_accepted)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Yes ({{ $user->terms_accepted_at->format('M d, Y') }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        No
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    @if($user->address)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->address }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Appointments</h3>

                    @if($user->appointments->count() > 0)
                        <div class="flow-root">
                            <ul class="-my-5 divide-y divide-gray-200">
                                @foreach($user->appointments->take(5) as $appointment)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">{{ $appointment->service->name }}</p>
                                                <p class="text-sm text-gray-500">with {{ $appointment->specialist->name }}</p>
                                            </div>
                                            <div class="flex-shrink-0 text-right">
                                                <p class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                                <p class="text-sm text-gray-500">{{ $appointment->start_time }}</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                                    @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if($user->appointments->count() > 5)
                            <div class="mt-6">
                                <a href="{{ route('manager.appointments.index') }}?user={{ $user->id }}"
                                   class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    View all appointments
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-500 text-center py-4">No appointments found.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('manager.appointments.index') }}?user={{ $user->id }}"
                           class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                            View Appointments
                        </a>

                        <a href="mailto:{{ $user->email }}"
                           class="w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Send Email
                        </a>

                        @if($user->phone)
                            <a href="tel:{{ $user->phone }}"
                               class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                Call Customer
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Statistics -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Statistics</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Appointments</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->appointments->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Completed</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->appointments->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Upcoming</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->appointments->whereIn('status', ['pending', 'confirmed'])->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Spent</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($user->appointments->where('status', 'completed')->sum('total_price'), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
