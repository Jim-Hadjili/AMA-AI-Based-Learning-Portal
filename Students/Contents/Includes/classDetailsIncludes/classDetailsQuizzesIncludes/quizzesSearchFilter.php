<div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <div class="h-1 bg-emerald-500"></div>
    <form id="filterForm" method="get" class="flex flex-col md:flex-row gap-3 md:gap-4 items-stretch bg-white rounded-2xl shadow-sm px-5 py-6 border border-gray-100">

        <!-- Status Dropdown -->
        <div class="relative w-full md:w-40 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-clipboard-check text-emerald-400 text-base"></i>
            </span>
            <select name="status" id="quizStatus"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if ($status == '' || $status == 'all') echo 'selected'; ?>>All Status</option>
                <option value="published" <?php if ($status == 'published') echo 'selected'; ?>>Published</option>
                <option value="draft" <?php if ($status == 'draft') echo 'selected'; ?>>Draft</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Time Limit Dropdown -->
        <div class="relative w-full md:w-44 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-clock text-emerald-400 text-base"></i>
            </span>
            <select name="timeLimit" id="quizTimeLimit"
                class="block w-full pl-10 pr-9 py-2.5 rounded-xl border border-gray-300 text-sm transition appearance-none text-gray-700 font-medium"
                style="height: 50px;"
                onchange="document.getElementById('filterForm').submit()">
                <option value="all" <?php if ($timeLimit == '' || $timeLimit == 'all') echo 'selected'; ?>>All Time Limits</option>
                <option value="timed" <?php if ($timeLimit == 'timed') echo 'selected'; ?>>Timed Only</option>
                <option value="none" <?php if ($timeLimit == 'none') echo 'selected'; ?>>No Time Limit</option>
            </select>
            <span class="absolute right-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative w-full md:w-48 flex items-center">
            <span class="absolute left-3 inset-y-0 flex items-center pointer-events-none">
                <i class="fas fa-sort text-emerald-400 text-base"></i>
            </span>
            <select name="sort" id="sortQuizzes"
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
                <i class="fas fa-search text-emerald-400 text-base"></i>
            </span>
            <input type="text" id="quizSearch" name="search" placeholder="Search quizzes..." autocomplete="off"
                class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm transition font-medium"
                style="height: 50px;"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
        <input type="hidden" name="page" value="1">
    </form>
</div>