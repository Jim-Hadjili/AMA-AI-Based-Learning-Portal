<div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
    <input type="text" id="announcementSearch" placeholder="Search announcements..." class="search-bar w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-200 transition" />
    <form id="filterForm" method="get" class="flex gap-2 flex-wrap">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
        <input type="hidden" name="page" value="1">
        <select name="filterPinned" id="filterPinned" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" onchange="document.getElementById('filterForm').submit()">
            <option value="" <?php if ($filterPinned == '') echo 'selected'; ?>>All</option>
            <option value="pinned" <?php if ($filterPinned == 'pinned') echo 'selected'; ?>>Pinned Only</option>
            <option value="unpinned" <?php if ($filterPinned == 'unpinned') echo 'selected'; ?>>Unpinned Only</option>
        </select>
        <select name="sort" id="sortAnnouncements" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" onchange="document.getElementById('filterForm').submit()">
            <option value="" <?php if ($sort == '') echo 'selected'; ?>>All</option>
            <option value="newest" <?php if ($sort == 'newest') echo 'selected'; ?>>Newest to Oldest</option>
            <option value="oldest" <?php if ($sort == 'oldest') echo 'selected'; ?>>Oldest to Newest</option>
            <option value="az" <?php if ($sort == 'az') echo 'selected'; ?>>A - Z (Title)</option>
            <option value="za" <?php if ($sort == 'za') echo 'selected'; ?>>Z - A (Title)</option>
        </select>
    </form>
</div>