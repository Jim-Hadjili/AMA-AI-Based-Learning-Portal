<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center">
                <div class="inline-block p-4 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-question-circle text-2xl text-green-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($quizDetails['quiz_title']); ?></h1>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($quizDetails['quiz_description'] ?? 'No description provided.'); ?></p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-clock mr-1"></i>Time Limit: <strong><?php echo $quizDetails['time_limit']; ?> minutes</strong></span>
                        <span><i class="fas fa-list-ol mr-1"></i>Questions: <strong><?php echo $quizDetails['total_questions']; ?></strong></span>
                        <span><i class="fas fa-star mr-1"></i>Total Score: <strong><?php echo $quizDetails['total_score']; ?> points</strong></span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span id="quiz-timer" class="px-3 py-1 text-lg font-bold rounded-full bg-blue-100 text-blue-800">
                    <?php echo $quizDetails['time_limit']; ?>:00
                </span>
            </div>
        </div>
    </div>
</div>