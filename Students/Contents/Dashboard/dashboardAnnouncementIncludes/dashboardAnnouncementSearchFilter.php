<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <div class="h-1 bg-red-500"></div>
    <form id="filterForm" method="get" class="flex flex-col md:flex-row gap-3 md:gap-4 items-stretch bg-white rounded-2xl shadow-sm px-5 py-6 border border-gray-100">
        <!-- Class Filter Dropdown -->
        <div class="relative w-full md:w-56 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-layer-group text-red-400 text-base"></i>
            </span>
            <select name="class_id_filter" id="class_id_filter"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-600 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if ($classFilter == '' || $classFilter == 'all') echo 'selected'; ?>>All Classes</option>
                <?php foreach ($classList as $class): ?>
                    <option value="<?php echo $class['class_id']; ?>" <?php if ($classFilter == $class['class_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($class['class_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative w-full md:w-48 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-sort text-red-400 text-base"></i>
            </span>
            <select name="sort" id="sortAnnouncements"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-600 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if ($sort == '' || $sort == 'all') echo 'selected'; ?>>Sort: All</option>
                <option value="newest" <?php if ($sort == 'newest') echo 'selected'; ?>>Newest to Oldest</option>
                <option value="oldest" <?php if ($sort == 'oldest') echo 'selected'; ?>>Oldest to Newest</option>
                <option value="az" <?php if ($sort == 'az') echo 'selected'; ?>>A - Z (Title)</option>
                <option value="za" <?php if ($sort == 'za') echo 'selected'; ?>>Z - A (Title)</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Search Bar -->
        <div class="relative flex-1 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-search text-red-400 text-base"></i>
            </span>
            <input type="text" id="announcementSearch" placeholder="Search announcements..." autocomplete="off"
                class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-600 text-sm transition font-medium"
                style="height: 50px;"
            />
        </div>
    </form>
</div>
