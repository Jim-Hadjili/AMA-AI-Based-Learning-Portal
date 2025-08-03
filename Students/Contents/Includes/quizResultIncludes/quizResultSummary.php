<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-4">
    <!-- Performance Summary -->
    <div class="text-center mb-8">
        <div class="mb-6">
            <?php if ($percentage_score >= 90): ?>
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-trophy text-3xl text-yellow-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Excellent Work!</h2>
                <p class="text-gray-600">Outstanding performance on this quiz.</p>
            <?php elseif ($percentage_score >= PASSING_THRESHOLD): ?>
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Well Done!</h2>
                <p class="text-gray-600">You have successfully passed this quiz.</p>
            <?php else: ?>
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-times-circle text-3xl text-red-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Keep Trying!</h2>
                <p class="text-gray-600">Don't give up! Review the material and try again.</p>
            <?php endif; ?>
        </div>

        <!-- Score Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-900"><?php echo $quizAttempt['score']; ?> / <?php echo $total_possible_score; ?></div>
                <div class="text-sm text-gray-600">Total Score</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-2xl font-bold <?php echo ($percentage_score >= PASSING_THRESHOLD) ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo $percentage_score; ?>%
                </div>
                <div class="text-sm text-gray-600">Percentage</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-900"><?php echo $correct_answers_count; ?> / <?php echo $total_questions; ?></div>
                <div class="text-sm text-gray-600">Correct Answers</div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-8">
            <?php if ($percentage_score >= PASSING_THRESHOLD): ?>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check mr-2"></i> Passed
                </span>
            <?php else: ?>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <i class="fas fa-times mr-2"></i> Not Passed
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <!-- View Answer Sheet Button -->
        <div class="flex-shrink-0">
            <a href="quizAnswerSheet.php?attempt_id=<?php echo htmlspecialchars($attempt_id); ?>" 
               class="bg-white hover:bg-indigo-600 hover:text-white text-gray-700 px-5 py-2 rounded-xl flex items-center text-base font-semibold transition-all duration-200 shadow-md hover:shadow-lg border-2 border-indigo-600 quiz-navigation-link focus:ring-2 focus:ring-indigo-300">
                <i class="fas fa-file-alt mr-2"></i>
                View Answer Sheet
            </a>
        </div>

        <!-- Retake Quiz Button (if applicable) -->
        <?php if (!$has_passed && $quizAttempt['allow_retakes']): ?>
        <div class="flex-shrink-0">
            <button
                id="retakeQuizBtn"
                class="bg-white hover:bg-orange-500 hover:text-white text-gray-700 px-5 py-2 rounded-xl flex items-center text-base font-semibold transition-all duration-200 shadow-md hover:shadow-lg border-2 border-orange-500 quiz-navigation-link focus:ring-2 focus:ring-orange-300"
                data-quiz-id="<?php echo htmlspecialchars($quiz_id); ?>">
                <i class="fas fa-redo-alt mr-2"></i>
                Retake Quiz
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full text-center flex flex-col items-center">
        <svg class="animate-spin h-8 w-8 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <h2 class="text-lg font-bold text-blue-600 mb-2">Please wait...</h2>
        <p class="text-gray-700">The AI is generating a new quiz for you.</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var retakeBtn = document.getElementById("retakeQuizBtn");
    if (retakeBtn) {
        retakeBtn.addEventListener("click", function() {
            document.getElementById("loadingModal").classList.remove("hidden");
            setTimeout(function() {
                window.location.href = "../../Functions/regenerateQuiz.php?quiz_id=" + encodeURIComponent(retakeBtn.dataset.quizId);
            }, 600);
        });
    }
});
</script>