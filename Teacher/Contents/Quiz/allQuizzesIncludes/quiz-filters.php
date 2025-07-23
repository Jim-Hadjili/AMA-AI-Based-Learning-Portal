<form method="GET" action="allQuizzes.php" class="max-w-8xl mx-auto bg-white p-8 rounded-2xl border border-gray-100 shadow-sm mb-6 overflow-hidden">
    <!-- Top accent strip for consistency -->
    <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-600 mb-6"></div>
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
                <option value="archived" <?php echo $statusFilter === 'archived' ? 'selected' : ''; ?>>Archived</option>
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
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
                <i class="fas fa-search mr-2"></i>
                Filter
            </button>
            <a href="<?php echo buildUrl(1, '', 'all', 'newest'); ?>" 
               class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 transition-colors">
                <i class="fas fa-times mr-2"></i>
                Clear
            </a>
        </div>
    </div>
</form>