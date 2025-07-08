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
            <button id="addQuizTabBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                <span>Add Quiz</span>
            </button>
        </div>
    </div>
</div>