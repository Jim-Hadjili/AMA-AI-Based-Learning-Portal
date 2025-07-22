quiz result link button

<!-- View Results Button -->

            <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                <a href="../Quiz/quizResults.php?quiz_id=<?php echo $quiz['quiz_id']; ?>"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Results
                </a>
            <?php endif; ?>

all quizzes

 <!-- View Results Button -->

            <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                <a href="../Quiz/quizResults.php?quiz_id=<?php echo $quiz['quiz_id']; ?>"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Results
                </a>
            <?php endif; ?>
