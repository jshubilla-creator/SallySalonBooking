@if($feedback->count() > 0)
<div class="mt-6">
    <h4 class="text-lg font-semibold text-gray-900 mb-4">Customer Reviews</h4>
    <div class="space-y-4">
        @foreach($feedback as $review)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $review->user->name }}</span>
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <p class="mt-2 text-gray-700">{{ $review->comment }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif