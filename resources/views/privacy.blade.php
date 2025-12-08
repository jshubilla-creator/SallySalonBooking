<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Sally Salon</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 font-['Poppins']">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Privacy Policy</h1>
                    <p class="text-gray-600 mt-2">Last updated: {{ date('F d, Y') }}</p>
                </div>

                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">1. Information We Collect</h2>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>Personal information (name, email, phone number)</li>
                        <li>Appointment history and preferences</li>
                        <li>Payment information (processed securely)</li>
                        <li>Communication records</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">2. How We Use Your Information</h2>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>Schedule and manage appointments</li>
                        <li>Send appointment reminders and confirmations</li>
                        <li>Process payments</li>
                        <li>Improve our services</li>
                        <li>Send promotional offers (with your consent)</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">3. Information Sharing</h2>
                    <p class="mb-6 text-gray-700">We do not sell, trade, or rent your personal information to third parties. We may share information only:</p>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>With your explicit consent</li>
                        <li>To comply with legal requirements</li>
                        <li>With trusted service providers who assist our operations</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">4. Data Security</h2>
                    <p class="mb-6 text-gray-700">We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">5. Your Rights</h2>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your data</li>
                        <li>Opt-out of marketing communications</li>
                    </ul>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">6. Cookies</h2>
                    <p class="mb-6 text-gray-700">We use cookies to enhance your experience on our website. You can disable cookies in your browser settings, but this may affect website functionality.</p>

                    <h2 class="text-xl font-semibold text-gray-800 mb-4">7. Contact Us</h2>
                    <p class="mb-6 text-gray-700">If you have questions about this Privacy Policy, please contact us at privacy@sallysalon.com</p>
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