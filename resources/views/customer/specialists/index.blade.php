<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Our Specialists</h1>
            <p class="mt-2 text-lg text-gray-600">Meet our talented team of beauty professionals</p>
        </div>

        <!-- Specialists Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
            @foreach($specialists as $specialist)
                <div class="bg-pink/90 backdrop-blur-md rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Profile Image -->
                    <div class="relative">
                        @if($specialist->profile_image)
                            <img src="{{ $specialist->profile_image }}" alt="{{ $specialist->name }}" class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-gradient-to-br from-green-100 to-purple-100 flex items-center justify-center">
                                <svg class="w-20 h-20 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            @if($specialist->is_available)
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Available
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    Unavailable
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Specialist Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $specialist->name }}</h3>
                        <p class="text-green-600 font-medium mb-2">{{ $specialist->specialization }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ $specialist->experience_years }} years experience</p>

                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $specialist->bio }}</p>

                        <!-- Services -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Specializes in:</h4>
                            <div class="flex flex-wrap gap-1">
                                @foreach($specialist->services->take(3) as $service)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                        {{ $service->name }}
                                    </span>
                                @endforeach
                                @if($specialist->services->count() > 3)
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                                        +{{ $specialist->services->count() - 3 }} more
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-1 mb-4">
                            @if($specialist->phone)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $specialist->phone }}
                                </div>
                            @endif
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $specialist->email }}
                            </div>
                        </div>

                        <!-- Specialist Details (Initially Hidden) -->
                        <div id="details-{{ $specialist->id }}" class="hidden mt-4 pt-4 border-t border-gray-200">
                            <div class="space-y-4">
                                <div>
                                    <h5 class="font-medium text-gray-900 mb-2">Working Hours</h5>
                                    <div class="grid grid-cols-2 gap-1 text-sm">
                                        @if($specialist->working_hours)
                                            @foreach(['monday' => 'Mon', 'tuesday' => 'Tue', 'wednesday' => 'Wed', 'thursday' => 'Thu', 'friday' => 'Fri', 'saturday' => 'Sat', 'sunday' => 'Sun'] as $day => $label)
                                                @php
                                                    $daySchedule = $specialist->working_hours[$day] ?? null;
                                                    $isEnabled = $daySchedule && ($daySchedule['enabled'] ?? false);
                                                @endphp
                                                <div class="flex justify-between">
                                                    <span class="font-medium">{{ $label }}:</span>
                                                    <span class="text-gray-600">
                                                        @if($isEnabled)
                                                            {{ $daySchedule['start'] ?? '09:00' }} - {{ $daySchedule['end'] ?? '17:00' }}
                                                        @else
                                                            Closed
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-gray-500 col-span-2">No schedule available</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <h5 class="font-medium text-gray-900 mb-2">All Services</h5>
                                    <div class="grid grid-cols-1 gap-2">
                                        @foreach($specialist->services as $service)
                                            <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                                <span class="text-sm">{{ $service->name }}</span>
                                                <span class="text-sm font-medium text-green-600">₱{{ number_format($service->price, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2 mt-4">
                            <button onclick="toggleDetails({{ $specialist->id }})"
                                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                                <span id="btn-text-{{ $specialist->id }}">View Details</span>
                            </button>
                        </div>
                        
                        <!-- Book Now Button (shown when details are visible) -->
                        <div id="book-btn-{{ $specialist->id }}" class="hidden mt-3">
                            @if($specialist->is_available)
                                <a href="{{ route('customer.appointments.create', ['specialist' => $specialist->id]) }}"
                                   class="block w-full bg-green-600 text-white px-4 py-3 rounded-md hover:bg-green-700 transition-colors duration-200 text-center font-medium">
                                    📅 Book Appointment Now
                                </a>
                            @else
                                <button disabled
                                        class="w-full bg-gray-300 text-gray-500 px-4 py-3 rounded-md cursor-not-allowed">
                                    Currently Unavailable
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($specialists->count() === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No specialists available</h3>
                <p class="mt-1 text-sm text-gray-500">Please check back later for our team members.</p>
            </div>
        @endif
    </div>

    <script>
        function toggleDetails(specialistId) {
            const detailsDiv = document.getElementById(`details-${specialistId}`);
            const bookBtn = document.getElementById(`book-btn-${specialistId}`);
            const btnText = document.getElementById(`btn-text-${specialistId}`);
            
            if (detailsDiv.classList.contains('hidden')) {
                detailsDiv.classList.remove('hidden');
                bookBtn.classList.remove('hidden');
                btnText.textContent = 'Hide Details';
            } else {
                detailsDiv.classList.add('hidden');
                bookBtn.classList.add('hidden');
                btnText.textContent = 'View Details';
            }
        }
    </script>
</x-customer-layout>