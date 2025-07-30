<div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
    <input type="text" id="materialSearch" placeholder="Search materials..." class="search-bar w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-200 transition" />

    <form id="filterForm" method="get" class="flex gap-2 flex-wrap">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
        <input type="hidden" name="page" value="1">
        <select name="fileType" id="fileType" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($fileType == '' || $fileType == 'all') echo 'selected'; ?>>All Types</option>
            <option value="pdf" <?php if ($fileType == 'pdf') echo 'selected'; ?>>PDF</option>
            <option value="word" <?php if ($fileType == 'word') echo 'selected'; ?>>Word</option>
            <option value="ppt" <?php if ($fileType == 'ppt') echo 'selected'; ?>>PowerPoint</option>
            <option value="excel" <?php if ($fileType == 'excel') echo 'selected'; ?>>Excel</option>
            <option value="image" <?php if ($fileType == 'image') echo 'selected'; ?>>Image</option>
            <option value="video" <?php if ($fileType == 'video') echo 'selected'; ?>>Video</option>
            <option value="audio" <?php if ($fileType == 'audio') echo 'selected'; ?>>Audio</option>
        </select>
        <select name="sort" id="sortMaterials" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($sort == '' || $sort == 'all') echo 'selected'; ?>>All</option>
            <option value="newest" <?php if ($sort == 'newest') echo 'selected'; ?>>Newest to Oldest</option>
            <option value="oldest" <?php if ($sort == 'oldest') echo 'selected'; ?>>Oldest to Newest</option>
            <option value="az" <?php if ($sort == 'az') echo 'selected'; ?>>A - Z (Title)</option>
            <option value="za" <?php if ($sort == 'za') echo 'selected'; ?>>Z - A (Title)</option>
        </select>
    </form>
</div>