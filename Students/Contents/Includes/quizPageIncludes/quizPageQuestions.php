<form id="quizForm" action="../../Functions/submitQuiz.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quizDetails['quiz_id']); ?>">
    
    <?php if (empty($quizQuestions)): ?>
        <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Questions Available</h3>
            <p class="text-gray-500">No questions found for this quiz.</p>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($quizQuestions as $index => $question): ?>
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <!-- Question Header -->
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-medium text-sm">
                            <?php echo $index + 1; ?>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                <?php echo htmlspecialchars($question['question_text']); ?>
                            </h3>
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded">
                                <?php echo $question['question_points']; ?> point<?php echo $question['question_points'] != 1 ? 's' : ''; ?>
                            </span>
                        </div>
                    </div>

                    <!-- Question Options -->
                    <div class="space-y-3">
                        <?php if ($question['question_type'] === 'multiple-choice'): ?>
                            <?php foreach ($question['options'] as $option): ?>
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo htmlspecialchars($option['option_id']); ?>" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                </label>
                            <?php endforeach; ?>

                        <?php elseif ($question['question_type'] === 'checkbox'): ?>
                            <?php foreach ($question['options'] as $option): ?>
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="answer[<?php echo $question['question_id']; ?>][]" value="<?php echo htmlspecialchars($option['option_id']); ?>" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                </label>
                            <?php endforeach; ?>

                        <?php elseif ($question['question_type'] === 'true-false'): ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="true" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700 font-medium">True</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="false" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700 font-medium">False</span>
                                </label>
                            </div>

                        <?php elseif ($question['question_type'] === 'short-answer'): ?>
                            <textarea 
                                name="answer[<?php echo $question['question_id']; ?>]" 
                                rows="4" 
                                class="w-full p-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none"
                                placeholder="Type your answer here..."
                            ></textarea>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-8">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Submit Quiz
            </button>
        </div>
    <?php endif; ?>
</form>