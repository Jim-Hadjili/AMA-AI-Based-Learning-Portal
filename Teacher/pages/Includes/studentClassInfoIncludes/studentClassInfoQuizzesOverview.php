<div class="w-full mb-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <!-- Total Quizzes Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Quizzes</h3>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzes; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Available quizzes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Quizzes Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Completed</h3>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $completedQuizzes; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Finished quizzes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Quizzes Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 rounded-xl">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Pending</h3>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzes - $completedQuizzes; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Not yet attempted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>