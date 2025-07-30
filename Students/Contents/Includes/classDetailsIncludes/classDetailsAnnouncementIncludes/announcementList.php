<div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
    <?php if (empty($paginatedAnnouncements)): ?>
        <div class="text-center text-gray-500 py-12">
            <i class="fas fa-bullhorn text-5xl mb-4 text-gray-400"></i>
            <div class="text-lg font-medium">No announcements found for this class.</div>
            <p class="mt-2 text-gray-500 text-sm">It looks like there are no announcements available for this class yet.</p>
        </div>
    <?php else: ?>
        <ul id="announcementList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($paginatedAnnouncements as $announcement): ?>
                <li data-title="<?php echo htmlspecialchars(strtolower($announcement['title'])); ?>"
                    data-content="<?php echo htmlspecialchars(strtolower($announcement['content'])); ?>"
                    data-date="<?php echo htmlspecialchars($announcement['created_at']); ?>"
                    data-pinned="<?php echo $announcement['is_pinned'] ? 'pinned' : 'unpinned'; ?>">
                    <div class="announcement-card group cursor-pointer relative p-5 border rounded-xl transition-all duration-200
                                <?php echo $announcement['is_pinned'] ? 'border-amber-400 ring-2 ring-amber-200 shadow-lg' : 'border-amber-400 shadow-lg hover:border-amber-600'; ?>"
                        style="background: none;"
                        onclick="showAnnouncementModal(<?php echo htmlspecialchars(json_encode($announcement)); ?>)">
                        <?php if ($announcement['is_pinned']): ?>
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-amber-400 to-orange-400 rounded-l-xl"></div>
                        <?php endif; ?>
                        <div class="flex items-start justify-between <?php echo $announcement['is_pinned'] ? 'pl-3' : ''; ?>">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="font-semibold text-gray-900 truncate group-hover:text-amber-900">
                                        <?php echo htmlspecialchars($announcement['title']); ?>
                                    </h3>
                                    <?php if ($announcement['is_pinned']): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-300 ml-1">
                                            <i class="fas fa-thumbtack mr-1 text-amber-500"></i> Pinned
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-sm text-gray-800 mt-1 line-clamp-3 break-words mb-3"><?php echo htmlspecialchars(substr($announcement['content'], 0, 150)) . (strlen($announcement['content']) > 150 ? '...' : ''); ?></p>
                                <div class="flex items-center gap-2 text-xs text-gray-600 bg-white/80 px-2 py-1 rounded-lg w-fit shadow">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span><?php echo date('M j, Y', strtotime($announcement['created_at'])); ?></span>
                                </div>
                            </div>
                            <div class="ml-4 w-10 h-10 rounded-xl bg-white flex items-center justify-center group-hover:bg-amber-100 transition-colors shadow-sm">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
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
            <span><?php echo $totalItems; ?> total announcements</span>
        </div>
        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
            <!-- Previous Page -->
            <?php if ($page > 1): ?>
                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page - 1; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>"
                    class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors duration-150 ease-in-out">
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
                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=1&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
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
                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-amber-100 text-sm font-bold text-amber-700">
                            <?php echo $i; ?>
                        </span>
                    <?php else: ?>
                        <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $i; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
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
                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $totalPages; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
                        <?php echo $totalPages; ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Next Page -->
            <?php if ($page < $totalPages): ?>
                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page + 1; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>"
                    class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors duration-150 ease-in-out">
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