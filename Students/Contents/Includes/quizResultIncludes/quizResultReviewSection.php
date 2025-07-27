<div class="space-y-6" id="quiz-review-container">
    <?php if (empty($quizQuestions)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center flex flex-col items-center justify-center">
            <i class="fas fa-exclamation-circle text-gray-400 text-4xl mb-4"></i>
            <p class="text-gray-600 text-lg font-medium">No questions found for this quiz.</p>
            <p class="text-gray-500 text-sm mt-2">It seems there are no questions to review for this attempt.</p>
        </div>
    <?php else: ?>
        <?php foreach ($quizQuestions as $index => $question):
            $question_id = $question['question_id'];
            $student_answer = $studentAnswers[$question_id] ?? ['selected_options' => null, 'text_answer' => null, 'is_correct' => 0, 'points_awarded' => 0];
            $is_correct = $student_answer['is_correct'];
            $correct_info = $correctAnswersData[$question_id];

            $card_border_class = $is_correct ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500';
            $icon_class = $is_correct ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600';
            $icon_bg_class = $is_correct ? 'bg-green-50' : 'bg-red-50';
        ?>
            <div class="quiz-review-item <?php echo $index === 0 ? '' : 'hidden'; ?>" data-review-index="<?php echo $index; ?>">
                <div class="bg-white rounded-xl shadow-sm <?php echo $card_border_class; ?> p-6 sm:p-8">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start flex-1">
                            <div class="w-10 h-10 flex-shrink-0 rounded-full <?php echo $icon_bg_class; ?> flex items-center justify-center text-gray-700 font-semibold text-lg mr-4">
                                <?php echo $index + 1; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 leading-snug"><?php echo htmlspecialchars($question['question_text']); ?></p>
                                <p class="text-sm text-gray-600">Points: <span class="font-medium"><?php echo $question['question_points']; ?></span> | Awarded: <span class="font-medium"><?php echo $student_answer['points_awarded']; ?></span></p>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <i class="fas <?php echo $icon_class; ?> text-3xl"></i>
                        </div>
                    </div>

                    <div class="pl-14 space-y-4">
                        <?php if ($question['question_type'] === 'multiple-choice' || $question['question_type'] === 'true-false' || $question['question_type'] === 'checkbox'):
                            $student_selected_options = explode(',', $student_answer['selected_options']);
                        ?>
                            <p class="text-md font-semibold text-gray-800">Your Answer:</p>
                            <div class="space-y-2">
                                <?php foreach ($correct_info['options'] as $option):
                                    $is_student_selected = in_array($option['option_id'], $student_selected_options);
                                    $option_text_class = '';
                                    $option_icon = '';
                                    $option_bg_class = '';

                                    if ($option['is_correct']) {
                                        $option_text_class = 'text-green-700 font-bold';
                                        $option_icon = '<i class="fas fa-check ml-2 text-green-500"></i>';
                                        $option_bg_class = 'bg-green-50 border-green-200';
                                    } elseif ($is_student_selected && !$option['is_correct']) {
                                        $option_text_class = 'text-red-700 font-bold';
                                        $option_icon = '<i class="fas fa-times ml-2 text-red-500"></i>';
                                        $option_bg_class = 'bg-red-50 border-red-200';
                                    } elseif ($is_student_selected) {
                                        $option_bg_class = 'bg-blue-50 border-blue-200';
                                    }
                                ?>
                                    <div class="flex items-center p-3 rounded-md border <?php echo $option_bg_class ?: 'border-gray-200'; ?>">
                                        <span class="text-gray-700 <?php echo $option_text_class; ?>">
                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                        </span>
                                        <?php echo $option_icon; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <p class="text-md font-semibold text-gray-800 mt-4 pt-2 border-t border-gray-100">Correct Answer(s):</p>
                            <div class="p-3 rounded-md bg-green-50 border border-green-200 text-green-700 font-medium">
                                <?php echo htmlspecialchars($correct_info['correct_text']); ?>
                            </div>

                        <?php elseif ($question['question_type'] === 'short-answer'): ?>
                            <p class="text-md font-semibold text-gray-800">Your Answer:</p>
                            <div class="p-3 rounded-md bg-gray-50 border border-gray-200 text-gray-700">
                                <?php echo htmlspecialchars($student_answer['text_answer'] ?? 'No answer provided.'); ?>
                            </div>
                            <p class="text-md font-semibold text-gray-800 mt-4 pt-2 border-t border-gray-100">Correct Answer:</p>
                            <div class="p-3 rounded-md bg-green-50 border border-green-200 text-green-700 font-medium">
                                <?php echo htmlspecialchars($correct_info['correct_text'] ?? 'N/A'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-6">
                    <button type="button" class="prev-review-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium <?php echo $index === 0 ? 'hidden' : ''; ?>">
                        Previous
                    </button>
                    <?php if ($index < count($quizQuestions) - 1): ?>
                        <button type="button" class="next-review-btn px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium ml-auto">
                            Next
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewItems = document.querySelectorAll('.quiz-review-item');
    let currentReviewIndex = 0;

    function showReview(index) {
        reviewItems.forEach((item, i) => {
            if (i === index) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    document.querySelectorAll('.next-review-btn').forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            if (currentReviewIndex < reviewItems.length - 1) {
                currentReviewIndex++;
                showReview(currentReviewIndex);
            }
        });
    });

    document.querySelectorAll('.prev-review-btn').forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            if (currentReviewIndex > 0) {
                currentReviewIndex--;
                showReview(currentReviewIndex);
            }
        });
    });

    // Optional: Scroll to top of review card on navigation
    function scrollToReview() {
        const container = document.getElementById('quiz-review-container');
        if (container) container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    document.querySelectorAll('.next-review-btn, .prev-review-btn').forEach(btn => {
        btn.addEventListener('click', scrollToReview);
    });

    // Show the first review initially
    showReview(currentReviewIndex);
});
</script>