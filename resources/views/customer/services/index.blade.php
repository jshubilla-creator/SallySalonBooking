<x-customer-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Our Services</h1>
            <p class="mt-2 text-lg text-gray-600">Discover our range of Sally Salon beauty and wellness treatments</p>
        </div>

        <!-- Service Categories -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2">
                <button onclick="filterServices('all')"
                        class="px-4 py-2 rounded-full text-sm font-medium bg-green-600 text-white filter-btn"
                        data-category="all">
                    All Services
                </button>
                <button onclick="filterServices('Hair')"
                        class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 filter-btn"
                        data-category="Hair">
                    Hair
                </button>
                <button onclick="filterServices('Nail')"
                        class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 filter-btn"
                        data-category="Nail">
                    Nail Care
                </button>
                <button onclick="filterServices('Beauty')"
                        class="px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 filter-btn"
                        data-category="Beauty">
                    Beauty
                </button>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="bg-white rounded-lg shadow-md overflow-hidden service-card" data-category="{{ $service->category }}" data-service-id="{{ $service->id }}">
                    @if($service->image)
                        <img src="{{ $service->image }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-green-100 to-purple-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $service->name }}</h3>
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                {{ $service->category }}
                            </span>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $service->description }}</p>

                        <div class="flex justify-between items-center mb-4">
                            <div class="text-2xl font-bold text-green-600">${{ number_format($service->price, 2) }}</div>
                            <div class="text-sm text-gray-500">{{ $service->duration_minutes }} min</div>
                        </div>

                        <div class="flex space-x-2">
                            <button onclick="viewServiceDetails({{ $service->id }})"
                                    class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                                View Details
                            </button>
                            <a href="{{ route('customer.appointments.create', ['service' => $service->id]) }}"
                               class="flex-1 bg-white border border-green-600 text-green-600 px-4 py-2 rounded-md hover:bg-green-50 transition-colors duration-200 text-center">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($services->count() === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No services available</h3>
                <p class="mt-1 text-sm text-gray-500">Please check back later for our service offerings.</p>
            </div>
        @endif
    </div>

    <!-- Service Details Modal -->
    <div id="serviceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50" onclick="closeServiceModal()">
        <div class="flex items-center justify-center min-h-screen p-4" onclick="event.stopPropagation()">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Service Details</h3>
                </div>
                <div id="serviceDetails" class="px-6 py-4">
                    <!-- Details will be loaded here -->
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-2">
                    <button onclick="closeServiceModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Close
                    </button>
                    <button id="bookServiceBtn"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Book This Service
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterServices(category) {
            const serviceCards = document.querySelectorAll('.service-card');
            const filterButtons = document.querySelectorAll('.filter-btn');

            // Update button styles
            filterButtons.forEach(btn => {
                if (btn.dataset.category === category) {
                    btn.className = 'px-4 py-2 rounded-full text-sm font-medium bg-green-600 text-white filter-btn';
                } else {
                    btn.className = 'px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 filter-btn';
                }
            });

            // Show/hide service cards
            serviceCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function viewServiceDetails(serviceId) {
            // Find the service data from the current page
            const serviceCard = document.querySelector(`[data-service-id="${serviceId}"]`);
            if (!serviceCard) {
                // If not found, try to find by the service card that contains the button
                const button = document.querySelector(`button[onclick="viewServiceDetails(${serviceId})"]`);
                serviceCard = button.closest('.service-card');
            }

            if (serviceCard) {
                // Extract service data from the card
                const serviceName = serviceCard.querySelector('h3').textContent;
                const serviceCategory = serviceCard.querySelector('span').textContent;
                const serviceDescription = serviceCard.querySelector('p').textContent;
                const servicePrice = serviceCard.querySelector('.text-2xl').textContent;
                const serviceDuration = serviceCard.querySelector('.text-sm').textContent;

                document.getElementById('serviceDetails').innerHTML = `
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <h4 class="text-xl font-semibold text-gray-900">${serviceName}</h4>
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">${serviceCategory}</span>
                        </div>
                        <p class="text-gray-600">${serviceDescription}</p>
                        <div class="flex justify-between items-center">
                            <div class="text-2xl font-bold text-green-600">${servicePrice}</div>
                            <div class="text-sm text-gray-500">${serviceDuration}</div>
                        </div>
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h5 class="font-medium text-gray-900 mb-2">What to Expect:</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Professional service by our certified specialists</li>
                                <li>• High-quality products and equipment</li>
                                <li>• Clean and sanitized environment</li>
                                <li>• Satisfaction guarantee</li>
                            </ul>
                        </div>
                    </div>
                `;

                document.getElementById('bookServiceBtn').onclick = function() {
                    window.location.href = `/customer/appointments/create?service=${serviceId}`;
                };

                document.getElementById('serviceModal').classList.remove('hidden');
            } else {
                // Fallback: show error message
                document.getElementById('serviceDetails').innerHTML = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Service not found</h3>
                        <p class="mt-1 text-sm text-gray-500">Unable to load service details.</p>
                    </div>
                `;
                document.getElementById('serviceModal').classList.remove('hidden');
            }
        }

        function closeServiceModal() {
            document.getElementById('serviceModal').classList.add('hidden');
        }

        // Notification system (same as in appointment booking)
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
    </script>
</x-customer-layout>
