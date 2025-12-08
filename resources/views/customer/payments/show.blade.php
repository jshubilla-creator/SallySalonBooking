<x-customer-layout>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment for Appointment #{{ $appointment->id }}</h2>
            
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Appointment Details</h3>
                <p><strong>Service:</strong> {{ $appointment->service->name }}</p>
                <p><strong>Specialist:</strong> {{ $appointment->specialist->name }}</p>
                <p><strong>Date:</strong> {{ $appointment->appointment_date->format('M d, Y') }}</p>
                <p><strong>Total Amount:</strong> ₱{{ number_format($appointment->total_price, 2) }}</p>
            </div>

            @if($appointment->payment_status === 'paid')
                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 font-semibold">✓ Payment Completed</p>
                </div>
            @else
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Choose Payment Method</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button onclick="processPayment('stripe')" 
                                class="p-4 border-2 border-blue-200 rounded-lg hover:border-blue-400 transition-colors">
                            <div class="text-center">
                                <div class="text-blue-600 font-semibold">Stripe</div>
                                <div class="text-sm text-gray-600">Credit/Debit Card</div>
                            </div>
                        </button>

                        <button onclick="processPayment('paypal')" 
                                class="p-4 border-2 border-yellow-200 rounded-lg hover:border-yellow-400 transition-colors">
                            <div class="text-center">
                                <div class="text-yellow-600 font-semibold">PayPal</div>
                                <div class="text-sm text-gray-600">PayPal Account</div>
                            </div>
                        </button>

                        <button onclick="processPayment('paymongo')" 
                                class="p-4 border-2 border-green-200 rounded-lg hover:border-green-400 transition-colors">
                            <div class="text-center">
                                <div class="text-green-600 font-semibold">PayMongo</div>
                                <div class="text-sm text-gray-600">Local Banking</div>
                            </div>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        async function processPayment(gateway) {
            try {
                const response = await fetch(`/customer/appointments/{{ $appointment->id }}/payment/create?gateway=${gateway}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = data.payment_url;
                }
            } catch (error) {
                alert('Payment processing failed. Please try again.');
            }
        }
    </script>
</x-customer-layout>