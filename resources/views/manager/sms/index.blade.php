<x-manager-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                <p class="mt-2 text-lg text-gray-600">Manage SMS and Email notifications</p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-5 flex items-center">
            <svg class="h-6 w-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="ml-4">
                <dt class="text-sm font-medium text-gray-500 truncate">SMS Sent Today</dt>
                <dd class="text-lg font-medium text-gray-900">{{ $smsSentToday ?? 0 }}</dd>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center">
            <svg class="h-6 w-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="ml-4">
                <dt class="text-sm font-medium text-gray-500 truncate">Pending Reminders</dt>
                <dd class="text-lg font-medium text-gray-900">{{ $pendingReminders ?? 0 }}</dd>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center">
            <svg class="h-6 w-6 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <div class="ml-4">
                <dt class="text-sm font-medium text-gray-500 truncate">Success Rate</dt>
                <dd class="text-lg font-medium text-gray-900">{{ $successRate ?? '95' }}%</dd>
            </div>
        </div>
    </div>

    <!-- SMS + EMAIL Panels -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Send Manual SMS -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Send Manual SMS</h3>
                <form action="{{ route('manager.sms.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
                            placeholder="+63..." required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
                            placeholder="Enter your message here..." required></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">Send
                        SMS</button>
                </form>
            </div>
        </div>

        <!-- Send Email Notifications -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Send Manual Email</h3>
                <form action="{{ route('manager.email.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                     <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Recipient Email</label>
                        <select name="email" id="email"
                            onchange="fillTemplateData(this)"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select a recipient...</option>
                            @foreach ($confirmedBookings as $booking)
                                <option value="{{ $booking->user->email }}"
                                        data-name="{{ $booking->user->name }}"
                                        data-specialist="{{ $booking->specialist->name ?? 'No Specialist Assigned' }}"
                                        data-service="{{ $booking->service->name ?? 'Service' }}"
                                        data-date="{{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}">
                                    {{ $booking->user->name }} — {{ $booking->user->email }} ({{ $booking->service->name ?? 'Service' }})
                                </option>
                            @endforeach
                        </select>

                        </select>

                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" id="subject"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter email subject..." required>
                    </div>
                    <div>
                        <label for="emailMessage" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="emailMessage" name="message" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your email message here..." required></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">Send
                        Email</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Templates -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Templates</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Appointment Confirmation -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('sms', 'Hi {name}! Your appointment for {service} with {specialist} on {date} at {time} has been confirmed. Thank you!')">
                    <h4 class="font-medium text-gray-900 mb-2">Appointment Confirmation</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}! Your appointment for {service} with {specialist} on {date} at {time} has been confirmed. Thank you!</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Auto-sent
                        on approval</span>
                </div>

                <!-- Appointment Reminder -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('sms', 'Reminder: You have an appointment for {service} with {specialist} tomorrow at {time}. See you soon!')">
                    <h4 class="font-medium text-gray-900 mb-2">Appointment Reminder</h4>
                    <p class="text-sm text-gray-600 mb-3">Reminder: You have an appointment for {service} with {specialist} tomorrow at {time}. See you soon!</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Sent
                        daily at 6 PM</span>
                </div>

                <!-- ETA Notification -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('email', 'Hi {name}, your specialist {specialist} is on the way! Estimated arrival time: {eta}. Please prepare for your appointment.')">
                    <h4 class="font-medium text-gray-900 mb-2">ETA Notification</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}, your specialist {specialist} is on the way! Estimated arrival time: {eta}. Please prepare for your appointment.</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Manual
                        or Auto-send</span>
                </div>

                <!-- Service Completion -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('email', 'Hi {name}, your {service} service with {specialist} has been completed successfully. We hope you’re satisfied with the result! Thank you for trusting us.')">
                    <h4 class="font-medium text-gray-900 mb-2">Service Completion</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}, your {service} service with {specialist} has been completed successfully. We hope you’re satisfied with the result! Thank you for trusting us.</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Auto
                        or Manual</span>
                </div>

                <!-- Payment Reminder -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('sms', 'Hi {name}, this is a friendly reminder that your payment of ₱{amount} for your {service} is due on {date}. Thank you!')">
                    <h4 class="font-medium text-gray-900 mb-2">Payment Reminder</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}, this is a friendly reminder that your payment of ₱{amount} for your {service} is due on {date}. Thank you!</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Manual
                        or Scheduled</span>
                </div>

                <!-- Thank You Message -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('email', 'Hi {name}, thank you for visiting us for your {service} today! Your satisfaction is our top priority — we hope to see you again soon.')">
                    <h4 class="font-medium text-gray-900 mb-2">Thank You Message</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}, thank you for visiting us for your {service} today! Your satisfaction is our top priority — we hope to see you again soon.</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">Auto
                        after completion</span>
                </div>

                <!-- Reschedule Notification -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('email', 'Hi {name}, your appointment for {service} has been rescheduled to {new_date} at {new_time}. Please confirm your availability. Thank you!')">
                    <h4 class="font-medium text-gray-900 mb-2">Reschedule Notification</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}, your appointment for {service} has been rescheduled to {new_date} at {new_time}. Please confirm your availability. Thank you!</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Manual
                        Send</span>
                </div>

                <!-- Custom Alert -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                    onclick="applyTemplate('sms', 'Hi {name}, this is a custom alert regarding your appointment or service. Please contact us for more details.')">
                    <h4 class="font-medium text-gray-900 mb-2">Custom Alert</h4>
                    <p class="text-sm text-gray-600 mb-3">Hi {name}, this is a custom alert regarding your appointment or service. Please contact us for more details.</p>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">For
                        urgent notices</span>
                </div>
            </div>
        </div>
    </div>

    <!-- JS: Template Click Handling -->
    <script>
        function applyTemplate(type, content) {
            if (type === 'sms') {
                document.getElementById('message').value = content;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else if (type === 'email') {
                document.getElementById('emailMessage').value = content;
                document.getElementById('subject').value = "Appointment Update";
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    </script>

    <script>
    function fillTemplateData(select) {
        const selected = select.options[select.selectedIndex];
        window.selectedRecipient = {
            name: selected.getAttribute('data-name') || '',
            specialist: selected.getAttribute('data-specialist') || '',
            service: selected.getAttribute('data-service') || '',
            date: selected.getAttribute('data-date') || '',
            time: selected.getAttribute('data-time') || '',
        };
    }

    // Override template insert to replace placeholders
    const originalApplyTemplate = applyTemplate;
    applyTemplate = function(type, content) {
        if (window.selectedRecipient) {
            Object.keys(window.selectedRecipient).forEach(key => {
                const regex = new RegExp(`{${key}}`, 'g');
                content = content.replace(regex, window.selectedRecipient[key]);
            });
        }
        originalApplyTemplate(type, content);
    }
</script>

</x-manager-layout>
