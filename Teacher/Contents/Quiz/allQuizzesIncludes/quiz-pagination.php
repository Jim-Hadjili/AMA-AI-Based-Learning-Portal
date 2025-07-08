<div class="bg-white border border-gray-400 rounded-lg p-6 shadow-sm">
    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
        <!-- Pagination Info -->
        <div class="text-sm text-gray-600">
            Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?> 
            (<?php echo $totalQuizzes; ?> total quiz<?php echo $totalQuizzes != 1 ? 'zes' : ''; ?>)
        </div>
        
        <!-- Pagination Buttons -->
        <div class="flex items-center space-x-1">
            <!-- Previous Button -->
            <?php if ($currentPage > 1): ?>
                <a href="<?php echo buildUrl($currentPage - 1); ?>" 
                   class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-chevron-left mr-1"></i>
                    <span class="hidden sm:inline">Previous</span>
                </a>
            <?php else: ?>
                <button disabled 
                        class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-l-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-1"></i>
                    <span class="hidden sm:inline">Previous</span>
                </button>
            <?php endif; ?>
            
            <!-- Page Numbers -->
            <div class="hidden md:flex">
                <?php
                $startPage = max(1, $currentPage - 2);
                $endPage = min($totalPages, $currentPage + 2);
                
                // Show first page if not in range
                if ($startPage > 1): ?>
                    <a href="<?php echo buildUrl(1); ?>" 
                       class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                        1
                    </a>
                    <?php if ($startPage > 2): ?>
                        <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300">
                            ...
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Page range -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php if ($i == $currentPage): ?>
                        <button class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border-t border-b border-blue-600 focus:ring-2 focus:ring-blue-500">
                            <?php echo $i; ?>
                        </button>
                    <?php else: ?>
                        <a href="<?php echo buildUrl($i); ?>" 
                           class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                            <?php echo $i; ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <!-- Show last page if not in range -->
                <?php if ($endPage < $totalPages): ?>
                    <?php if ($endPage < $totalPages - 1): ?>
                        <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300">
                            ...
                        </span>
                    <?php endif; ?>
                    <a href="<?php echo buildUrl($totalPages); ?>" 
                       class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                        <?php echo $totalPages; ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Page Info -->
            <div class="md:hidden inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300">
                <?php echo $currentPage; ?> / <?php echo $totalPages; ?>
            </div>
            
            <!-- Next Button -->
            <?php if ($currentPage < $totalPages): ?>
                <a href="<?php echo buildUrl($currentPage + 1); ?>" 
                   class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 transition-colors">
                    <span class="hidden sm:inline">Next</span>
                    <i class="fas fa-chevron-right ml-1"></i>
                </a>
            <?php else: ?>
                <button disabled 
                        class="pagination-btn inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-r-lg cursor-not-allowed">
                    <span class="hidden sm:inline">Next</span>
                    <i class="fas fa-chevron-right ml-1"></i>
                </button>
            <?php endif; ?>
        </div>
        
        <!-- Quick Jump (Desktop only) -->
        <div class="hidden lg:flex items-center space-x-2">
            <span class="text-sm text-gray-600">Go to page:</span>
            <form method="GET" action="allQuizzes.php" class="flex items-center space-x-2">
                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                <?php if (!empty($searchTerm)): ?>
                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <?php endif; ?>
                <?php if ($statusFilter !== 'all'): ?>
                    <input type="hidden" name="status" value="<?php echo $statusFilter; ?>">
                <?php endif; ?>
                <?php if ($sortBy !== 'newest'): ?>
                    <input type="hidden" name="sort" value="<?php echo $sortBy; ?>">
                <?php endif; ?>
                <input type="number" name="page" min="1" max="<?php echo $totalPages; ?>" 
                       value="<?php echo $currentPage; ?>"
                       class="w-16 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Go
                </button>
            </form>
        </div>
    </div>
</div>