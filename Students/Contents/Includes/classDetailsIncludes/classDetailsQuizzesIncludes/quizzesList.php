<div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
    <?php if (empty($paginatedQuizzes)): ?>
        <div class="text-center text-gray-500 py-12">
            <i class="fas fa-clipboard-list text-5xl mb-4 text-gray-400"></i>
            <div class="text-lg font-medium">No quizzes found for this class.</div>
            <p class="mt-2 text-gray-500 text-sm">It looks like there are no quizzes available for this class yet.</p>
        </div>
    <?php else: ?>
        <ul id="quizList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($paginatedQuizzes as $quiz): ?>
                <li>
                    <div class="quiz-card flex flex-col h-full bg-white hover:bg-emerald-50 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-emerald-400 shadow-sm cursor-pointer"
                        onclick="showQuizDetailsModal(<?php echo htmlspecialchars(json_encode($quiz)); ?>)"
                        data-student-attempt='<?php echo htmlspecialchars(json_encode($quiz['student_attempt'] ?? null)); ?>'>
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-clipboard-list text-emerald-500 text-xl"></i>
                            <span class="text-xs text-gray-400"><?php echo date('M d, Y', strtotime($quiz['created_at'])); ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg font-semibold text-gray-800 group-hover:text-emerald-700 transition-colors duration-200 truncate">
                                <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                            </div>
                            <div class="text-sm text-gray-500 mt-1 truncate">
                                <?php echo htmlspecialchars(substr($quiz['quiz_description'] ?? 'No description', 0, 100)) . (strlen($quiz['quiz_description'] ?? '') > 100 ? '...' : ''); ?>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs mt-3">
                            <div class="flex items-center gap-1 text-gray-600 bg-white px-2 py-1 rounded-lg">
                                <i class="fas fa-clock text-emerald-400"></i>
                                <span><?php echo $quiz['time_limit']; ?> min</span>
                            </div>
                            <span class="px-3 py-1 rounded-full font-medium <?php echo $quiz['status'] === 'published' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200'; ?>">
                                <?php echo ucfirst($quiz['status']); ?>
                            </span>
                            <span class="px-3 py-1 rounded-full font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                <?php echo $quiz['total_questions'] ?? 0; ?> Questions
                            </span>
                            <span class="px-3 py-1 rounded-full font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                <?php echo $quiz['total_score'] ?? 0; ?> Points
                            </span>
                        </div>
                        <?php if ($user_position === 'student' && !empty($quiz['student_attempt'])): ?>
                            <div class="mt-3 text-xs text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">
                                Last Attempt: <?php echo htmlspecialchars($quiz['student_attempt']['result']); ?> (<?php echo $quiz['student_attempt']['score']; ?> pts)
                            </div>
                        <?php endif; ?>
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
            <span><?php echo $totalItems; ?> total quizzes</span>
        </div>
        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
            <!-- Previous Page -->
            <?php if ($page > 1): ?>
                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page - 1; ?>"
                    class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-150 ease-in-out">
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
                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
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
                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-emerald-100 text-sm font-bold text-emerald-700">
                            <?php echo $i; ?>
                        </span>
                    <?php else: ?>
                        <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
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
                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
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
                    class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-150 ease-in-out">
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