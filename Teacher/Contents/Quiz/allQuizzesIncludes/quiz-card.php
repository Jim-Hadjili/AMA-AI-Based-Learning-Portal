<div class="quiz-card bg-white rounded-lg border border-gray-400 shadow-sm hover:shadow-md transition-all duration-200 hover:border-blue-200">
    <!-- Card Header -->
    <div class="p-5 border-b border-gray-100">
        <div class="flex items-start justify-between mb-3">
            <div class="flex-1 min-w-0">
                <h4 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                    <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                </h4>
                <?php if (!empty($quiz['quiz_topic'])): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                        <i class="fas fa-tag mr-1"></i>
                        <?php echo htmlspecialchars($quiz['quiz_topic']); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Status Badge -->
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border <?php echo getStatusBadge($quiz['status']); ?>">
                <?php if ($quiz['status'] === 'published'): ?>
                    <i class="fas fa-globe mr-1"></i>
                <?php elseif ($quiz['status'] === 'draft'): ?>
                    <i class="fas fa-edit mr-1"></i>
                <?php else: ?>
                    <i class="fas fa-archive mr-1"></i>
                <?php endif; ?>
                <?php echo ucfirst($quiz['status']); ?>
            </span>
        </div>
        
        <!-- Description -->
        <?php if (!empty($quiz['quiz_description'])): ?>
            <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                <?php echo htmlspecialchars($quiz['quiz_description']); ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Card Body - Stats -->
    <div class="p-5">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <!-- Questions Count -->
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    <?php echo $quiz['question_count']; ?>
                </div>
                <div class="text-xs text-gray-500 uppercase tracking-wide">
                    Question<?php echo $quiz['question_count'] != 1 ? 's' : ''; ?>
                </div>
            </div>
            
            <!-- Attempts Count -->
            <div class="text-center p-3 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    <?php echo $quiz['attempt_count']; ?>
                </div>
                <div class="text-xs text-gray-500 uppercase tracking-wide">
                    Attempt<?php echo $quiz['attempt_count'] != 1 ? 's' : ''; ?>
                </div>
            </div>
        </div>

        <!-- Quiz Details -->
        <?php include 'quiz-card-details.php'; ?>

        <!-- Creation Date -->
        <div class="text-xs text-gray-500 mb-4 flex items-center">
            <i class="fas fa-calendar mr-2"></i>
            Created <?php echo date('M j, Y', strtotime($quiz['created_at'])); ?>
        </div>
    </div>

    <!-- Card Footer - Actions -->
    <?php include 'quiz-card-actions.php'; ?>
</div>