<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Title -->
            <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-2">Confirm Action</h3>

            <!-- Message -->
            <div class="mt-2 px-7 py-3">
                <p id="modalMessage" class="text-sm text-gray-500">Are you sure you want to proceed?</p>
            </div>

            <!-- Buttons -->
            <div class="items-center px-4 py-3">
                <div class="flex space-x-3">
                    <button id="modalCancel"
                            class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-200">
                        Cancel
                    </button>
                    <button id="modalConfirm"
                            class="flex-1 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors duration-200">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmationModal');
    const title = document.getElementById('modalTitle');
    const message = document.getElementById('modalMessage');
    const cancelBtn = document.getElementById('modalCancel');
    const confirmBtn = document.getElementById('modalConfirm');

    let confirmCallback = null;

    // Show modal function
    window.showConfirmation = function(titleText, messageText, callback) {
        title.textContent = titleText;
        message.textContent = messageText;
        confirmCallback = callback;
        modal.classList.remove('hidden');
    };

    // Hide modal function
    function hideModal() {
        modal.classList.add('hidden');
        confirmCallback = null;
    }

    // Cancel button
    cancelBtn.addEventListener('click', hideModal);

    // Confirm button
    confirmBtn.addEventListener('click', function() {
        if (confirmCallback) {
            confirmCallback();
        }
        hideModal();
    });

    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hideModal();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            hideModal();
        }
    });
});
</script>
