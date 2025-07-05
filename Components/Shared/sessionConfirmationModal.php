<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <i id="modal-icon" class="fas fa-exclamation-triangle text-amber-500 text-4xl mb-4"></i>
            <h3 id="modal-title" class="text-xl font-semibold text-gray-800 mb-2">Confirm Action</h3>
            <p id="modal-message" class="text-gray-600 mb-6">Are you sure you want to continue? This action will end your session.</p>
            
            <div class="flex space-x-3 justify-center">
                <button id="modal-cancel" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                    Cancel
                </button>
                <button id="modal-confirm" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>