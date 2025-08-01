<div class="mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Recent Quizzes</h3>
            <div class="flex items-center space-x-6 text-sm text-gray-600">
                <span class="flex items-center">
                    <i class="fas fa-clipboard-list mr-2 text-blue-500"></i>
                    <?php echo count($quizzes); ?> Total Quiz<?php echo count($quizzes) != 1 ? 'zes' : ''; ?>
                </span>
                <span class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    <?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'published'; })); ?> Published
                </span>
                <span class="flex items-center">
                    <i class="fas fa-edit mr-2 text-yellow-500"></i>
                    <?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'draft'; })); ?> Draft<?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'draft'; })) != 1 ? 's' : ''; ?>
                </span>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Create Quiz Button -->
            <button id="addQuizTabBtn" type="button"
                class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-purple-600 text-sm font-semibold rounded-lg text-purple-700 hover:text-white bg-purple-50 hover:bg-purple-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <span class="font-semibold">Add Quiz</span>
            </button>
        </div>
    </div>
</div>