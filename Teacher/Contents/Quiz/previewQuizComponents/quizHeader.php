<?php
// Optionally, include subject style logic here if you want the accent/icon to match the subject
// Example (if $quiz['class_name'] is available):
// include '../includes/quiz-nav.php'; // Or copy the subject style logic here
// Then use $style['strip'], $style['icon_bg'], $style['icon_color'], $style['icon_class']
?>

<div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <!-- Top accent strip (optional: use subject color if available) -->
    <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-600"></div>
    <div class="p-8">
        <div class="flex items-start gap-5 mb-4">
            <!-- Main quiz icon (optional, or use subject icon) -->
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                <i class="fas fa-clipboard-list text-2xl text-blue-500"></i>
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                    <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                </h1>
                <?php if (!empty($quiz['quiz_description'])): ?>
                    <p class="text-gray-600 text-base mb-2 leading-relaxed">
                        <?php echo htmlspecialchars($quiz['quiz_description']); ?>
                    </p>
                <?php endif; ?>
            </div>
            
        </div>
        <div class="flex flex-wrap items-center gap-6 pt-4 border-t border-gray-100 text-sm">
            <div class="flex items-center gap-2 text-gray-700">
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-clock text-blue-500"></i>
                </div>
                <span>
                    <span class="font-medium"><?php echo $quiz['time_limit'] ? $quiz['time_limit'].' minutes' : 'No time limit'; ?></span>
                </span>
            </div>
            <div class="flex items-center gap-2 text-gray-700">
                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center">
                    <i class="fas fa-question text-green-500"></i>
                </div>
                <span>
                    <span class="font-medium"><?php echo count($questions); ?></span> Questions
                </span>
            </div>
            <div class="flex items-center gap-2 text-gray-700">
                <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-star text-purple-500"></i>
                </div>
                <span>
                    <span class="font-medium"><?php echo $totalPoints; ?></span> Points
                </span>
            </div>

            <!-- Spacer to push the edit button to the right -->
            <div class="flex-1"></div>

            <!-- Edit button and preview mode label side by side -->
            <div class="flex items-center gap-3">
                <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Quiz
                </a>
            </div>
        </div>
    </div>
</div>