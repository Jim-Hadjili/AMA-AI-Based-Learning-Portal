<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center">
                <div class="inline-block p-4 rounded-full bg-blue-100 mr-4">
                    <i class="fas fa-award text-2xl text-blue-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Quiz Results: <?php echo htmlspecialchars($quizDetails['quiz_title']); ?></h1>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($quizDetails['quiz_description'] ?? 'No description provided.'); ?></p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-calendar-alt mr-1"></i>Attempt Date: <strong><?php echo date('M d, Y H:i', strtotime($quizAttempt['end_time'])); ?></strong></span>
                        <span><i class="fas fa-list-ol mr-1"></i>Total Questions: <strong><?php echo $total_questions; ?></strong></span>
                        <span><i class="fas fa-check-circle mr-1"></i>Correct Answers: <strong><?php echo $correct_answers_count; ?></strong></span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-4 py-2 text-xl font-bold rounded-full <?php echo ($percentage_score >= 70) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    Score: <?php echo $quizAttempt['score']; ?> / <?php echo $total_possible_score; ?> (<?php echo $percentage_score; ?>%)
                </span>
            </div>
        </div>
    </div>
</div>