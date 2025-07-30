<div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
    <form id="filterForm" method="get" class="flex gap-2 flex-wrap w-full">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
        <input type="hidden" name="page" value="1">
        <select name="status" id="quizStatus" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($status == '' || $status == 'all') echo 'selected'; ?>>All Status</option>
            <option value="published" <?php if ($status == 'published') echo 'selected'; ?>>Published</option>
            <option value="draft" <?php if ($status == 'draft') echo 'selected'; ?>>Draft</option>
        </select>
        <select name="timeLimit" id="quizTimeLimit" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($timeLimit == '' || $timeLimit == 'all') echo 'selected'; ?>>All Time Limits</option>
            <option value="timed" <?php if ($timeLimit == 'timed') echo 'selected'; ?>>Timed Only</option>
            <option value="none" <?php if ($timeLimit == 'none') echo 'selected'; ?>>No Time Limit</option>
        </select>
        <select name="sort" id="sortQuizzes" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" onchange="document.getElementById('filterForm').submit()">
            <option value="all" <?php if ($sort == '' || $sort == 'all') echo 'selected'; ?>>All</option>
            <option value="newest" <?php if ($sort == 'newest') echo 'selected'; ?>>Newest to Oldest</option>
            <option value="oldest" <?php if ($sort == 'oldest') echo 'selected'; ?>>Oldest to Newest</option>
            <option value="az" <?php if ($sort == 'az') echo 'selected'; ?>>A - Z (Title)</option>
            <option value="za" <?php if ($sort == 'za') echo 'selected'; ?>>Z - A (Title)</option>
        </select>
    </form>
</div>

<div class="mb-4">
    <input type="text" id="quizSearch" placeholder="Search quizzes..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 transition" />
</div>