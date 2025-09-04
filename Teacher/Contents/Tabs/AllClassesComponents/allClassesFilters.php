<form method="GET" action="teacherAllClasses.php" class="max-w-8xl mx-auto bg-white p-8 rounded-2xl border border-gray-100 shadow-sm my-4 overflow-hidden">
    <!-- Top accent strip for consistency -->
    <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-600 mb-6"></div>
    <div class="flex flex-col md:flex-row md:items-end gap-4">
        <!-- Search Input -->
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Classes</label>
            <div class="relative">
                <input type="text" name="search" id="search"
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                       placeholder="Search by class name, code, or description...">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        <!-- Status Filter -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="status" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                <option value="all" <?php echo (isset($_GET['status']) && $_GET['status'] === 'all') ? 'selected' : ''; ?>>All</option>
                <option value="active" <?php echo (isset($_GET['status']) && $_GET['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo (isset($_GET['status']) && $_GET['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        <!-- Sort Filter -->
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
            <select name="sort" id="sort" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : ''; ?>>Newest First</option>
                <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : ''; ?>>Oldest First</option>
                <option value="name" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'name') ? 'selected' : ''; ?>>Name A-Z</option>
            </select>
        </div>
        <!-- Action Buttons -->
        <div class="flex space-x-2">
            <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:ring-2 focus:ring-purple-500 transition-colors shadow-sm">
                <i class="fas fa-search mr-2"></i>
                Filter
            </button>
            <a href="teacherAllClasses.php" class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 transition-colors">
                <i class="fas fa-times mr-2"></i>
                Clear
            </a>
        </div>
    </div>
</form>