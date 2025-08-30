<div class="bg-white rounded-lg shadow-md border border-gray-200 px-6 py-5 mb-6 flex flex-col md:flex-row gap-5 items-center">
    <!-- Search Input -->
    <div class="w-full md:w-1/2 relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </div>
        <input id="studentSearch" type="text" placeholder="Search student name or email..." 
               class="w-full pl-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm" />
        <label for="studentSearch" class="text-xs text-gray-500 absolute -top-2 left-2 bg-white px-1">Search Students</label>
    </div>
    
    <!-- Class Filter Dropdown -->
    <div class="w-full md:w-1/3 relative">
        <label for="classFilter" class="text-xs text-gray-500 absolute -top-2 left-2 bg-white px-1">Filter by Class</label>
        <select id="classFilter" class="w-full px-3 py-3 border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all duration-200 shadow-sm">
            <option value="">All Classes</option>
            <?php if (isset($classNames) && is_array($classNames)): ?>
                <?php foreach ($classNames as $cid => $cname): ?>
                    <option value="<?php echo htmlspecialchars($cid); ?>"><?php echo htmlspecialchars($cname); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
    
    <!-- Reset Button -->
    <button id="resetFilters" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all duration-200 flex items-center gap-2 border border-gray-300 shadow-sm hover:shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
        </svg>
        Reset Filters
    </button>
</div>