<x-manager-layout>
    <!-- Page header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Customer Feedback</h1>
                <p class="mt-2 text-lg text-gray-600">Review and manage customer feedback</p>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg p-6 mb-6">
        <form method="GET" action="{{ route('manager.feedback.index') }}" class="space-y-4">
            <!-- Search Bar -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Search by comment content or customer name/email..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <select name="rating" id="rating" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Ratings</option>
                        @foreach($ratings as $rating)
                            <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>
                                {{ $rating }} Star{{ $rating > 1 ? 's' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">
                        Search & Filter
                    </button>
                    <a href="{{ route('manager.feedback.index') }}"
                       class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200 text-center">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Feedback List -->
    <div class="space-y-6">
        @forelse($feedback as $item)
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                @if($item->user->profile_picture_url)
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $item->user->profile_picture_url }}" alt="{{ $item->user->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-green-600">{{ substr($item->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->user->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                    @if($item->appointment)
                                        <span class="text-xs text-gray-500">
                                            for {{ $item->appointment->service->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-1 flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $i <= $item->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="text-sm text-gray-500">{{ $item->rating }}/5</span>
                                </div>

                                @if($item->comment)
                                    <p class="mt-2 text-sm text-gray-600">{{ $item->comment }}</p>
                                @endif

                                <div class="mt-2 flex items-center text-xs text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $item->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            @if($item->is_public)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Public
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Private
                                </span>
                            @endif

                            <div class="flex space-x-1">
                                <a href="{{ route('manager.feedback.show', $item) }}"
                                   class="inline-flex items-center text-green-600 hover:text-green-900 text-sm">View</a>
                                <button type="button"
                                        onclick="openDeleteModal({{ $item->id }})"
                                        class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No feedback</h3>
                <p class="mt-1 text-sm text-gray-500">No customer feedback found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($feedback->hasPages())
        <div class="mt-8">
            {{ $feedback->links() }}
        </div>
    @endif

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Feedback</h3>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to permanently delete this feedback? This action cannot be undone.</p>
            
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors duration-200">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(feedbackId) {
            document.getElementById('deleteForm').action = `/manager/feedback/${feedbackId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>

</x-manager-layout>