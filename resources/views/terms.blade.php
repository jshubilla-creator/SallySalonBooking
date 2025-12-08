<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - Sally Salon</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 font-['Poppins']">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Terms and Conditions</h1>
                    <p class="text-gray-600 mt-2">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">1. Acceptance of Terms</h2>
                    <p class="mb-6 text-gray-700">By accessing and using Sally Salon's booking system, you accept and agree to be bound by the terms and provision of this agreement.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">2. Booking and Appointments</h2>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>All appointments must be booked through our online system</li>
                        <li>Cancellations must be made at least 24 hours in advance</li>
                        <li>Late arrivals may result in shortened service time or rescheduling</li>
                        <li>No-shows may be charged a cancellation fee</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">3. Payment Terms</h2>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>Payment is due at the time of service</li>
                        <li>We accept cash, credit cards, and digital payments</li>
                        <li>Prices are subject to change without notice</li>
                        <li>Gratuities are appreciated but not mandatory</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">4. User Responsibilities</h2>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>Provide accurate contact information</li>
                        <li>Arrive on time for appointments</li>
                        <li>Inform us of any allergies or medical conditions</li>
                        <li>Treat staff and other customers with respect</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">5. Limitation of Liability</h2>
                    <p class="mb-6 text-gray-700">Sally Salon shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of our services.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">6. Contact Information</h2>
                    <p class="mb-6 text-gray-700">If you have any questions about these Terms and Conditions, please contact us at info@sallysalon.com</p>
                </div>

                <div class="text-center mt-8">
                    <button onclick="window.close()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>