<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $specialist->name }}</h1>
                <p class="mt-2 text-lg text-gray-600">Specialist profile and information</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('manager.specialists.edit', $specialist) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                    Edit Specialist
                </a>
                <a href="{{ route('manager.specialists.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                    Back to Specialists
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Specialist Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if($specialist->profile_image)
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ $specialist->profile_image }}" alt="{{ $specialist->name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-xl font-medium text-green-600">{{ substr($specialist->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $specialist->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $specialist->specialization }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($specialist->is_available)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Unavailable
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $specialist->experience_years }} years experience
                            </div>

                            @if($specialist->bio)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">{{ $specialist->bio }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="mt-6 bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Services</h3>

                    @if($specialist->services->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($specialist->services as $service)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $service->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $service->category }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">${{ number_format($service->price, 2) }}</p>
                                            <p class="text-xs text-gray-500">{{ $service->duration_minutes }} min</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No services assigned.</p>
                    @endif
                </div>
            </div>

            <!-- Working Hours -->
            <div class="mt-6 bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Working Hours</h3>

                    <div class="space-y-2">
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-medium text-gray-700 capitalize">{{ $day }}</span>
                                @if(isset($specialist->working_hours[$day]['enabled']) && $specialist->working_hours[$day]['enabled'])
                                    <span class="text-sm text-gray-900">
                                        {{ $specialist->working_hours[$day]['start'] ?? '09:00' }} - {{ $specialist->working_hours[$day]['end'] ?? '17:00' }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Closed</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Appointments -->
            @if($specialist->appointments->count() > 0)
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Appointments</h3>

                        <div class="flow-root">
                            <ul class="-my-5 divide-y divide-gray-200">
                                @foreach($specialist->appointments->take(5) as $appointment)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-600">{{ substr($appointment->user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">{{ $appointment->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $appointment->service->name }}</p>
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

                        @if($specialist->appointments->count() > 5)
                            <div class="mt-6">
                                <a href="{{ route('manager.appointments.index') }}?specialist={{ $specialist->id }}"
                                   class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    View all appointments
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('manager.specialists.edit', $specialist) }}"
                           class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                            Edit Specialist
                        </a>

                        <a href="{{ route('manager.appointments.index') }}?specialist={{ $specialist->id }}"
                           class="w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            View Appointments
                        </a>

                        <form method="POST" action="{{ route('manager.specialists.destroy', $specialist) }}" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this specialist? This action cannot be undone.')"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors duration-200">
                                Delete Specialist
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Specialist Statistics -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Statistics</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Appointments</span>
                            <span class="text-sm font-medium text-gray-900">{{ $specialist->appointments->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Completed</span>
                            <span class="text-sm font-medium text-gray-900">{{ $specialist->appointments->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Upcoming</span>
                            <span class="text-sm font-medium text-gray-900">{{ $specialist->appointments->whereIn('status', ['pending', 'confirmed'])->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Services Offered</span>
                            <span class="text-sm font-medium text-gray-900">{{ $specialist->services->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
