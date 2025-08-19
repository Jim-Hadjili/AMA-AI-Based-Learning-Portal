<div class="px-5 py-4 bg-gray-50 border-t border-gray-100 rounded-b-lg">
    <div class="flex items-center justify-between">
        <div class="flex space-x-2">
            <!-- View/Edit Button -->
            <a href="../Quiz/editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
               class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 focus:ring-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-edit mr-1"></i>
                Edit
            </a>
            
            <!-- View Results Button - Fixed to include quiz_id parameter -->
            <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                <a href="../../pages/teacherQuizResult.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Results
                </a>
            <?php endif; ?>
        </div>
        
        <!-- More Actions Dropdown -->
        <div class="relative">
            <button class="quiz-menu-btn inline-flex items-center p-2 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md transition-colors" 
                    data-quiz-id="<?php echo $quiz['quiz_id']; ?>">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            
            <!-- Dropdown Menu -->
            <div class="quiz-menu hidden absolute right-0 bottom-full mb-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                <div class="py-1">
                    <?php if ($quiz['status'] === 'draft'): ?>
                        <button class="publish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                data-quiz-id="<?php echo $quiz['quiz_id']; ?>"
                                data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>"
                                data-question-count="<?php echo isset($quiz['question_count']) ? $quiz['question_count'] : 0; ?>">
                            <i class="fas fa-paper-plane mr-2 text-green-500"></i>
                            Publish Quiz
                        </button>
                    <?php elseif ($quiz['status'] === 'published'): ?>
                        <button class="unpublish-quiz-btn w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center" 
                                data-quiz-id="<?php echo $quiz['quiz_id']; ?>"
                                data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                            <i class="fas fa-pause mr-2 text-yellow-500"></i>
                            Unpublish
                        </button>
                    <?php endif; ?>
                    
                    <a href="../Quiz/previewQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                        <i class="fas fa-eye mr-2 text-purple-500"></i>
                        Preview
                    </a>
                    
                    <div class="border-t border-gray-100 my-1"></div>
                    
                    <button class="delete-quiz-btn w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center" 
                            data-quiz-id="<?php echo $quiz['quiz_id']; ?>" 
                            data-quiz-title="<?php echo htmlspecialchars($quiz['quiz_title']); ?>">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>