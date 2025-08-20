<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
    <div class="bg-white border-b border-gray-100 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">
                        <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                            Filtered Results
                        <?php else: ?>
                            Quiz Statistics
                        <?php endif; ?>
                    </h3>
                    <p class="text-sm text-gray-600">Overview of your quizzes</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button id="addQuizBtn" type="button" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    New Quiz
                </button>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4 flex items-center">
            <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                        Filtered Results
                    <?php else: ?>
                        Total Quizzes
                    <?php endif; ?>
                </p>
                <p class="text-lg font-bold text-gray-900"><?php echo $totalQuizzes; ?></p>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4 flex items-center">
            <div class="p-2 bg-green-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Published</p>
                <p class="text-lg font-bold text-green-600"><?php echo $statsData['published']; ?></p>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4 flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Drafts</p>
                <p class="text-lg font-bold text-yellow-600"><?php echo $statsData['drafts']; ?></p>
            </div>
        </div>
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4 flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Attempts</p>
                <p class="text-lg font-bold text-blue-600"><?php echo $statsData['attempts']; ?></p>
            </div>
        </div>
    </div>
</div>