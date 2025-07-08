<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
    <div class="mb-4 sm:mb-0">
        <p class="text-sm text-gray-600">
            Showing <?php echo $offset + 1; ?>-<?php echo min($offset + $quizzesPerPage, $totalQuizzes); ?> 
            of <?php echo $totalQuizzes; ?> quiz<?php echo $totalQuizzes != 1 ? 'zes' : ''; ?>
            <?php if ($totalPages > 1): ?>
                (Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>)
            <?php endif; ?>
        </p>
    </div>
    
    <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
        <div class="flex items-center space-x-2 text-sm">
            <span class="text-gray-500">Active filters:</span>
            <?php if (!empty($searchTerm)): ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Search: "<?php echo htmlspecialchars($searchTerm); ?>"
                </span>
            <?php endif; ?>
            <?php if ($statusFilter !== 'all'): ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Status: <?php echo ucfirst($statusFilter); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>