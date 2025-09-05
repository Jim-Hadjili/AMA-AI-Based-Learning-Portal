<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
    <div class="bg-white border-b border-gray-100 px-6 py-5 flex items-center gap-3">
        <div class="p-2 bg-indigo-100 rounded-lg">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-bold text-gray-900">Filter Quizzes</h3>
            <p class="text-sm text-gray-600">Search, filter, and sort your quizzes</p>
        </div>
    </div>
    <form method="GET" action="allQuizzes.php" class="px-6 py-6">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <div class="flex flex-col lg:flex-row lg:items-end gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Quizzes</label>
                <div class="relative">
                    <input type="text" name="search" id="search" 
                        value="<?php echo htmlspecialchars($searchTerm); ?>"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                        placeholder="Search by title, topic, or description...">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All Quizzes</option>
                    <option value="published" <?php echo $statusFilter === 'published' ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?php echo $statusFilter === 'draft' ? 'selected' : ''; ?>>Drafts</option>
                </select>
            </div>
            <!-- Sort Filter -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort" id="sort" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="newest" <?php echo $sortBy === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                    <option value="oldest" <?php echo $sortBy === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                    <option value="title" <?php echo $sortBy === 'title' ? 'selected' : ''; ?>>Title A-Z</option>
                    <option value="attempts" <?php echo $sortBy === 'attempts' ? 'selected' : ''; ?>>Most Attempts</option>
                </select>
            </div>
            <!-- Action Buttons -->
            <div class="flex space-x-2">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
                <a href="<?php echo buildUrl(1, '', 'all', 'newest'); ?>" 
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Clear
                </a>
            </div>
        </div>
    </form>
</div>