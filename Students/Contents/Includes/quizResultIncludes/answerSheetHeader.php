<div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
    <!-- Subtle top accent line for a touch of modern color -->
    <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

    <div class="p-6 sm:p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
            <!-- Left section: Icon, Title, Description -->
            <div class="flex flex-col sm:flex-row sm:items-start gap-4 flex-1">
                <!-- Clean, simple icon container -->
                <div class="flex-shrink-0 w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center">
                    <i class="fas fa-file-alt text-2xl text-indigo-600"></i>
                </div>

                <!-- Content section for quiz details -->
                <div class="flex-1 min-w-0">
                    <div class="mb-4">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">
                            Answer Sheet: <span class="text-indigo-700"><?php echo htmlspecialchars($quizDetails['quiz_title']); ?></span>
                        </h1>
                        <p class="text-gray-600 text-base mt-1">
                            Detailed breakdown of your answers and the correct solutions
                        </p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6 text-sm text-gray-700">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Correct: <strong class="font-semibold text-green-600"><?php echo $correct_answers_count; ?></strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            <span>Incorrect: <strong class="font-semibold text-red-600"><?php echo ($total_questions - $correct_answers_count); ?></strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-percentage text-blue-500"></i>
                            <span>Score: <strong class="font-semibold"><?php echo $percentage_score; ?>%</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right section: Retake Quiz Button (if applicable) -->
            <div class="flex-shrink-0 lg:ml-6 mt-4 lg:mt-0">
                <?php if (!$has_passed && $quizAttempt['allow_retakes']): ?>
                    <div class="flex items-center space-x-3">
                        <a href="quizPage.php?quiz_id=<?php echo htmlspecialchars($quiz_id); ?>"
                           class="bg-white hover:bg-orange-500 hover:text-white text-gray-700 px-5 py-2 rounded-xl flex items-center text-base font-semibold transition-all duration-200 shadow-md hover:shadow-lg border-2 border-orange-500 quiz-navigation-link focus:ring-2 focus:ring-orange-300">
                            <i class="fas fa-redo-alt mr-2"></i>
                            Retake Quiz
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>