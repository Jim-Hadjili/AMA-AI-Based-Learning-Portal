<form id="quizForm" action="../../Functions/submitQuiz.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quizDetails['quiz_id']); ?>">
    <div class="space-y-6">
        <?php if (empty($quizQuestions)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                <i class="fas fa-exclamation-circle text-gray-400 text-3xl mb-3"></i>
                <p class="text-gray-500">No questions found for this quiz.</p>
            </div>
        <?php else: ?>
            <?php foreach ($quizQuestions as $index => $question): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start mb-4">
                        <div class="w-8 h-8 flex-shrink-0 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold mr-4">
                            <?php echo $index + 1; ?>
                        </div>
                        <div class="flex-1">
                            <p class="text-lg font-medium text-gray-900 mb-2"><?php echo htmlspecialchars($question['question_text']); ?></p>
                            <p class="text-sm text-gray-600">Points: <?php echo $question['question_points']; ?></p>
                        </div>
                    </div>

                    <div class="pl-12 space-y-3">
                        <?php if ($question['question_type'] === 'multiple-choice'): ?>
                            <?php foreach ($question['options'] as $option): ?>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo htmlspecialchars($option['option_id']); ?>" class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php elseif ($question['question_type'] === 'checkbox'): ?>
                            <?php foreach ($question['options'] as $option): ?>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="answer[<?php echo $question['question_id']; ?>][]" value="<?php echo htmlspecialchars($option['option_id']); ?>" class="form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="ml-3 text-gray-700"><?php echo htmlspecialchars($option['option_text']); ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php elseif ($question['question_type'] === 'true-false'): ?>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="true" class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-gray-700">True</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="false" class="form-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-gray-700">False</span>
                            </label>
                        <?php elseif ($question['question_type'] === 'short-answer'): ?>
                            <textarea name="answer[<?php echo $question['question_id']; ?>]" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2" placeholder="Type your answer here..."></textarea>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="text-center mt-8">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-lg font-medium shadow-md">
                    Submit Quiz
                </button>
            </div>
        <?php endif; ?>
    </div>
</form>