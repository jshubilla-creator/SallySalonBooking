@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Book Appointment</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
            @csrf
            
            <!-- Service Selection -->
            <div class="mb-6">
                <label for="service_id" class="block text-gray-700 font-bold mb-2">Service</label>
                <select name="service_id" id="service_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select a service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration }}">
                            {{ $service->name }} - ₱{{ number_format($service->price, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Specialist Selection -->
            <div class="mb-6">
                <label for="specialist_id" class="block text-gray-700 font-bold mb-2">Specialist</label>
                <select name="specialist_id" id="specialist_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select a specialist</option>
                    @foreach($specialists as $specialist)
                        <option value="{{ $specialist->id }}">{{ $specialist->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="appointment_date" class="block text-gray-700 font-bold mb-2">Date</label>
                    <input type="date" name="appointment_date" id="appointment_date" 
                           class="w-full border-gray-300 rounded-md shadow-sm"
                           min="{{ date('Y-m-d') }}" required>
                </div>
                <div>
                    <label for="start_time" class="block text-gray-700 font-bold mb-2">Time</label>
                    <input type="time" name="start_time" id="start_time" 
                           class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="contact_phone" class="block text-gray-700 font-bold mb-2">Contact Phone</label>
                    <input type="tel" name="contact_phone" id="contact_phone" 
                           class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="contact_email" class="block text-gray-700 font-bold mb-2">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email" 
                           class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            </div>

            <!-- Home Service Option -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_home_service" id="is_home_service" 
                           class="rounded border-gray-300 text-indigo-600 shadow-sm">
                    <label for="is_home_service" class="ml-2 block text-gray-700 font-bold">
                        Book as Home Service
                    </label>
                </div>
                <p class="text-sm text-gray-600 mt-1">
                    Note: Home service is only available in Taguig and Pasig City
                </p>
            </div>

            <!-- Home Address (conditionally shown) -->
            <div id="homeAddressSection" class="mb-6 hidden">
                <label for="home_address" class="block text-gray-700 font-bold mb-2">Home Address</label>
                <textarea name="home_address" id="home_address" rows="3" 
                          class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                <div id="addressValidationMessage" class="mt-2 text-sm"></div>
            </div>

            <!-- Price Breakdown -->
            <div class="mb-6 bg-gray-50 p-4 rounded-md">
                <h3 class="font-bold text-lg mb-3">Price Breakdown</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Service Price:</span>
                        <span id="servicePrice">₱0.00</span>
                    </div>
                    <div id="homeServiceFeeSection" class="flex justify-between hidden">
                        <span>Home Service Fee:</span>
                        <span id="homeServiceFee">₱0.00</span>
                    </div>
                    <div class="border-t pt-2 font-bold flex justify-between">
                        <span>Total:</span>
                        <span id="totalPrice">₱0.00</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                    Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('appointmentForm');
    const isHomeService = document.getElementById('is_home_service');
    const homeAddressSection = document.getElementById('homeAddressSection');
    const homeServiceFeeSection = document.getElementById('homeServiceFeeSection');
    const homeAddress = document.getElementById('home_address');
    const serviceSelect = document.getElementById('service_id');
    const servicePriceDisplay = document.getElementById('servicePrice');
    const homeServiceFeeDisplay = document.getElementById('homeServiceFee');
    const totalPriceDisplay = document.getElementById('totalPrice');
    const addressValidationMessage = document.getElementById('addressValidationMessage');

    let debounceTimer;
    let currentServicePrice = 0;
    let currentHomeServiceFee = 0;

    // Toggle home service fields
    isHomeService.addEventListener('change', function() {
        homeAddressSection.classList.toggle('hidden', !this.checked);
        homeServiceFeeSection.classList.toggle('hidden', !this.checked);
        homeAddress.required = this.checked;
        if (!this.checked) {
            currentHomeServiceFee = 0;
            updatePriceDisplay();
        }
    });

    // Update service price when service is selected
    serviceSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        currentServicePrice = selectedOption.dataset.price ? parseFloat(selectedOption.dataset.price) : 0;
        updatePriceDisplay();
    });

    // Validate address and calculate fee
    homeAddress.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        if (this.value.trim()) {
            debounceTimer = setTimeout(() => validateAddress(this.value), 500);
        } else {
            addressValidationMessage.textContent = '';
            currentHomeServiceFee = 0;
            updatePriceDisplay();
        }
    });

    function validateAddress(address) {
        addressValidationMessage.textContent = 'Validating address...';
        addressValidationMessage.className = 'mt-2 text-sm text-gray-600';

        fetch('/api/validate-address', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ address })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                addressValidationMessage.textContent = 'Address is valid. Distance: ' + 
                    data.distance_km.toFixed(2) + ' km';
                addressValidationMessage.className = 'mt-2 text-sm text-green-600';
                currentHomeServiceFee = data.fee;
            } else {
                addressValidationMessage.textContent = data.message;
                addressValidationMessage.className = 'mt-2 text-sm text-red-600';
                currentHomeServiceFee = 0;
            }
            updatePriceDisplay();
        })
        .catch(error => {
            addressValidationMessage.textContent = 'Error validating address. Please try again.';
            addressValidationMessage.className = 'mt-2 text-sm text-red-600';
            currentHomeServiceFee = 0;
            updatePriceDisplay();
        });
    }

    function updatePriceDisplay() {
        servicePriceDisplay.textContent = `₱${currentServicePrice.toFixed(2)}`;
        homeServiceFeeDisplay.textContent = `₱${currentHomeServiceFee.toFixed(2)}`;
        const total = currentServicePrice + currentHomeServiceFee;
        totalPriceDisplay.textContent = `₱${total.toFixed(2)}`;
    }

    // Validate specialist availability
    function checkSpecialistAvailability() {
        const specialist_id = document.getElementById('specialist_id').value;
        const appointment_date = document.getElementById('appointment_date').value;
        const start_time = document.getElementById('start_time').value;
        const service_id = document.getElementById('service_id').value;

        if (specialist_id && appointment_date && start_time && service_id) {
            fetch('/appointments/check-availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    specialist_id,
                    appointment_date,
                    start_time,
                    service_id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.available) {
                    alert('The specialist is not available at this time. Please select a different time.');
                }
            });
        }
    }

    // Check availability when date/time/specialist changes
    document.getElementById('specialist_id').addEventListener('change', checkSpecialistAvailability);
    document.getElementById('appointment_date').addEventListener('change', checkSpecialistAvailability);
    document.getElementById('start_time').addEventListener('change', checkSpecialistAvailability);
});
</script>
@endpush