<x-customer-layout>
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Feedback</h1>
            <p class="mt-2 text-gray-600">Update your feedback to help us improve our services</p>
        </div>

        <!-- Appointment Details -->
        @if($feedback && $feedback->appointment && $feedback->appointment->service && $feedback->appointment->specialist)
            <div class="bg-blue-100 rounded-lg shadow-md p-6 mb-8 border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Appointment Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Service</p>
                        <p class="text-gray-900">{{ $feedback->appointment->service->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Specialist</p>
                        <p class="text-gray-900">{{ $feedback->appointment->specialist->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Date</p>
                        <p class="text-gray-900">{{ $feedback->appointment->appointment_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Time</p>
                        <p class="text-gray-900">{{ \App\Helpers\TimeHelper::formatTimeRange($feedback->appointment->start_time, $feedback->appointment->end_time) }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-8">
                <p class="font-medium">Error: Invalid feedback data</p>
                <p class="text-sm">The feedback information could not be loaded. Please try again or contact support.</p>
            </div>
        @endif

        <!-- Feedback Form -->
        <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md p-6 border border-gray-200">
            <form method="POST" action="{{ route('customer.feedback.update', $feedback) }}">
                @csrf
                @method('PUT')

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Overall Rating</label>
                    <div class="flex items-center space-x-1" id="rating-container">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="rating-star text-3xl {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors duration-200" data-rating="{{ $i }}">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ $feedback->rating }}" required>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Feedback Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">What would you like to rate?</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="type" value="service" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" {{ $feedback->type === 'service' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Service Quality</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="specialist" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" {{ $feedback->type === 'specialist' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Specialist Performance</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="general" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300" {{ $feedback->type === 'general' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">General Experience</span>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comments (Optional)</label>
                    <textarea id="comment" name="comment" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                              placeholder="Tell us about your experience...">{{ old('comment', $feedback->comment) }}</textarea>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('customer.feedback.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-blue-100 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        Update Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating-input');
    let currentRating = parseInt(ratingInput.value);

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.rating);
            ratingInput.value = currentRating;
            updateStars();
        });

        star.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.dataset.rating);
            highlightStars(hoverRating);
        });
    });

    document.getElementById('rating-container').addEventListener('mouseleave', function() {
        updateStars();
    });

    function updateStars() {
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }
});
</script>
</x-customer-layout>
