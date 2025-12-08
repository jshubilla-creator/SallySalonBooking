<x-customer-layout>
    <!-- Modal Overlay -->
    <div id="appointmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Box -->
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <h1 class="text-2xl font-bold mb-4">Appointment Details</h1>

            <div class="space-y-3 text-gray-700 mb-4">
                <div class="flex justify-between">
                    <span class="font-medium">Service:</span>
                    <span>{{ $appointment->service->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Specialist:</span>
                    <span>with {{ $appointment->specialist->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Date:</span>
                    <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Time:</span>
                    <span>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('g:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Home Service:</span>
                    <span>{{ $appointment->is_home_service ? 'Yes' : 'No' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Address:</span>
                    <span>{{ $appointment->home_address ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Tip:</span>
                    <span>₱{{ number_format($appointment->tip_amount ?? 0, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Payment Method:</span>
                    <span>
                        @switch(strtolower($appointment->payment_method))
                            @case('gcash') 💙 GCash @break
                            @case('maya') 💚 Maya @break
                            @case('cash') 💵 Cash @break
                            @case('debit') 
                            @case('credit') 💳 Debit / Credit @break
                            @default 💰 {{ $appointment->payment_method ?? 'N/A' }}
                        @endswitch
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Status:</span>
                    <span>{{ ucfirst($appointment->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Cancellation Reason:</span>
                    <span>{{ $appointment->cancellation_reason ?? 'No reason provided' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Total:</span>
                    <span>₱{{ number_format($appointment->total_price, 2) }}</span>
                </div>
            </div>

            @if($appointment->is_home_service)
                <div class="mt-4">
                    <h2 class="text-lg font-semibold mb-2">Track specialist en route</h2>
                    <div id="trackingMap" class="w-full h-64 rounded-md border" style="min-height:16rem"></div>
                    <p id="trackingStatus" class="text-sm text-gray-500 mt-2">Waiting for location updates...</p>
                </div>
            @endif

            <!-- Close Button Below -->
            <div class="flex justify-end">
                <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }
    </script>

@if($appointment->is_home_service)
    <!-- Leaflet (lightweight, no API key) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+4o0F+q1m0a0s3gkQmq7xg6rK0cQp/3qf7kP0pP4k=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1j8p3JgYg5QkW3QhGx6XvRkF2wG7xjKx2o0m0a1w=" crossorigin=""></script>

    <script>
        (function(){
            const appointmentId = {{ $appointment->id }};
            const mapEl = document.getElementById('trackingMap');

            // initialize map
            const map = L.map(mapEl).setView([14.5995, 120.9842], 12); // default Manila
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let specialistMarker = null;
            let customerMarker = null;

            function updateMarkers(data) {
                const statusEl = document.getElementById('trackingStatus');
                if (data.specialist && data.specialist.latitude && data.specialist.longitude) {
                    const lat = parseFloat(data.specialist.latitude);
                    const lng = parseFloat(data.specialist.longitude);
                    if (!specialistMarker) {
                        specialistMarker = L.marker([lat, lng], {title: data.specialist.name}).addTo(map).bindPopup('Specialist: ' + data.specialist.name);
                    } else {
                        specialistMarker.setLatLng([lat, lng]);
                    }
                    statusEl.textContent = 'Specialist last seen: ' + (data.specialist.updated_at ? new Date(data.specialist.updated_at).toLocaleTimeString() : 'recently');
                }

                if (data.appointment && data.appointment.latitude && data.appointment.longitude) {
                    const alat = parseFloat(data.appointment.latitude);
                    const alng = parseFloat(data.appointment.longitude);
                    if (!customerMarker) {
                        customerMarker = L.marker([alat, alng], {title: 'Customer'}).addTo(map).bindPopup('Customer address');
                    } else {
                        customerMarker.setLatLng([alat, alng]);
                    }
                }

                // adjust bounds if both present
                const points = [];
                if (specialistMarker) points.push(specialistMarker.getLatLng());
                if (customerMarker) points.push(customerMarker.getLatLng());
                if (points.length===1) {
                    map.setView(points[0], 14);
                } else if (points.length>1) {
                    const bounds = L.latLngBounds(points);
                    map.fitBounds(bounds.pad(0.4));
                }
            }

            async function poll() {
                try {
                    const res = await fetch('/api/appointments/' + appointmentId + '/location', {credentials: 'same-origin'});
                    if (!res.ok) throw new Error('Network response not ok');
                    const data = await res.json();
                    updateMarkers(data);
                } catch (err) {
                    console.error('Polling error', err);
                    document.getElementById('trackingStatus').textContent = 'Unable to fetch location updates.';
                }
            }

            // initial load then poll every 5 seconds
            poll();
            setInterval(poll, 5000);
        })();
    </script>
@endif
</x-customer-layout>
