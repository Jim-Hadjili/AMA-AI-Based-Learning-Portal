<form id="quiz-preview-form">
    <?php if (empty($questions)): ?>
        <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Questions Available</h3>
            <p class="text-gray-500">No questions found for this quiz.</p>
        </div>
    <?php else: ?>
        <div id="quiz-questions-container">
            <?php foreach ($questions as $index => $question): ?>
                <div class="quiz-question-item <?php echo $index === 0 ? '' : 'hidden'; ?>" data-question-index="<?php echo $index; ?>">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-lg p-6">
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Question Content (Left Side) -->
                            <div class="flex-1">
                                <div class="flex items-start gap-4 mb-6">
                                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-medium text-sm">
                                        <?php echo $index + 1; ?>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                            <?php echo htmlspecialchars($question['question_text']); ?>
                                        </h3>
                                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded">
                                            <?php echo $question['question_points']; ?> point<?php echo $question['question_points'] != 1 ? 's' : ''; ?>
                                        </span>
                                    </div>
                                </div>
                                <?php if (!empty($question['question_image'])): ?>
                                    <div class="mb-4">
                                        <img src="../../Uploads/QuizImages/<?php echo htmlspecialchars($question['question_image']); ?>" alt="Question Image" class="max-w-xs rounded-lg border border-gray-200">
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <?php include 'questionCard.php'; ?>
                                </div>
                            </div>
                            <!-- Navigation Controls (Right Side) -->
                            <div class="lg:w-64 flex flex-col justify-between">
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Question Navigation</h4>
                                    <div class="grid grid-cols-1 gap-2 py-3 px-2 question-nav-numbers max-h-72 overflow-y-auto pr-1" id="global-question-nav-<?php echo $index; ?>">
                                        <?php foreach ($questions as $navIdx => $q): ?>
                                            <button
                                                type="button"
                                                class="question-nav-btn w-full text-left px-3 py-2 rounded-lg font-medium border border-gray-300 text-gray-700 bg-white transition-colors"
                                                data-question-nav="<?php echo $navIdx; ?>">
                                                <?php echo 'Question ' . ($navIdx + 1); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <button type="button" class="prev-question-btn w-full px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors flex items-center justify-center <?php echo $index === 0 ? 'hidden' : ''; ?>">
                                        <i class="fas fa-chevron-left mr-2"></i>
                                        Previous
                                    </button>
                                    <?php if ($index < count($questions) - 1): ?>
                                        <button type="button" class="next-question-btn w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors flex items-center justify-center">
                                            Next
                                            <i class="fas fa-chevron-right ml-2"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="w-full px-4 py-3 bg-gray-400 text-white rounded-lg font-medium opacity-75 cursor-not-allowed flex items-center justify-center" disabled>
                                            <i class="fas fa-check mr-2"></i>
                                            End of Preview
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
    }

    function updateNavActive() {
        document.querySelectorAll('.question-nav-numbers').forEach(nav => {
            const parentItem = nav.closest('.quiz-question-item');
            if (parentItem && parentItem.classList.contains('hidden')) return;
            nav.querySelectorAll('.question-nav-btn').forEach((btn, idx) => {
                if (idx === currentIndex) {
                    btn.classList.add('ring-2', 'ring-blue-500', 'bg-blue-100');
                } else {
                    btn.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-100');
                }
            });
        });
    }

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

    document.querySelectorAll('.next-question-btn').forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            if (currentIndex < questions.length - 1) {
                showQuestion(currentIndex + 1);
            }
        });
    });

    document.querySelectorAll('.prev-question-btn').forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            if (currentIndex > 0) {
                showQuestion(currentIndex - 1);
            }
        });
    });

    showQuestion(currentIndex);
});
</script>