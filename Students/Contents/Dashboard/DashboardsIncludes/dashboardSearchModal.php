<div id="studentSearchClassModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl p-0 w-full max-w-xl transform transition-all duration-300 scale-100 opacity-100 modal-content">
        <!-- Header -->
        <div class="flex justify-between items-center px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-2xl">
            <h3 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                <i class="fas fa-search text-blue-500"></i>
                Search Enrolled Classes
            </h3>
            <button onclick="closeStudentSearchModal()" class="text-gray-400 hover:text-blue-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <!-- Input -->
        <div class="relative px-8 py-6 bg-white">
            <input
                autocomplete="off"
                type="text"
                id="studentClassSearchInput"
                placeholder="Type class name..."
                class="w-full pl-12 pr-6 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent text-base shadow-sm transition-all"
            >
            <i class="fas fa-search absolute left-12 top-1/2 transform -translate-y-1/2 text-blue-300 text-lg"></i>
        </div>
        <!-- Results -->
        <div id="studentSearchResults" class="max-h-80 overflow-y-auto border-t border-gray-100 px-8 py-6 bg-white rounded-b-2xl">
            <div class="p-4 text-center text-gray-400 text-base">Start typing to search for your classes.</div>
        </div>
    </div>
</div>