<div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
    <form id="filterForm" method="get" class="flex gap-2 flex-wrap w-full">
        <select name="class_id_filter" id="class_id_filter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($classFilter == '' || $classFilter == 'all') echo 'selected'; ?>>All Classes</option>
            <?php foreach ($classList as $class): ?>
                <option value="<?php echo $class['class_id']; ?>" <?php if ($classFilter == $class['class_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($class['class_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="sort" id="sortQuizResults" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($sort == '' || $sort == 'all') echo 'selected'; ?>>All</option>
            <option value="newest" <?php if ($sort == 'newest') echo 'selected'; ?>>Newest to Oldest</option>
            <option value="oldest" <?php if ($sort == 'oldest') echo 'selected'; ?>>Oldest to Newest</option>
            <option value="az" <?php if ($sort == 'az') echo 'selected'; ?>>A - Z (Quiz Title)</option>
            <option value="za" <?php if ($sort == 'za') echo 'selected'; ?>>Z - A (Quiz Title)</option>
            <option value="class_az" <?php if ($sort == 'class_az') echo 'selected'; ?>>Class A - Z</option>
            <option value="class_za" <?php if ($sort == 'class_za') echo 'selected'; ?>>Class Z - A</option>
        </select>
    </form>
</div>

<!-- Search Bar -->
<div class="mb-4">
    <input type="text" id="quizResultSearch" placeholder="Search quiz results..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-200 transition" />
</div>