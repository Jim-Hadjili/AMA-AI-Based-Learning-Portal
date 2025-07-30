<div class="bg-white rounded-lg border border-gray-200 mb-4 p-6">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
        <!-- Main Content -->
        <div class="flex items-start gap-4 flex-1">
            <!-- Icon -->
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <!-- Text Content -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    <?php echo htmlspecialchars($quizDetails['quiz_title']); ?>
                </h1>
                <p class="text-gray-600 mb-4">
                    <?php echo htmlspecialchars($quizDetails['quiz_description'] ?? 'No description provided.'); ?>
                </p>
                
                <!-- Quiz Stats -->
                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><?php echo $quizDetails['time_limit']; ?> minutes</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span><?php echo $quizDetails['total_questions']; ?> questions</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <span><?php echo $quizDetails['total_score']; ?> points</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Timer -->
        <div class="flex justify-center lg:justify-end">
            <div class="bg-blue-600 text-white px-4 py-3 rounded-lg">
                <div class="text-center">
                    <p class="text-xs text-blue-100 mb-1">Time Remaining</p>
                    <span id="quiz-timer" class="text-xl font-bold">
                        <?php echo $quizDetails['time_limit']; ?>:00
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>