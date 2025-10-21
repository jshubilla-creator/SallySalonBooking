<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Feedback Details</h1>
                <p class="mt-2 text-lg text-gray-600">Review customer feedback</p>
            </div>
            <a href="{{ route('manager.feedback.index') }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors duration-200">
                Back to Feedback
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Feedback Details -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-lg font-medium text-green-600">{{ substr($feedback->user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">{{ $feedback->user->name }}</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($feedback->type) }}
                                    </span>
                                    @if($feedback->is_public)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Public
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Private
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-2 flex items-center space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="text-sm text-gray-500 ml-2">{{ $feedback->rating }}/5 stars</span>
                            </div>

                            @if($feedback->comment)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Comment</h4>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-4 rounded-lg">{{ $feedback->comment }}</p>
                                </div>
                            @endif

                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Submitted on {{ $feedback->created_at->format('M d, Y \a\t H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($feedback->appointment)
                <!-- Related Appointment -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Related Appointment</h3>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $feedback->appointment->service->name }}</h4>
                                    <p class="text-sm text-gray-500">with {{ $feedback->appointment->specialist->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-900">{{ $feedback->appointment->appointment_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $feedback->appointment->start_time }}</p>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($feedback->appointment->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($feedback->appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($feedback->appointment->status === 'completed') bg-blue-100 text-blue-800
                                    @elseif($feedback->appointment->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($feedback->appointment->status) }}
                                </span>
                                <span class="text-sm font-medium text-gray-900">${{ number_format($feedback->appointment->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Customer Information -->
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Information</h3>

                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $feedback->user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $feedback->user->email }}</dd>
                        </div>

                        @if($feedback->user->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $feedback->user->phone }}</dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $feedback->user->created_at->format('M d, Y') }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('manager.users.show', $feedback->user) }}"
                           class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                            View Customer Profile
                        </a>

                        <a href="mailto:{{ $feedback->user->email }}"
                           class="w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Send Email
                        </a>

                        @if($feedback->user->phone)
                            <a href="tel:{{ $feedback->user->phone }}"
                               class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                Call Customer
                            </a>
                        @endif

                        <form method="POST" action="{{ route('manager.feedback.destroy', $feedback) }}" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this feedback?')"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors duration-200">
                                Delete Feedback
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
