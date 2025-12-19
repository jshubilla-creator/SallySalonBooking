<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
                <p class="mt-2 text-lg text-gray-600">Configure global system settings and preferences</p>
            </div>

            <div class="space-y-6">

                <!-- General Settings -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">General Settings</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Salon Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Salon Name</label>
                                <input type="text" name="salon_name"
                                       value="{{ old('salon_name', $settings['salon_name']) }}"
                                       class="w-full px-3 py-2 border rounded-md">
                            </div>

                            <!-- Salon Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Salon Email</label>
                                <input type="email" name="salon_email"
                                       value="{{ old('salon_email', $settings['salon_email']) }}"
                                       class="w-full px-3 py-2 border rounded-md">
                            </div>

                            <!-- Salon Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Salon Phone</label>
                                <input type="text" name="salon_phone"
                                       value="{{ old('salon_phone', $settings['salon_phone']) }}"
                                       class="w-full px-3 py-2 border rounded-md">
                            </div>

                            <!-- Salon Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Salon Address</label>
                                <textarea name="salon_address" rows="3"
                                          class="w-full px-3 py-2 border rounded-md">{{ old('salon_address', $settings['salon_address']) }}</textarea>
                            </div>



                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md">Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>



                <!-- Payment Gateway Status -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Payment System Status</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Online Payment Status -->
                            <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800">Online Payment Gateway</h4>
                                        <p class="text-sm text-yellow-700">No online payment gateway configured (PayPal, Stripe, etc.)</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Not Connected
                                </span>
                            </div>

                            <!-- Manual Payment Status -->
                            <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-green-800">Manual Payment Processing</h4>
                                        <p class="text-sm text-green-700">Staff can record cash, card, and bank transfer payments</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>

                            <!-- Payment Methods Info -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-800 mb-2">Current Payment Workflow</h4>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Customers select payment method during booking</li>
                                    <li>• Staff manually record payments in the system</li>
                                    <li>• Payment status tracked as Pending/Paid</li>
                                    <li>• No automatic online payment processing</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- System Maintenance -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">System Maintenance</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <form method="POST" action="{{ route('admin.settings.clearCache') }}">
                                    @csrf
                                    <h3 class="text-sm font-medium text-gray-900">Clear Cache</h3>
                                    <p class="text-sm text-gray-500">Clear application cache to improve performance</p>
                                </div>
                                <button type="submit"
                                        class="w-48 flex item-center justify-center flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />                                      
                                    </svg>
                                    Clear Cache
                                </button>
                                </form>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <form method="POST" action="{{ route('admin.settings.backupNow') }}">
                                    @csrf
                                    <h3 class="text-sm font-medium text-gray-900">System Backup</h3>
                                    <p class="text-sm text-gray-500">Create a complete backup of database (including manager data), uploads, and system files</p>
                                </div>
                                <button type="submit"
                                        class="w-48 flex item-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 inline-flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Download Backup
                                </button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
