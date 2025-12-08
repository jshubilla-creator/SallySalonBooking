<x-customer-layout>
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Feedback</h1>
            <p class="mt-2 text-gray-600">Share your experience and help us improve our services</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg session-message" data-type="success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg session-message" data-type="error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Appointments Without Feedback -->
        @if($appointmentsWithoutFeedback->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Complete Appointments - Leave Feedback</h2>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($appointmentsWithoutFeedback as $appointment)
                        @if($appointment && $appointment->service && $appointment->specialist)
                            <div class="bg-blue-100 rounded-lg shadow-md p-6 border border-gray-200">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $appointment->service->name }}</h3>
                                        <p class="text-sm text-gray-600">with {{ $appointment->specialist->name }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium">Date:</span> {{ $appointment->appointment_date->format('M d, Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium">Time:</span> {{ \App\Helpers\TimeHelper::formatTimeRange($appointment->start_time, $appointment->end_time) }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <span class="font-medium">Total:</span> ₱{{ number_format($appointment->total_price, 2) }}
                                    </p>
                                </div>

                                <a href="{{ route('customer.feedback.create', $appointment) }}"
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Leave Feedback
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Existing Feedback -->
        @if($existingFeedback->count() > 0)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">My Previous Feedback</h2>
                <div class="space-y-6">
                    @foreach($existingFeedback as $feedback)
                        @if($feedback && $feedback->appointment && $feedback->appointment->service && $feedback->appointment->specialist)
                            <div class="bg-blue-100 rounded-lg shadow-md p-6 border border-gray-200">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h3 class="text-lg font-medium text-gray-900 mr-3">{{ $feedback->appointment->service->name }}</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($feedback->type) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">with {{ $feedback->appointment->specialist->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $feedback->appointment->appointment_date->format('M d, Y') }} •
                                            {{ \App\Helpers\TimeHelper::formatTimeRange($feedback->appointment->start_time, $feedback->appointment->end_time) }}
                                        </p>
                                    </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-5 w-5 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600">{{ $feedback->rating }}/5</span>
                                    </div>
                                </div>
                            </div>

                            @if($feedback->comment)
                                <div class="mb-4">
                                    <p class="text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $feedback->comment }}</p>
                                </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500">
                                    Submitted on {{ $feedback->created_at->format('M d, Y \a\t g:i A') }}
                                </p>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('customer.feedback.edit', $feedback) }}"
                                       class="text-sm text-green-600 hover:text-green-800 font-medium">
                                        Edit
                                    </a>
                                    <button type="button" onclick="openDeleteModal({{ $feedback->id }})" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                        Delete
                                    </button>
                                    <form id="delete-form-{{ $feedback->id }}" method="POST" action="{{ route('customer.feedback.destroy', $feedback) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @elseif($appointmentsWithoutFeedback->count() == 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No feedback yet</h3>
                <p class="mt-1 text-sm text-gray-500">Complete some appointments to leave feedback and help us improve our services.</p>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-blue-100 rounded-lg shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Delete Feedback</h3>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-600">Are you sure you want to delete this feedback? This action cannot be undone.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                Cancel
            </button>
            <button onclick="confirmDelete()" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                Delete
            </button>
        </div>
    </div>
</div>

<script>
let currentFeedbackId = null;

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

function openDeleteModal(feedbackId) {
    currentFeedbackId = feedbackId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    currentFeedbackId = null;
    document.getElementById('deleteModal').classList.add('hidden');
}

function confirmDelete() {
    if (currentFeedbackId) {
        document.getElementById('delete-form-' + currentFeedbackId).submit();
    }
}
</script>

</x-customer-layout>
