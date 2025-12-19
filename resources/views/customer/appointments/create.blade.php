    <x-customer-layout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Book an Appointment</h1>
                <p class="mt-2 text-lg text-gray-600">Schedule your beauty treatment with our expert specialists</p>
            </div>



            <form action="{{ route('customer.appointments.store') }}" method="POST" id="appointmentForm">
                @csrf

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-red-200 rounded-md p-4 mb-6 session-message" data-type="error">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    There were errors with your submission:
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-pink/100 backdrop-blur-md rounded-lg shadow-md p-6 space-y-8">
                    @if($selectedService)
                    <!-- Pre-selected Service Display -->
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Selected Service</h2>
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $selectedService->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $selectedService->description }}</p>
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-lg font-semibold text-green-600">₱{{ number_format($selectedService->price, 2) }}</span>
                                    <span class="text-sm text-gray-500">{{ $selectedService->duration_minutes }} min</span>
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ $selectedService->category }}</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="service_id" value="{{ $selectedService->id }}">
                    </div>
                    @else
                    <!-- Service Selection -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">1. Choose a Service</h2>
                        <p class="text-sm text-gray-600 mb-4">Select a service to continue <span class="text-red-500">*</span></p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($services as $service)
                                <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-green-400 hover:shadow-lg hover:scale-105 cursor-pointer service-option transition-all duration-200 bg-white hover:bg-green-50"
                                    data-service-id="{{ $service->id }}"
                                    data-service-price="{{ $service->price }}"
                                    data-service-duration="{{ $service->duration_minutes }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-medium text-gray-900">{{ $service->name }}</h3>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                            {{ $service->category }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ $service->description }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-green-600">₱{{ number_format($service->price, 2) }}</span>
                                        <span class="text-sm text-gray-500">{{ $service->duration_minutes }} min</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="service_id" id="selectedServiceId">
                    </div>
                    @endif

                    <!-- Service Variation Selection -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">2. Choose Style (Optional)</h2>
                        <p class="text-sm text-gray-600 mb-4">Select the specific style you want</p>
                        <select name="service_variation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Standard Service</option>
                            <option value="Classic Cut">Classic Cut</option>
                            <option value="Fade Cut">Fade Cut</option>
                            <option value="Mohawk">Mohawk</option>
                            <option value="Buzz Cut">Buzz Cut</option>
                            <option value="Layered Cut">Layered Cut</option>
                            <option value="Full Color">Full Color</option>
                            <option value="Highlights">Highlights</option>
                            <option value="Balayage">Balayage</option>
                        </select>
                    </div>

                    @if($selectedSpecialist)
                    <!-- Pre-selected Specialist Display -->
                    <div class="p-4 bg-pink/90 backdrop-blur-md border border-blue-200 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Selected Specialist</h2>
                        <div class="flex items-center space-x-4">
                            @if($selectedSpecialist->profile_picture_url)
                                <img class="w-12 h-12 rounded-full object-cover" src="{{ $selectedSpecialist->profile_picture_url }}" alt="{{ $selectedSpecialist->name }}">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">{{ substr($selectedSpecialist->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $selectedSpecialist->name }}</h3>
                                <p class="text-sm text-blue-600">{{ $selectedSpecialist->specialization }}</p>
                                <p class="text-sm text-gray-500">{{ $selectedSpecialist->experience_years }} years experience</p>
                            </div>
                        </div>
                        <input type="hidden" name="specialist_id" value="{{ $selectedSpecialist->id }}">
                    </div>
                    @else
                    <!-- Specialist Selection -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">2. Choose a Specialist</h2>
                        <p class="text-sm text-gray-600 mb-4">Select a specialist to continue <span class="text-red-500">*</span></p>
                        <div id="specialistsList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Specialists will be loaded here -->
                        </div>
                        <input type="hidden" name="specialist_id" id="selectedSpecialistId">
                    </div>
                    @endif

                    <!-- Date & Time Selection -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">3. Select Date & Time</h2>
                        <p class="text-sm text-gray-600 mb-4">Choose your preferred date and time <span class="text-red-500">*</span></p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                                <input type="date"
                                    name="appointment_date"
                                    id="appointment_date"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                <div id="daily-booking-info" class="mt-2 text-sm text-gray-600 hidden">
                                    <span id="booking-count-text"></span>
                                </div>
                            </div>
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                                <select name="start_time"
                                        id="start_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                        required>
                                    <option value="">Select a time</option>
                                    <!-- Time slots will be loaded here -->
                                </select>
                            </div>
                        </div>

                        <!-- End Time Display -->
                        <div class="mt-4 p-3 bg-gray-50 rounded-md">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-700">Appointment Duration:</span>
                                <span id="end_time_display" class="text-sm text-gray-600">Select a time to see duration</span>
                            </div>
                        </div>
                        <input type="hidden" name="end_time" id="end_time">
                    </div>

            <!-- Additional Details -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">4. Additional Details</h2>

                <div class="space-y-6">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                name="is_home_service"
                                id="is_home_service"
                                class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Home service</span>
                        </label>
                    </div>

                <!-- Address + Map (Side by Side Layout) -->
            <div id="homeAddressContainer" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                <!-- Left Column -->
                <div class="space-y-3">
                    <label for="home_address" class="block text-sm font-medium text-gray-700 mb-2">Search Address</label>
                    <input type="text"
                        id="searchBox"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
                        placeholder="Search your location (e.g., SM North EDSA)">
                    <textarea name="home_address" id="home_address" rows="5"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
                        placeholder="Address will appear here automatically..."></textarea>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                </div>

                <!-- Right Column -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select or Pin Location</label>
                    <div id="map" class="w-full h-64 md:h-72 rounded-md border border-gray-300"></div>
                </div>
            </div>

                    <!-- Tip Section -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Add a Tip (Optional)</label>
                    <div class="flex flex-wrap gap-2">
                            <button type="button" class="tip-btn px-4 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-green-100" data-amount="5">₱5</button>
                            <button type="button" class="tip-btn px-4 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-green-100" data-amount="10">₱10</button>
                            <button type="button" class="tip-btn px-4 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-green-100" data-amount="20">₱20</button>
                            <button type="button" class="tip-btn px-4 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-green-100" data-amount="100">₱100</button>
                            <button type="button" class="tip-btn px-4 py-2 border border-gray-300 bg-gray-100 text-gray-700 rounded-lg hover:bg-green-100" data-amount="300">₱300</button>
                        </div>

                        <input type="number" id="custom_tip" name="custom_tip"
                            class="mt-3 w-48 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
                            placeholder="Custom tip (₱)">
                        <input type="hidden" id="selected_tip" name="selected_tip" value="0">
                    </div>
                </div>
            </div>

                    <!-- Payment Method -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">5. Payment Method</h2>
                        <div class="bg-pink/90 backdrop-blur-md rounded-lg p-4 border border-blue-200 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 text-center">Payment Method</h3>
                            <p class="text-sm text-gray-600 text-center mb-4">How would you like to pay? <span class="text-red-500">*</span></p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <!-- GCash -->
                                <button type="button"
                                    class="payment-option flex flex-col items-center justify-center p-4 bg-white border-2 border-transparent rounded-xl shadow-sm hover:border-green-400 transition-all duration-200"
                                    data-method="GCash">
                                    <img src="https://beanstalk-9fcd.kxcdn.com/wp-content/uploads/2022/05/gcash.jpg"
                                        alt="GCash"
                                        class="h-12 w-12 object-contain mb-2">
                                    <span class="font-semibold text-gray-800">GCash</span>
                                </button>

                                <!-- Maya -->
                                <button type="button"
                                    class="payment-option flex flex-col items-center justify-center p-4 bg-white border-2 border-transparent rounded-xl shadow-sm hover:border-green-400 transition-all duration-200"
                                    data-method="Maya">
                                    <img src="https://cdn.manilastandard.net/wp-content/uploads/2022/05/maya.jpg"
                                        alt="Maya"
                                        class="h-10 w-auto object-contain mb-2 rounded">
                                    <span class="font-semibold text-gray-800">Maya</span>
                                </button>

                                <!-- Debit or Credit -->
                                <button type="button" class="payment-option flex flex-col items-center justify-center p-4 bg-white border-2 border-transparent rounded-xl shadow-sm hover:border-green-400 transition-all duration-200" data-method="Debit or Credit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-9 4h16a2 2 0 002-2V8a2 2 0 00-2-2H4a2 2 0 00-2 2v9a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-semibold text-gray-800 text-center">Debit or Credit</span>
                                </button>

                                <!-- Cash -->
                                <button type="button" class="payment-option flex flex-col items-center justify-center p-4 bg-white border-2 border-transparent rounded-xl shadow-sm hover:border-green-400 transition-all duration-200" data-method="Cash">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0H5m12 0v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6m14 0H5" />
                                    </svg>
                                    <span class="font-semibold text-gray-800">Cash</span>
                                </button>
                            </div>

                            <input type="hidden" name="payment_method" id="payment_method" required>
                            <p id="paymentError" class="text-red-500 text-sm mt-3 hidden text-center">Please select a payment method before confirming.</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-8">
                        <button type="submit"
                                class="px-8 py-3 text-lg font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Book Appointment
                        </button>
                    </div>
                </div>
            </form>

            <!-- Fully Booked Modal -->
            <div id="fullyBookedModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Specialist Fully Booked</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                <span id="modalSpecialistName"></span> is fully booked for the selected date. Please choose another specialist or select a different date.
                            </p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button onclick="closeFullyBookedModal()" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let selectedService = @if($selectedService) {
                id: {{ $selectedService->id }},
                price: {{ $selectedService->price }},
                duration_minutes: {{ $selectedService->duration_minutes ?? 60 }},
                name: "{{ $selectedService->name }}"
            } @else null @endif;
            let selectedSpecialist = @if($selectedSpecialist) {
                id: {{ $selectedSpecialist->id }},
                name: "{{ $selectedSpecialist->name }}",
                specialization: "{{ $selectedSpecialist->specialization }}"
            } @else null @endif;

            // Initialize the form
            document.addEventListener('DOMContentLoaded', function() {
                if (selectedService && !selectedSpecialist) {
                    loadSpecialists(selectedService.id);
                }
                
                // Load time slots if both service and specialist are pre-selected
                if (selectedService && selectedSpecialist) {
                    const dateInput = document.getElementById('appointment_date');
                    if (dateInput.value) {
                        loadTimeSlots();
                    }
                }
            });

            // Service selection
            document.querySelectorAll('.service-option').forEach(option => {
                option.addEventListener('click', function() {
                    // Remove previous selection
                    document.querySelectorAll('.service-option').forEach(opt => {
                        opt.classList.remove('border-green-500', 'bg-green-100', 'ring-4', 'ring-green-300', 'shadow-xl');
                        opt.classList.add('border-gray-200');
                        opt.classList.remove('bg-green-50');
                    });

                    // Select current option
                    this.classList.remove('border-gray-200');
                    this.classList.add('border-green-500', 'bg-green-100', 'ring-4', 'ring-green-300', 'shadow-xl');

                    selectedService = {
                        id: this.dataset.serviceId,
                        price: this.dataset.servicePrice,
                        duration_minutes: this.dataset.serviceDuration || 60,
                        name: this.querySelector('h3').textContent
                    };

                    document.getElementById('selectedServiceId').value = selectedService.id;

                    // Only clear specialist if not pre-selected from URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const preSelectedSpecialistId = urlParams.get('specialist_id');
                    
                    if (!preSelectedSpecialistId) {
                        selectedSpecialist = null;
                        document.getElementById('selectedSpecialistId').value = '';
                    }

                    // Load specialists for this service
                    loadSpecialists(selectedService.id);

                    // Reload time slots if date is already selected
                    if (document.getElementById('appointment_date').value) {
                        loadTimeSlots();
                    }

                    // Update button state
                    updateNextButtonState();
                });
            });

            // Home service toggle
            document.getElementById('is_home_service').addEventListener('change', function() {
                const homeAddressField = document.getElementById('homeAddressField');
                if (this.checked) {
                    homeAddressField.classList.remove('hidden');
                } else {
                    homeAddressField.classList.add('hidden');
                }
            });

            function loadSpecialists(serviceId) {
                const specialistsList = document.getElementById('specialistsList');
                if (!specialistsList) return;

                specialistsList.innerHTML = `<div class="col-span-2 text-center py-4">Loading...</div>`;

                fetch(`/customer/appointments/specialists?service_id=${serviceId}`)
                    .then(response => response.json())
                    .then(specialists => {
                        if (specialists.length === 0) {
                            specialistsList.innerHTML = `
                                <div class="col-span-2 text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No specialists available</h3>
                                    <p class="mt-1 text-sm text-gray-500">No specialists are available for this service.</p>
                                </div>
                            `;
                            return;
                        }

                        specialistsList.innerHTML = specialists.map(specialist => `
                            <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-green-400 hover:bg-green-50 cursor-pointer specialist-option transition-all duration-200 bg-white" data-specialist-id="${specialist.id}">
                                <div class="flex items-start space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-purple-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-green-600">${specialist.name.charAt(0)}</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">${specialist.name}</h3>
                                        <p class="text-sm text-green-600 font-medium">${specialist.specialization}</p>
                                        <p class="text-sm text-gray-500">${specialist.experience_years} years experience</p>
                                    </div>
                                </div>
                            </div>
                        `).join('');

                        document.querySelectorAll('.specialist-option').forEach(option => {
                            option.addEventListener('click', function() {
                                document.querySelectorAll('.specialist-option').forEach(opt => {
                                    opt.classList.remove('border-green-500', 'bg-green-100');
                                    opt.classList.add('border-gray-200');
                                });

                                this.classList.remove('border-gray-200');
                                this.classList.add('border-green-500', 'bg-green-100');

                                selectedSpecialist = {
                                    id: this.dataset.specialistId,
                                    name: this.querySelector('h3').textContent
                                };

                                document.getElementById('selectedSpecialistId').value = selectedSpecialist.id;
                            });
                        });
                    })
                    .catch(error => {
                        specialistsList.innerHTML = '<div class="col-span-2 text-center py-4 text-red-500">Error loading specialists</div>';
                    });
            }



    function loadTimeSlots() {
        const timeSelect = document.getElementById('start_time');
        const selectedDate = document.getElementById('appointment_date').value;

        if (!selectedDate) {
            timeSelect.innerHTML = '<option value="">Please select a date first</option>';
            return;
        }

        // Get service and specialist IDs from hidden inputs if not in variables
        const serviceId = selectedService ? selectedService.id : document.querySelector('input[name="service_id"]').value;
        const specialistId = selectedSpecialist ? selectedSpecialist.id : document.querySelector('input[name="specialist_id"]').value;

        if (!serviceId || !specialistId) {
            timeSelect.innerHTML = '<option value="">Please select service and specialist first</option>';
            return;
        }

        timeSelect.innerHTML = '<option value="">Loading available time slots...</option>';

        fetch(`/customer/appointments/booked-slots?service_id=${serviceId}&specialist_id=${specialistId}&date=${selectedDate}`)
            .then(response => response.json())
            .then(bookedSlots => {
                const allTimeSlots = [];
                const selectedDateObj = new Date(selectedDate);
                const today = new Date();
                const isToday = selectedDateObj.toDateString() === today.toDateString();
                const currentHour = today.getHours();
                const currentMinute = today.getMinutes();

                // Check if it's night time (6 PM - 8 AM) - no bookings allowed
                const now = new Date();
                const currentHour24 = now.getHours();
                if (currentHour24 >= 18 || currentHour24 < 8) {
                    timeSelect.innerHTML = '<option value="">Salon is closed at night (6 PM - 8 AM)</option>';
                    return;
                }

                // Get working hours from server (you'll need to pass this from controller)
                const startHour = 9; // Default, should come from settings
                const endHour = 18;   // Default, should come from settings
                
                // Generate 30-min slots between working hours
                for (let hour = startHour; hour < endHour; hour++) {
                    for (let minute = 0; minute < 60; minute += 30) {
                        if (isToday && (hour < currentHour || (hour === currentHour && minute <= currentMinute))) {
                            continue;
                        }

                        const timeString = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                        const displayTime = formatTime12Hour(hour, minute);
                        allTimeSlots.push({ value: timeString, display: displayTime });
                    }
                }

                timeSelect.innerHTML = '<option value="">Select a time</option>';

                if (allTimeSlots.length === 0) {
                    timeSelect.innerHTML = '<option value="">No available time slots</option>';
                    return;
                }

                // Build dropdown with booked slots disabled
                allTimeSlots.forEach(slot => {
                    const isBooked = bookedSlots.some(b => {
                        const [sh, sm] = b.start_time.split(':').map(Number);
                        const [eh, em] = b.end_time.split(':').map(Number);
                        const slotMins = parseInt(slot.value.split(':')[0]) * 60 + parseInt(slot.value.split(':')[1]);
                        const startMins = sh * 60 + sm;
                        const endMins = eh * 60 + em;
                        return slotMins >= startMins && slotMins < endMins;
                    });

                    const option = document.createElement('option');
                    option.value = slot.value;
                    option.textContent = slot.display;
                    option.disabled = isBooked;

                    if (isBooked) {
                        option.textContent += ' (Booked)';
                        option.classList.add('text-gray-400');
                    }

                    timeSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading time slots:', error);
                timeSelect.innerHTML = '<option value="">Error loading time slots</option>';
            });
    }

            // Function to check if a time slot is booked
            function isTimeSlotBooked(timeSlot, bookedSlots) {
                const [slotHour, slotMinute] = timeSlot.split(':').map(Number);
                const slotMinutes = slotHour * 60 + slotMinute;

                return bookedSlots.some(booked => {
                    const [startHour, startMinute] = booked.start_time.split(':').map(Number);
                    const [endHour, endMinute] = booked.end_time.split(':').map(Number);
                    const startMinutes = startHour * 60 + startMinute;
                    const endMinutes = endHour * 60 + endMinute;

                    // Check if the time slot overlaps with any booked slot
                    return slotMinutes >= startMinutes && slotMinutes < endMinutes;
                });
            }

            // Function to format time in 12-hour format
            function formatTime12Hour(hour, minute) {
                const period = hour >= 12 ? 'PM' : 'AM';
                const displayHour = hour === 0 ? 12 : (hour > 12 ? hour - 12 : hour);
                const displayMinute = minute.toString().padStart(2, '0');
                return `${displayHour}:${displayMinute} ${period}`;
            }

            // Load time slots when date changes
            document.getElementById('appointment_date').addEventListener('change', function() {
                loadTimeSlots();
            });

            // Calculate end time when start time changes
            document.getElementById('start_time').addEventListener('change', function() {
                if (this.value) {
                    const startTime = this.value;
                    const duration = selectedService ? parseInt(selectedService.duration_minutes) || 60 : 60;

                    const [hours, minutes] = startTime.split(':').map(Number);
                    const startMinutes = hours * 60 + minutes;
                    const endMinutes = startMinutes + duration;

                    const endHours = Math.floor(endMinutes / 60);
                    const endMins = endMinutes % 60;
                    const endTime = `${endHours.toString().padStart(2, '0')}:${endMins.toString().padStart(2, '0')}`;
                    const endTimeDisplay = formatTime12Hour(endHours, endMins);

                    document.getElementById('end_time').value = endTime;
                    document.getElementById('end_time_display').textContent = endTimeDisplay;
                }
            });




            // Form submission
            document.getElementById('appointmentForm').addEventListener('submit', function(e) {
                // Validate required fields before submission
                if (!selectedService || !selectedSpecialist) {
                    e.preventDefault();
                    showNotification('Please complete all required fields.', 'error');
                    return;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';

                // Let the form submit naturally to the server
                // The form will be processed by the AppointmentController@store method
            });

            // Auto-dismiss session messages after 3 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const sessionMessages = document.querySelectorAll('.session-message');
                sessionMessages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.transition = 'opacity 0.5s ease-out';
                        message.style.opacity = '0';
                        setTimeout(function() {
                            if (message.parentElement) {
                                message.remove();
                            }
                        }, 500);
                    }, 3000);
                });
            });

            // Notification system
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotifications = document.querySelectorAll('.notification');
                existingNotifications.forEach(notification => notification.remove());

                // Create notification element
                const notification = document.createElement('div');
                notification.className = `notification fixed top-4 right-4 z-50 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300 ease-in-out translate-x-full`;

                let iconColor = 'text-blue-400';
                let bgColor = 'bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100';
                let borderColor = 'border-blue-200';

                if (type === 'success') {
                    iconColor = 'text-green-400';
                    bgColor = 'bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100';
                    borderColor = 'border-green-200';
                } else if (type === 'error') {
                    iconColor = 'text-red-400';
                    bgColor = 'bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100';
                    borderColor = 'border-red-200';
                } else if (type === 'warning') {
                    iconColor = 'text-yellow-400';
                    bgColor = 'bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100';
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

                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.classList.add('translate-x-full');
                        setTimeout(() => {
                            if (notification.parentElement) {
                                notification.remove();
                            }
                        }, 300);
                    }
                }, 3000);
            }

            // Function to change specialist
            function changeSpecialist() {
                selectedSpecialist = null;
                document.getElementById('selectedSpecialistId').value = '';
                
                // Hide pre-selected specialist display
                const preselectedDiv = document.querySelector('.bg-blue-50');
                if (preselectedDiv) {
                    preselectedDiv.style.display = 'none';
                }

                // Load specialists for the selected service if available
                if (selectedService) {
                    loadSpecialists(selectedService.id);
                }
            }

            // Show modal for fully booked specialists
            function showFullyBookedModal(specialistName) {
                const modal = document.getElementById('fullyBookedModal');
                document.getElementById('modalSpecialistName').textContent = specialistName;
                modal.classList.remove('hidden');
            }

            // Close modal
            function closeFullyBookedModal() {
                document.getElementById('fullyBookedModal').classList.add('hidden');
            }
        </script>
            <!-- Leaflet Dependencies -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


            <script>
            document.addEventListener("DOMContentLoaded", () => {
                const homeService = document.getElementById("is_home_service");
                const container = document.getElementById("homeAddressContainer");
                const searchBox = document.getElementById("searchBox");
                const addressBox = document.getElementById("home_address");
                const lat = document.getElementById("latitude");
                const lng = document.getElementById("longitude");

                // Initialize map
                const map = L.map("map").setView([14.5995, 120.9842], 13);
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: "&copy; OpenStreetMap contributors"
                }).addTo(map);

                let marker;

                // Show/hide map
                homeService.addEventListener("change", () => {
                    if (homeService.checked) {
                        container.classList.remove("hidden");
                        setTimeout(() => map.invalidateSize(), 300);
                    } else {
                        container.classList.add("hidden");
                    }
                });

                // Click on map to set location
                map.on("click", async (e) => {
                    const { lat: latVal, lng: lngVal } = e.latlng;
                    setMarker(latVal, lngVal);
                    await reverseGeocode(latVal, lngVal);
                });

                // Search by typing
                searchBox.addEventListener("keypress", async (e) => {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        const query = searchBox.value.trim();
                        if (!query) return;

                        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                        const results = await res.json();
                        if (results.length > 0) {
                            const place = results[0];
                            const latVal = parseFloat(place.lat);
                            const lngVal = parseFloat(place.lon);
                            setMarker(latVal, lngVal);
                            map.setView([latVal, lngVal], 15);
                            addressBox.value = place.display_name;
                            lat.value = latVal.toFixed(6);
                            lng.value = lngVal.toFixed(6);
                        } else {
                            alert("Location not found, please try another search term.");
                        }
                    }
                });

                // Helper functions
                function setMarker(latVal, lngVal) {
                    if (marker) marker.setLatLng([latVal, lngVal]);
                    else marker = L.marker([latVal, lngVal]).addTo(map);
                    lat.value = latVal.toFixed(6);
                    lng.value = lngVal.toFixed(6);
                }

                async function reverseGeocode(latVal, lngVal) {
                    try {
                        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latVal}&lon=${lngVal}&format=json`);
                        const data = await res.json();
                        if (data.display_name) addressBox.value = data.display_name;
                    } catch (err) {
                        console.error("Reverse geocoding failed:", err);
                    }
                }

                const tipBtns = document.querySelectorAll(".tip-btn");
                const customTip = document.getElementById("custom_tip");
                const selectedTip = document.getElementById("selected_tip");

                tipBtns.forEach(btn => {
                    btn.addEventListener("click", () => {
                        tipBtns.forEach(b => {
                            b.classList.remove("bg-green-200", "text-green-800", "border-green-400", "ring-2", "ring-green-300");
                            b.classList.add("bg-gray-100", "text-gray-700");
                        });

                        btn.classList.remove("bg-gray-100", "text-gray-700");
                        btn.classList.add("bg-green-200", "text-green-800", "border-green-400", "ring-2", "ring-green-300");

                        selectedTip.value = btn.dataset.amount;
                        customTip.value = "";
                    });
                });

                customTip.addEventListener("input", () => {
                    if (customTip.value) {
                    
                        tipBtns.forEach(b => {
                            b.classList.remove("bg-green-200", "text-green-800", "border-green-400", "ring-2", "ring-green-300");
                            b.classList.add("bg-gray-100", "text-gray-700");
                        });
                        selectedTip.value = customTip.value;
                    } else {
                        selectedTip.value = 0;
                    }
                });
            });

            // PAYMENT METHOD LOGIC
                document.addEventListener('DOMContentLoaded', () => {
                    const buttons = document.querySelectorAll('.payment-option');
                    const hiddenInput = document.getElementById('payment_method');
                    const errorMsg = document.getElementById('paymentError');

                    buttons.forEach(button => {
                        button.addEventListener('click', () => {
                            // Reset all buttons
                            buttons.forEach(b => {
                                b.classList.remove('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-300', 'scale-105');
                                b.classList.add('border-transparent', 'bg-white');
                            });

                            // Highlight selected
                            button.classList.remove('bg-white');
                            button.classList.add('border-green-500', 'bg-green-50', 'ring-2', 'ring-green-300', 'scale-105');

                            // Save selected payment method
                            hiddenInput.value = button.getAttribute('data-method');
                            errorMsg.classList.add('hidden');
                        });
                    });

                    // Prevent form submit if no payment selected
                    document.getElementById('appointmentForm').addEventListener('submit', e => {
                        if (!hiddenInput.value) {
                            e.preventDefault();
                            errorMsg.classList.remove('hidden');
                            showNotification('Please select a payment method.', 'error');
                            window.scrollTo({ top: document.getElementById('step5').offsetTop, behavior: 'smooth' });
                        }
                    });
                });


            </script>

    <style>
    #start_time option:disabled {
        color: #bbb;
        text-decoration: line-through;
    }
    
    .pointer-events-none {
        pointer-events: none !important;
        cursor: not-allowed !important;
    }
    
    [data-disabled="true"] {
        pointer-events: none !important;
        cursor: not-allowed !important;
        user-select: none !important;
    }
    </style>


    </x-customer-layout>
