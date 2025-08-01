<div id="confirmJoinModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-0 relative">
        <!-- Accent Bar -->
        <div class="h-2 bg-gradient-to-r from-blue-400 to-blue-600 rounded-t-2xl"></div>
        <!-- Modal Content -->
        <div class="p-6">
            <button id="closeConfirmJoinModal" class="absolute top-4 right-4 text-gray-400 hover:text-blue-600 text-2xl rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300">
                &times;
            </button>
            <h2 class="text-xl font-bold mb-4 text-blue-900 flex items-center gap-2">
                <i class="fas fa-user-check text-blue-500"></i>
                Confirm Enrollment
            </h2>
            <p class="text-gray-700 mb-6">Are you sure you want to join "<span id="confirmClassName" class="font-semibold"></span>"?</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelJoinBtn" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                    Cancel
                </button>
                <button id="confirmJoinBtn" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 font-medium shadow">
                    <i class="fas fa-check mr-1"></i> Yes, Join Class
                </button>
            </div>
        </div>
    </div>
</div>