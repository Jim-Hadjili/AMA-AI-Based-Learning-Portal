<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <div class="h-1 bg-violet-500"></div>
    <form id="filterForm" method="get" class="flex flex-col md:flex-row gap-3 md:gap-4 items-stretch bg-white rounded-2xl shadow-sm px-5 py-6 border border-gray-100">

        <!-- File Type Dropdown -->
        <div class="relative w-full md:w-44 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-file-alt text-violet-400 text-base"></i>
            </span>
            <select name="fileType" id="fileType"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if ($fileType == '' || $fileType == 'all') echo 'selected'; ?>>All Types</option>
                <option value="pdf" <?php if ($fileType == 'pdf') echo 'selected'; ?>>PDF</option>
                <option value="word" <?php if ($fileType == 'word') echo 'selected'; ?>>Word</option>
                <option value="ppt" <?php if ($fileType == 'ppt') echo 'selected'; ?>>PowerPoint</option>
                <option value="excel" <?php if ($fileType == 'excel') echo 'selected'; ?>>Excel</option>
                <option value="image" <?php if ($fileType == 'image') echo 'selected'; ?>>Image</option>
                <option value="video" <?php if ($fileType == 'video') echo 'selected'; ?>>Video</option>
                <option value="audio" <?php if ($fileType == 'audio') echo 'selected'; ?>>Audio</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative w-full md:w-48 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-sort text-violet-400 text-base"></i>
            </span>
            <select name="sort" id="sortMaterials"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if ($sort == '' || $sort == 'all') echo 'selected'; ?>>All</option>
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
                <i class="fas fa-search text-violet-400 text-base"></i>
            </span>
            <input type="text" id="materialSearch" name="search" placeholder="Search materials..." autocomplete="off"
                class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm transition font-medium"
                style="height: 50px;"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
        <input type="hidden" name="page" value="1">
    </form>
</div>