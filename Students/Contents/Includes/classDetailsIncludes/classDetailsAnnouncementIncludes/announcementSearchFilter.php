<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <div class="h-1 bg-amber-400"></div>
    <form id="filterForm" method="get" class="flex flex-col md:flex-row gap-3 md:gap-4 items-stretch bg-white rounded-2xl shadow-sm px-5 py-6 border border-gray-100">

        <!-- Pinned Filter Dropdown -->
        <div class="relative w-full md:w-44 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-thumbtack text-amber-400 text-base"></i>
            </span>
            <select name="filterPinned" id="filterPinned"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="" <?php if ($filterPinned == '') echo 'selected'; ?>>All</option>
                <option value="pinned" <?php if ($filterPinned == 'pinned') echo 'selected'; ?>>Pinned Only</option>
                <option value="unpinned" <?php if ($filterPinned == 'unpinned') echo 'selected'; ?>>Unpinned Only</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative w-full md:w-48 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-sort text-amber-400 text-base"></i>
            </span>
            <select name="sort" id="sortAnnouncements"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="" <?php if ($sort == '') echo 'selected'; ?>>All</option>
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
                <i class="fas fa-search text-amber-400 text-base"></i>
            </span>
            <input type="text" id="announcementSearch" name="search" placeholder="Search announcements..." autocomplete="off"
                class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm transition font-medium"
                style="height: 50px;"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
        <input type="hidden" name="page" value="1">
    </form>
</div>