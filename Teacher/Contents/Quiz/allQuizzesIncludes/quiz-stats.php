<div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-white/50 mb-6">
    <div class="bg-white border-b-2 border-gray-200 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <i class="fas fa-tasks text-indigo-600 text-2xl"></i>
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
                    Add New Quiz
                </button>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-indigo-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg mr-4 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-tasks text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <?php if (!empty($searchTerm) || $statusFilter !== 'all'): ?>
                        Filtered Results
                    <?php else: ?>
                        Total Quizzes
                    <?php endif; ?>
                </p>
                <p class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-indigo-800 bg-clip-text text-transparent"><?php echo $totalQuizzes; ?></p>
            </div>
        </div>
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg mr-4 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Published</p>
                <p class="text-lg font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent"><?php echo $statsData['published']; ?></p>
            </div>
        </div>
        <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-yellow-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg mr-4 group-hover:rotate-12 transition-transform duration-300">
                <i class="fas fa-file-alt text-white text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Drafts</p>
                <p class="text-lg font-bold bg-gradient-to-r from-yellow-600 to-yellow-800 bg-clip-text text-transparent"><?php echo $statsData['drafts']; ?></p>
            </div>
        </div>
    </div>
</div>