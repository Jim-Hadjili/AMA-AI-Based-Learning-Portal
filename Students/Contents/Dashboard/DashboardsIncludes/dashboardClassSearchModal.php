<div id="classSearchModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Modal Overlay -->
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeClassSearchModal()"></div>

        <!-- Modal Content -->
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-auto z-10 relative">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Join a Class</h3>
                    <button onclick="closeClassSearchModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Illustration -->
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-blue-600 text-2xl"></i>
                    </div>
                    <p class="text-sm text-gray-600">Enter the class code provided by your teacher to join their class.</p>
                </div>

                <!-- Error Message -->
                <div id="searchError" class="hidden bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm"></div>

                <!-- Search Form -->
                <div class="mb-6">
                    <label for="classCode" class="block text-sm font-medium text-gray-700 mb-2">Class Code</label>
                    <input
                        type="text"
                        id="classCode"
                        placeholder="Enter class code (e.g., ABC123)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end">
                    <button onclick="closeClassSearchModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200 mr-2">
                        Cancel
                    </button>
                    <button
                        id="searchButton"
                        onclick="searchAndEnrollClass()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-primary hover:bg-blue-dark rounded-lg transition-colors duration-200 flex items-center">
                        <svg id="loadingIcon" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Join Class
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>