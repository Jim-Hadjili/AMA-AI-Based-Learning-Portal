<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
        <!-- Search Bar -->
        <div class="flex-1 max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Search classes..."
                    class="search-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2">
            <button onclick="filterClasses('all')" class="filter-btn active px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                All Classes
            </button>
            <button onclick="filterClasses('active')" class="filter-btn px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Active
            </button>
            <button onclick="filterClasses('inactive')" class="filter-btn px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Inactive
            </button>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 justify-center">
            <div class="text-center flex flex-col justify-center items-center">
                <div class="text-2xl font-bold text-blue-600" id="totalClasses">
                    <?php echo count($enrolledClasses); ?>
                </div>
                <div class="text-sm text-gray-500">Total Classes</div>
            </div>
            <div class="text-center flex flex-col justify-center items-center">
                <div class="text-2xl font-bold text-green-600" id="activeClasses">
                    <?php echo count(array_filter($enrolledClasses, function ($class) {
                        return $class['status'] === 'active';
                    })); ?>
                </div>
                <div class="text-sm text-gray-500">Active</div>
            </div>
            <div class="text-center flex flex-col justify-center items-center">
                <div class="text-2xl font-bold text-yellow-600" id="pendingClasses">
                    <?php echo count(array_filter($enrolledClasses, function ($class) {
                        return $class['status'] === 'pending';
                    })); ?>
                </div>
                <div class="text-sm text-gray-500">Pending</div>
            </div>
            <div class="flex flex-col justify-center items-center">
                <button onclick="showJoinClassModal()" class="w-xl bg-blue-primary hover:bg-blue-dark text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center mb-1">
                    <i class="fas fa-plus mr-2"></i> Join New Class
                </button>
                <div class="text-sm text-gray-500">Action</div>
            </div>
        </div>
    </div>

</div>