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
            <div class="flex flex-col items-center justify-center bg-gray-50 rounded-xl py-4">
                <button onclick="showJoinClassModal()" type="button"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Join New Class
                </button>
            </div>
        </div>
    </div>
</div>