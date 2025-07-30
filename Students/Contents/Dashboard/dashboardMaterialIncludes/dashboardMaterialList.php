<div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
    <?php if ($totalItems): ?>
        <ul id="materialList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            $today = date('Y-m-d');
            foreach ($paginatedMaterials as $material):
                $isNewToday = (date('Y-m-d', strtotime($material['upload_date'])) === $today);
            ?>
                <li>
                    <a href="../Pages/classDetails.php?class_id=<?php echo $material['class_id']; ?>#material-<?php echo $material['material_id']; ?>"
                        class="material-card flex items-center gap-4 bg-white hover:bg-gray-100 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-yellow-100 shadow-sm h-full">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt text-yellow-500 text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg font-semibold text-gray-800 group-hover:text-yellow-700 transition-colors duration-200 truncate flex items-center gap-2">
                                <?php echo htmlspecialchars($material['material_title']); ?>
                                <?php if ($isNewToday): ?>
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700 ml-2">New</span>
                                <?php endif; ?>
                            </div>
                            <div class="text-sm text-gray-500 mt-1 truncate">
                                <?php echo htmlspecialchars($material['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($material['upload_date'])); ?>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600 transition-colors duration-200 ml-auto"></i>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
</div>

<!-- Pagination Controls -->
<?php if ($totalPages > 1): ?>
    <div class="mt-6 flex flex-col items-center">
        <!-- Page Stats -->
        <div class="text-sm text-gray-600 mb-3">
            <span>Showing page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
            <span class="mx-2">•</span>
            <span><?php echo $totalItems; ?> total materials</span>
        </div>
        <!-- Pagination Controls -->
        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
            <!-- Previous Page -->
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>"
                    class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors duration-150 ease-in-out">
                    <i class="fas fa-chevron-left mr-2 text-xs"></i>
                    <span>Previous</span>
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-2 text-xs"></i>
                    <span>Previous</span>
                </span>
            <?php endif; ?>

            <!-- Page Numbers - Desktop View -->
            <div class="hidden md:flex">
                <?php
                $startPage = max(1, min($page - 2, $totalPages - 4));
                $endPage = min($totalPages, max(5, $page + 2));

                if ($startPage > 1): ?>
                    <a href="?page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
                        1
                    </a>
                    <?php if ($startPage > 2): ?>
                        <span class="relative inline-flex items-center px-3 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-500">
                            <span class="text-gray-400">•••</span>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-yellow-100 text-sm font-bold text-yellow-700">
                            <?php echo $i; ?>
                        </span>
                    <?php else: ?>
                        <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
                            <?php echo $i; ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($endPage < $totalPages): ?>
                    <?php if ($endPage < $totalPages - 1): ?>
                        <span class="relative inline-flex items-center px-3 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-500">
                            <span class="text-gray-400">•••</span>
                        </span>
                    <?php endif; ?>
                    <a href="?page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
                        <?php echo $totalPages; ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Compact Mobile View -->
            <div class="md:hidden flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm">
                <span class="font-medium text-gray-700">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
            </div>

            <!-- Next Page -->
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>"
                    class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors duration-150 ease-in-out">
                    <span>Next</span>
                    <i class="fas fa-chevron-right ml-2 text-xs"></i>
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center px-4 py-2.5 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed">
                    <span>Next</span>
                    <i class="fas fa-chevron-right ml-2 text-xs"></i>
                </span>
            <?php endif; ?>
        </nav>
    </div>
<?php endif; ?>
<?php else: ?>
    <div class="text-center text-gray-500 py-12">
        <i class="fas fa-file-alt text-5xl mb-4 text-gray-400"></i>
        <div class="text-lg font-medium">No materials found.</div>
        <p class="mt-2 text-gray-500 text-sm">It looks like there are no learning materials available for your classes yet.</p>
    </div>
<?php endif; ?>