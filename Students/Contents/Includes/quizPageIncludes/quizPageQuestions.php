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
        <div id="quiz-questions-container">
            <?php foreach ($quizQuestions as $index => $question): ?>
                <div class="quiz-question-item <?php echo $index === 0 ? '' : 'hidden'; ?>" data-question-index="<?php echo $index; ?>">
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <!-- Main Content Layout: Question on Left, Navigation on Right -->
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Question Content (Left Side) -->
                            <div class="flex-1">
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
                                            placeholder="Type your answer here..."></textarea>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Navigation Controls (Right Side) -->
                            <div class="lg:w-64 flex flex-col justify-between">
                                <!-- Question Navigation Numbers -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Question Navigation</h4>
                                    <div class="grid grid-cols-1 gap-2 py-3 px-2 question-nav-numbers max-h-72 overflow-y-auto pr-1" id="global-question-nav-<?php echo $index; ?>">
                                        <?php foreach ($quizQuestions as $navIdx => $q): ?>
                                            <button
                                                type="button"
                                                class="question-nav-btn w-full text-left px-3 py-2 rounded-lg font-medium border border-gray-300 text-gray-700 bg-white transition-colors"
                                                data-question-nav="<?php echo $navIdx; ?>">
                                                <?php echo 'Question ' . ($navIdx + 1); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Navigation Buttons -->
                                <div class="space-y-3">
                                    <!-- Previous Button -->
                                    <button type="button" class="prev-question-btn w-full px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors flex items-center justify-center <?php echo $index === 0 ? 'hidden' : ''; ?>">
                                        <i class="fas fa-chevron-left mr-2"></i>
                                        Previous
                                    </button>

                                    <!-- Next Button -->
                                    <?php if ($index < count($quizQuestions) - 1): ?>
                                        <button type="button" class="next-question-btn w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors flex items-center justify-center">
                                            Next
                                            <i class="fas fa-chevron-right ml-2"></i>
                                        </button>
                                    <?php else: ?>
                                        <!-- Submit Button -->
                                        <button type="submit" class="submit-quiz-btn w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium opacity-50 cursor-not-allowed flex items-center justify-center" disabled>
                                            <i class="fas fa-check mr-2"></i>
                                            Submit Quiz
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questions = document.querySelectorAll('.quiz-question-item');
        let currentIndex = 0;

        function showQuestion(index) {
            questions.forEach((q, i) => {
                if (i === index) {
                    q.classList.remove('hidden');
                } else {
                    q.classList.add('hidden');
                }
            });
            currentIndex = index;
            updateNavActive();
            updateAnsweredIndicators();
            updateSubmitButton();
        }

        function updateNavActive() {
            document.querySelectorAll('.question-nav-numbers').forEach((nav) => {
                // Skip hidden quiz containers (only act on the visible one)
                const parentItem = nav.closest('.quiz-question-item');
                if (parentItem && parentItem.classList.contains('hidden')) return;

                nav.querySelectorAll('.question-nav-btn').forEach((btn, idx) => {
                    if (idx === currentIndex) {
                        btn.classList.add('ring-2', 'ring-blue-500', 'bg-blue-100');
                        // Auto-scroll logic
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
                        btn.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-100');
                    }
                });
            });
        }

        function isAnswered(questionIdx) {
            const question = questions[questionIdx];
            if (!question) return false;
            const radios = question.querySelectorAll('input[type="radio"]');
            const checkboxes = question.querySelectorAll('input[type="checkbox"]');
            const textarea = question.querySelector('textarea');
            if (radios.length > 0) {
                return Array.from(radios).some(r => r.checked);
            }
            if (checkboxes.length > 0) {
                return Array.from(checkboxes).some(c => c.checked);
            }
            if (textarea) {
                return textarea.value.trim().length > 0;
            }
            return false;
        }

        function updateAnsweredIndicators() {
            document.querySelectorAll('.question-nav-numbers').forEach(nav => {
                nav.querySelectorAll('.question-nav-btn').forEach((btn, idx) => {
                    if (isAnswered(idx)) {
                        btn.classList.add('bg-green-500','text-white','border-green-600','hover:bg-green-600','answered');
                        btn.classList.remove('bg-gray-50','text-gray-700','border-gray-300','hover:bg-blue-50');
                    } else {
                        btn.classList.remove('bg-green-500','text-white','border-green-600','hover:bg-green-600','answered');
                        if (idx !== currentIndex) {
                            btn.classList.add('bg-white','text-gray-700','border-gray-300','hover:bg-blue-50');
                        }
                    }
                });
            });
        }

        function allQuestionsAnswered() {
            for (let i = 0; i < questions.length; i++) {
                if (!isAnswered(i)) return false;
            }
            return true;
        }

        function updateSubmitButton() {
            const submitBtn = document.querySelector('.submit-quiz-btn');
            if (submitBtn) {
                if (allQuestionsAnswered()) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.classList.add('hover:bg-green-700');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.classList.remove('hover:bg-green-700');
                }
            }
        }

        // Make all nav buttons clickable
        document.querySelectorAll('.question-nav-numbers').forEach(nav => {
            nav.querySelectorAll('.question-nav-btn').forEach((btn) => {
                btn.addEventListener('click', function() {
                    const navIdx = parseInt(btn.getAttribute('data-question-nav'), 10);
                    if (!isNaN(navIdx)) {
                        showQuestion(navIdx);
                    }
                });
            });
        });

        document.querySelectorAll('.next-question-btn').forEach((btn) => {
            btn.addEventListener('click', function() {
                if (currentIndex < questions.length - 1) {
                    currentIndex++;
                    showQuestion(currentIndex);
                }
            });
        });

        document.querySelectorAll('.prev-question-btn').forEach((btn) => {
            btn.addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    showQuestion(currentIndex);
                }
            });
        });

        // Update answered indicators and submit button on input change
        document.querySelectorAll('.quiz-question-item input, .quiz-question-item textarea').forEach(input => {
            input.addEventListener('change', function() {
                updateAnsweredIndicators();
                updateSubmitButton();
            });
            input.addEventListener('input', function() {
                updateAnsweredIndicators();
                updateSubmitButton();
            });
        });

        // Prevent form submission if not all questions are answered
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            if (!allQuestionsAnswered()) {
                e.preventDefault();
                alert('Please answer all questions before submitting the quiz.');
            }
        });

        // Initial state
        showQuestion(currentIndex);
        updateSubmitButton();
    });
</script>
