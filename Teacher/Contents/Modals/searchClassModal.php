<!-- Search Class Modal -->
<div id="searchClassModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0 modal-content">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Search Classes</h3>
            <button onclick="closeSearchModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="relative mb-6">
            <input
                autocomplete="off"
                type="text"
                id="classSearchInput"
                placeholder="Search by class name..."
                class="w-full pl-12 pr-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-primary focus:border-transparent text-lg"
            >
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
        </div>
        <div id="searchResults" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
            <!-- Search results will be displayed here -->
            <div class="p-6 text-center text-gray-500 text-lg">Start typing to search for classes.</div>
        </div>
    </div>
</div>
