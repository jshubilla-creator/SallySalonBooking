@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 p-3 rounded-md border border-green-200 session-message']) }} data-type="status">
        {{ $status }}
    </div>
    <script>
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
    </script>
@endif
