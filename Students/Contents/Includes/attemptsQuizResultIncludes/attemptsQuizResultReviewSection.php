<div id="quiz-review-container">
    <?php if (empty($quizQuestions)): ?>
        <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Questions Available</h3>
            <p class="text-gray-500">No questions found for this attempt.</p>
        </div>
    <?php else: ?>
        <?php foreach ($quizQuestions as $index => $question):
            $question_id = $question['question_id'];
            $student_answer = $studentAnswers[$question_id] ?? ['selected_options' => null, 'text_answer' => null, 'is_correct' => 0, 'points_awarded' => 0];
            $is_correct = $student_answer['is_correct'];
            $correct_info = $correctAnswersData[$question_id];
            $student_selected_options = array_filter(explode(',', $student_answer['selected_options'] ?? ''));
        ?>
            <div class="review-question-item <?php echo $index === 0 ? '' : 'hidden'; ?>" data-review-index="<?php echo $index; ?>">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Left -->
                        <div class="flex-1">
                            <div class="flex items-start gap-4 mb-6">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium <?php echo $is_correct ? 'bg-green-600 text-white' : 'bg-red-600 text-white'; ?>">
                                    <?php echo $index + 1; ?>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                                        <?php echo htmlspecialchars($question['question_text']); ?>
                                    </h3>
                                    <div class="flex flex-wrap gap-2 text-xs">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">
                                            Points: <?php echo $question['question_points']; ?>
                                        </span>
                                        <span class="px-2 py-1 rounded <?php echo $is_correct ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                                            <?php echo $is_correct ? 'Correct' : 'Incorrect'; ?>
                                        </span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                            Awarded: <?php echo $student_answer['points_awarded']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <?php if (in_array($question['question_type'], ['multiple-choice','true-false','checkbox'])): ?>
                                    <p class="text-md font-semibold text-gray-800">Your Answer:</p>
                                    <div class="space-y-2">
                                        <?php foreach ($correct_info['options'] as $option):
                                            $optCorrect = $option['is_correct'];
                                            $chosen = in_array($option['option_id'], $student_selected_options);
                                            $baseClasses = 'flex items-center p-3 border rounded-lg';
                                            if ($optCorrect) {
                                                $stateClasses = 'bg-green-50 border-green-300';
                                            } elseif ($chosen && !$optCorrect) {
                                                $stateClasses = 'bg-red-50 border-red-300';
                                            } elseif ($chosen) {
                                                $stateClasses = 'bg-blue-50 border-blue-200';
                                            } else {
                                                $stateClasses = 'border-gray-200';
                                            }
                                        ?>
                                            <div class="<?php echo $baseClasses . ' ' . $stateClasses; ?>">
                                                <span class="text-sm text-gray-800 <?php echo $optCorrect ? 'font-semibold text-green-700' : ($chosen && !$optCorrect ? 'font-semibold text-red-700' : ''); ?>">
                                                    <?php echo htmlspecialchars($option['option_text']); ?>
                                                </span>
                                                <?php if ($optCorrect): ?>
                                                    <i class="fas fa-check ml-2 text-green-500 text-sm"></i>
                                                <?php elseif ($chosen && !$optCorrect): ?>
                                                    <i class="fas fa-times ml-2 text-red-500 text-sm"></i>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <p class="text-md font-semibold text-gray-800 mt-4 pt-2 border-t border-gray-100">
                                        Correct Answer<?php echo count(array_filter($correct_info['options'], fn($o)=>$o['is_correct']))>1?'s':''; ?>:
                                    </p>
                                    <div class="p-3 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                                        <?php echo htmlspecialchars($correct_info['correct_text']); ?>
                                    </div>

                                <?php elseif ($question['question_type'] === 'short-answer'): ?>
                                    <p class="text-md font-semibold text-gray-800">Your Answer:</p>
                                    <div class="p-3 rounded-md bg-gray-50 border border-gray-200 text-gray-700 text-sm">
                                        <?php echo htmlspecialchars($student_answer['text_answer'] ?? 'No answer provided.'); ?>
                                    </div>
                                    <p class="text-md font-semibold text-gray-800 mt-4 pt-2 border-t border-gray-100">Expected Answer:</p>
                                    <div class="p-3 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                                        <?php echo htmlspecialchars($correct_info['correct_text'] ?? 'N/A'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Right navigation -->
                        <div class="lg:w-64 flex flex-col justify-between">
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Question Navigation</h4>
                                <div class="grid grid-cols-1 gap-2 py-3 px-2 review-nav-numbers max-h-72 overflow-y-auto pr-1">
                                    <?php foreach ($quizQuestions as $navIdx => $q):
                                        $qid = $q['question_id'];
                                        $navCorrect = ($studentAnswers[$qid]['is_correct'] ?? 0) ? true : false;
                                        $colorClasses = $navCorrect
                                            ? 'border-green-400 text-green-700 bg-green-100 font-bold shadow'
                                            : 'border-red-400 text-red-700 bg-red-100 font-bold shadow';
                                        $icon = $navCorrect
                                            ? '<i class="fas fa-check-circle text-green-500 mr-2"></i>'
                                            : '<i class="fas fa-times-circle text-red-500 mr-2"></i>';
                                    ?>
                                        <button
                                            type="button"
                                            class="review-nav-btn w-full text-left px-3 py-2 rounded-lg font-medium border transition-colors text-sm flex items-center gap-2 <?php echo $colorClasses; ?>"
                                            data-review-nav="<?php echo $navIdx; ?>">
                                            <?php echo $icon . 'Question ' . ($navIdx + 1); ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button type="button"
                                        class="prev-review-btn w-full px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors flex items-center justify-center <?php echo $index === 0 ? 'hidden' : ''; ?>">
                                    <i class="fas fa-chevron-left mr-2"></i> Previous
                                </button>

                                <?php if ($index < count($quizQuestions) - 1): ?>
                                    <button type="button"
                                            class="next-review-btn w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors flex items-center justify-center">
                                        Next <i class="fas fa-chevron-right ml-2"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewItems = document.querySelectorAll('.review-question-item');
    let currentIndex = 0;

    function showReview(index) {
        reviewItems.forEach((item,i)=>{
            item.classList.toggle('hidden', i !== index);
        });
        currentIndex = index;
        updateNavActive();
    }

    function updateNavActive() {
        document.querySelectorAll('.review-nav-numbers').forEach(nav=>{
            const parentItem = nav.closest('.review-question-item');
            if (parentItem && parentItem.classList.contains('hidden')) return;
            nav.querySelectorAll('.review-nav-btn').forEach((btn, idx)=>{
                if (idx === currentIndex) {
                    btn.classList.add('ring-2','ring-blue-500','bg-blue-50');
                    const top = btn.offsetTop;
                    const bottom = top + btn.offsetHeight;
                    const viewTop = nav.scrollTop;
                    const viewBottom = viewTop + nav.clientHeight;
                    if (top < viewTop) {
                        nav.scrollTo({ top: top - 8, behavior: 'smooth' });
                    } else if (bottom > viewBottom) {
                        nav.scrollTo({ top: bottom - nav.clientHeight + 8, behavior: 'smooth' });
                    }
                } else {
                    btn.classList.remove('ring-2','ring-blue-500','bg-blue-50');
                }
            });
        });

        reviewItems.forEach((item,i)=>{
            if (i === currentIndex) {
                const prevBtn = item.querySelector('.prev-review-btn');
                const nextBtn = item.querySelector('.next-review-btn');
                if (prevBtn) prevBtn.classList.toggle('hidden', currentIndex === 0);
                if (nextBtn) nextBtn.classList.toggle('hidden', currentIndex === reviewItems.length - 1);
            }
        });
    }

    document.querySelectorAll('.review-nav-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            const idx = parseInt(btn.getAttribute('data-review-nav'), 10);
            if (!isNaN(idx)) showReview(idx);
            scrollToTop();
        });
    });

    document.querySelectorAll('.next-review-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            if (currentIndex < reviewItems.length - 1) {
                showReview(currentIndex + 1);
                scrollToTop();
            }
        });
    });

    document.querySelectorAll('.prev-review-btn').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            if (currentIndex > 0) {
                showReview(currentIndex - 1);
                scrollToTop();
            }
        });
    });

    function scrollToTop() {
        const container = document.getElementById('quiz-review-container');
        if (container) container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    showReview(currentIndex);
});
</script>