<!-- Search Class Modal -->
<div id="searchClassModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-0 transform transition-all duration-300 scale-100 opacity-100 modal-content">
        <!-- Header -->
        <div class="flex justify-between items-center px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h3 class="text-2xl font-bold text-purple-900 flex items-center gap-2">
                <i class="fas fa-search text-purple-500"></i>
                Search Classes
            </h3>
            <button onclick="closeSearchModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <!-- Input -->
        <div class="relative px-8 py-6 bg-white">
            <input
                autocomplete="off"
                type="text"
                id="classSearchInput"
                placeholder="Search by class name..."
                class="w-full pl-12 pr-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent text-lg shadow-sm transition-all"
            >
            <i class="fas fa-search absolute left-12 top-1/2 transform -translate-y-1/2 text-purple-300 text-xl"></i>
        </div>
        <!-- Results -->
        <div id="searchResults" class="max-h-96 overflow-y-auto border-t border-gray-100 px-8 py-6 bg-white rounded-b-2xl">
            <div class="p-6 text-center text-gray-400 text-lg">Start typing to search for classes.</div>
        </div>
    </div>
</div>
