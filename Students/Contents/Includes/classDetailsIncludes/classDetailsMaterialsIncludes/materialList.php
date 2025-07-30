<div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
    <?php if (empty($paginatedMaterials)): ?>
        <div class="text-center text-gray-500 py-12">
            <i class="fas fa-book text-5xl mb-4 text-gray-400"></i>
            <div class="text-lg font-medium">No materials found for this class.</div>
            <p class="mt-2 text-gray-500 text-sm">It looks like there are no learning materials available for this class yet.</p>
        </div>
    <?php else: ?>
        <ul id="materialList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($paginatedMaterials as $material): ?>
                <li>
                    <a href="materialPreview.php?material_id=<?php echo $material['material_id']; ?>"
                        class="material-card flex flex-col h-full bg-white hover:bg-violet-50 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-violet-400 shadow-sm cursor-pointer">
                        <div class="flex items-center gap-3 mb-2">
                            <?php
                            $fileTypeIcons = [
                                'pdf' => 'fa-file-pdf text-red-500',
                                'doc' => 'fa-file-word text-blue-500',
                                'docx' => 'fa-file-word text-blue-500',
                                'ppt' => 'fa-file-powerpoint text-orange-500',
                                'pptx' => 'fa-file-powerpoint text-orange-500',
                                'xls' => 'fa-file-excel text-green-500',
                                'xlsx' => 'fa-file-excel text-green-500',
                                'image' => 'fa-file-image text-purple-500',
                                'jpg' => 'fa-file-image text-purple-500',
                                'jpeg' => 'fa-file-image text-purple-500',
                                'png' => 'fa-file-image text-purple-500',
                                'gif' => 'fa-file-image text-purple-500',
                                'video' => 'fa-file-video text-pink-500',
                                'mp4' => 'fa-file-video text-pink-500',
                                'mov' => 'fa-file-video text-pink-500',
                                'avi' => 'fa-file-video text-pink-500',
                                'audio' => 'fa-file-audio text-cyan-500',
                                'mp3' => 'fa-file-audio text-cyan-500',
                                'wav' => 'fa-file-audio text-cyan-500',
                            ];
                            $ext = strtolower(pathinfo($material['file_name'], PATHINFO_EXTENSION));
                            $iconClass = isset($fileTypeIcons[$ext]) ? $fileTypeIcons[$ext] : 'fa-file text-gray-400';
                            ?>
                            <i class="fas <?php echo $iconClass; ?> text-2xl"></i>
                            <span class="text-xs text-gray-400"><?php echo date('M d, Y', strtotime($material['upload_date'])); ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg font-semibold text-gray-800 group-hover:text-violet-700 transition-colors duration-200 truncate">
                                <?php echo htmlspecialchars($material['material_title']); ?>
                            </div>
                            <div class="text-sm text-gray-500 mt-1 truncate">
                                <?php echo htmlspecialchars($material['file_name']); ?>
                            </div>
                            <div class="text-xs text-gray-400 mt-2 line-clamp-2">
                                <?php echo htmlspecialchars(substr($material['material_description'], 0, 80)) . (strlen($material['material_description']) > 80 ? '...' : ''); ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="px-3 py-1 rounded-full font-medium bg-violet-100 text-violet-700 border border-violet-200 text-xs">
                                <?php echo strtoupper($ext); ?>
                            </span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
</div>

<!-- Pagination Controls -->
<?php if ($totalPages > 1): ?>
    <div class="mt-6 flex flex-col items-center">
        <div class="text-sm text-gray-600 mb-3">
            <span>Showing page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
            <span class="mx-2">•</span>
            <span><?php echo $totalItems; ?> total materials</span>
        </div>
        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
            <!-- Previous Page -->
            <?php if ($page > 1): ?>
                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page - 1; ?>"
                    class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors duration-150 ease-in-out">
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
                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors">
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
                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-violet-100 text-sm font-bold text-violet-700">
                            <?php echo $i; ?>
                        </span>
                    <?php else: ?>
                        <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors">
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
                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors">
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
                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page + 1; ?>"
                    class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors duration-150 ease-in-out">
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
<?php endif; ?>