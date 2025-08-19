<?php
// This file requires the helper functions to be loaded
// and expects a $quiz variable to be defined

// Get styling for status badge
$statusBadge = getStatusBadge($quiz['status']);

// Determine if this is an AI-generated quiz
$isAIGenerated = isset($quiz['quiz_type']) && $quiz['quiz_type'] === '1';

// Get the correct question count - for AI quizzes, we should show the original quiz's question count
$questionCount = $quiz['question_count'];
?>
<div class="quiz-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow" data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
    
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
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border <?php echo $statusBadge; ?>">
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
            <p class="text-sm text-gray-600 line-clamp-1 mb-1">
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
                    <?php echo $questionCount; ?>
                </div>
                <div class="text-xs text-gray-500 uppercase tracking-wide">
                    Question<?php echo $questionCount != 1 ? 's' : ''; ?>
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
    </div>

    <!-- Card Footer - Actions -->
    <?php include 'quiz-card-actions.php'; ?>
</div>