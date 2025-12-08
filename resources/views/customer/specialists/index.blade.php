<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Our Specialists</h1>
            <p class="mt-2 text-lg text-gray-600">Meet our talented team of beauty professionals</p>
        </div>

        <!-- Specialists Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($specialists as $specialist)
                <div class="bg-blue-100 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
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

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <button onclick="viewSpecialistDetails({{ $specialist->id }})"
                                    class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                                View Profile
                            </button>
                            @if($specialist->is_available)
                                <a href="{{ route('customer.appointments.create', ['specialist' => $specialist->id]) }}"
                                   class="flex-1 bg-white border border-green-600 text-green-600 px-4 py-2 rounded-md hover:bg-green-50 transition-colors duration-200 text-center">
                                    Book Now
                                </a>
                            @else
                                <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-md cursor-not-allowed">
                                    Unavailable
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

    <!-- Specialist Details Modal -->
    <div id="specialistModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" onclick="closeSpecialistModal()">
        <div class="flex items-center justify-center min-h-screen p-4" onclick="event.stopPropagation()">
            <div class="bg-blue-50 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Specialist Profile</h3>
                </div>
                <div id="specialistDetails" class="px-6 py-4">
                    <!-- Details will be loaded here -->
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-2">
                    <button onclick="closeSpecialistModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Close
                    </button>
                    <button id="bookSpecialistBtn"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Book Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dayNames = {
        0: "Sunday",
        1: "Monday",
        2: "Tuesday",
        3: "Wednesday",
        4: "Thursday",
        5: "Friday",
        6: "Saturday"
    };
        
        function viewSpecialistDetails(specialistId) {
            // Show loading state
            document.getElementById('specialistDetails').innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                    <span class="ml-2 text-gray-600">Loading specialist details...</span>
                </div>
            `;

            // Show modal
            document.getElementById('specialistModal').classList.remove('hidden');

            // Fetch specialist details via AJAX
            fetch(`/customer/specialists/${specialistId}`)
                .then(response => response.json())
                .then(data => {
                    // Update modal content with real data
                    document.getElementById('specialistDetails').innerHTML = `
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-24 h-24 bg-gradient-to-br from-green-100 to-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-2xl font-semibold text-gray-900">${data.name}</h4>
                                    <p class="text-green-600 font-medium">${data.specialization}</p>
                                    <p class="text-sm text-gray-500">${data.experience_years} years experience</p>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-sm text-gray-500">📧 ${data.email}</span>
                                        <span class="text-sm text-gray-500">📞 ${data.phone}</span>
                                        ${data.is_busy_now ? '<span class="ml-3 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Busy now</span>' : ''}
                                    </div>

                                    ${data.busy_reason ? `
                                        <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-md text-sm">
                                            <div class="font-medium text-red-800">Currently with: ${data.busy_reason.service || 'Appointment'}</div>
                                            <div class="text-gray-600">Customer: ${data.busy_reason.customer || 'Private'}</div>
                                            <div class="text-gray-600">Time: ${data.busy_reason.start_time || ''}${data.busy_reason.end_time ? ' - ' + data.busy_reason.end_time : ''}</div>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>

                            <div>
                                <h5 class="text-lg font-medium text-gray-900 mb-2">About</h5>
                                <p class="text-gray-600">${data.bio || 'No bio available.'}</p>
                            </div>

                            <div>
                                <h5 class="text-lg font-medium text-gray-900 mb-2">Services</h5>
                                <div class="flex flex-wrap gap-2">
                                    ${data.services.map(service => `
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                            ${service.name} - ₱${service.price}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>

                            <div>
    <h5 class="text-lg font-medium text-gray-900 mb-2">Working Hours</h5>
    <div class="grid grid-cols-2 gap-2 text-sm">
        ${(() => {
            const daysOrder = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
            const dayLabels = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            const wh = data.working_hours || {};
            return daysOrder.map((day, idx) => {
                const dayData = wh[day] || {};
                const isEnabled = !!dayData.enabled;
                let hoursText = 'Closed';
                if (isEnabled) {
                    if (dayData.start && dayData.end) {
                        hoursText = `${dayData.start} - ${dayData.end}`;
                    } else {
                        hoursText = 'Available';
                    }
                }
                return `
                    <div class="flex justify-start space-x-2">
                        <span class="font-medium">${dayLabels[idx]}:</span>
                        <span class="text-gray-600">${hoursText}</span>
                    </div>
                `;
            }).join('');
        })()}
    </div>

    ${data.next_appointment ? `
        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-lg text-sm">
            <strong>Upcoming:</strong> ${data.next_appointment.service || 'Appointment'} on ${data.next_appointment.date} ${data.next_appointment.start_time ? 'at ' + data.next_appointment.start_time : ''} (${data.next_appointment.status})
        </div>
    ` : ''}
</div>

                            ${data.feedback && data.feedback.length > 0 ? `
                                <div>
                                    <h5 class="text-lg font-medium text-gray-900 mb-3">Customer Reviews</h5>
                                    <div class="space-y-3">
                                        ${data.feedback.map(review => `
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <div class="flex text-yellow-400">
                                                        ${Array.from({length: 5}, (_, i) => 
                                                            i < review.rating 
                                                                ? '<svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>'
                                                                : '<svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>'
                                                        ).join('')}
                                                    </div>
                                                    <span class="text-sm font-medium">${review.user_name}</span>
                                                    <span class="text-sm text-gray-500">${review.created_at}</span>
                                                </div>
                                                <p class="text-sm text-gray-700">${review.comment}</p>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}

                        </div>
                    `;

                    // Set up book button
                    document.getElementById('bookSpecialistBtn').onclick = function() {
                        window.location.href = `/customer/appointments/create?specialist=${specialistId}`;
                    };
                })
                .catch(error => {
                    console.error('Error fetching specialist details:', error);
                    document.getElementById('specialistDetails').innerHTML = `
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Error loading specialist details</h3>
                            <p class="mt-1 text-sm text-gray-500">Please try again later.</p>
                        </div>
                    `;
                });
        }

        function closeSpecialistModal() {
            document.getElementById('specialistModal').classList.add('hidden');
        }
    </script>
</x-customer-layout>
