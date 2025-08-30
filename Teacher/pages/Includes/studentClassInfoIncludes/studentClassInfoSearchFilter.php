<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Search & Filters</h3>
        </div>
    </div>
    <div class="p-4 bg-gray-50">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Quiz</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="quiz-search" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md" placeholder="Search by quiz title...">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
                <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                    <option value="all">All Statuses</option>
                    <option value="completed">Completed</option>
                    <option value="not-attempted">Not Attempted</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="w-full md:w-auto flex items-end">
                <button id="reset-filters" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-undo mr-2"></i> Reset
                </button>
            </div>
        </div>
    </div>
</div>