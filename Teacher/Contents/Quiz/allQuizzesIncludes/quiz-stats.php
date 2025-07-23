<div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <!-- Top accent strip -->
    <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-600"></div>
    <div class="p-8">
        <!-- Stats Row -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $totalQuizzes; ?></div>
                <div class="text-sm text-gray-500 text-center">
                    <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                        Filtered Results
                    <?php else: ?>
                        Total Quizzes
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-green-600 mb-1">
                    <?php echo $statsData['published']; ?>
                </div>
                <div class="text-sm text-gray-500 text-center">Published</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-yellow-600 mb-1">
                    <?php echo $statsData['drafts']; ?>
                </div>
                <div class="text-sm text-gray-500 text-center">Drafts</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-blue-600 mb-1">
                    <?php echo $statsData['attempts']; ?>
                </div>
                <div class="text-sm text-gray-500 text-center">Total Attempts</div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center justify-center">
                <div class="flex flex-col items-center w-full">
                    <button id="addQuizBtn" 
                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm mb-2">
                        <i class="fas fa-plus mr-2"></i>
                        New Quiz
                    </button>
                    <div class="text-sm text-gray-500 text-center">Action</div>
                </div>
            </div>
        </div>
    </div>
</div>