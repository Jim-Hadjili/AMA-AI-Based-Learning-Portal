<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <div class="h-1 bg-blue-500"></div>
    <form id="filterForm" method="get" class="flex flex-col lg:flex-row gap-3 lg:gap-4 items-stretch bg-white rounded-2xl shadow-sm px-6 py-6 border-0">
        <!-- Status Dropdown -->
        <div class="relative w-full lg:w-40 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-clipboard-check text-blue-400 text-base"></i>
            </span>
            <select name="status" id="classStatus"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if (!isset($_GET['status']) || $_GET['status'] == 'all') echo 'selected'; ?>>All Status</option>
                <option value="active" <?php if (isset($_GET['status']) && $_GET['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if (isset($_GET['status']) && $_GET['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                <option value="pending" <?php if (isset($_GET['status']) && $_GET['status'] == 'pending') echo 'selected'; ?>>Pending</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative w-full lg:w-48 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-sort text-blue-400 text-base"></i>
            </span>
            <select name="sort" id="sortClasses"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="recent" <?php if (!isset($_GET['sort']) || $_GET['sort'] == 'recent') echo 'selected'; ?>>Most Recent</option>
                <option value="az" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'az') echo 'selected'; ?>>A - Z</option>
                <option value="za" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'za') echo 'selected'; ?>>Z - A</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Search Bar -->
        <div class="relative flex-1 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-search text-blue-400 text-base"></i>
            </span>
            <input type="text" id="searchInput" name="search" placeholder="Search classes..." autocomplete="off"
                class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm transition font-medium"
                style="height: 50px;"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="page" value="1">
    </form>

    <!-- Stats Summary -->
    <div class="px-6 pb-6">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <!-- Total Classes -->
            <div class="flex flex-col items-center justify-center bg-gray-50 rounded-xl py-4">
                <div class="text-2xl font-bold text-blue-600" id="totalClasses">
                    <?php echo count($enrolledClasses); ?>
                </div>
                <div class="text-sm text-gray-500 mt-1">Total Classes</div>
            </div>
            <!-- Active -->
            <div class="flex flex-col items-center justify-center bg-gray-50 rounded-xl py-4">
                <div class="text-2xl font-bold text-green-600" id="activeClasses">
                    <?php echo count(array_filter($enrolledClasses, function ($class) {
                        return $class['status'] === 'active';
                    })); ?>
                </div>
                <div class="text-sm text-gray-500 mt-1">Active</div>
            </div>
            <!-- Inactive -->
            <div class="flex flex-col items-center justify-center bg-gray-50 rounded-xl py-4">
                <div class="text-2xl font-bold text-gray-500" id="inactiveClasses">
                    <?php echo count(array_filter($enrolledClasses, function ($class) {
                        return $class['status'] === 'inactive';
                    })); ?>
                </div>
                <div class="text-sm text-gray-500 mt-1">Inactive</div>
            </div>
            <!-- Join New Class Button -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-center bg-gray-50 rounded-xl py-4">
                <div class="mt-4 md:mt-0">
                    <button onclick="showJoinClassModal()" type="button"
                        class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <div class="font-semibold">Find a Class</div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>