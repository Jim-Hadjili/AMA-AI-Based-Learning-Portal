<div class="max-w-7xl sticky top-0 bg-white/95 backdrop-blur-sm rounded-xl z-10 shadow-sm border border-gray-400 mb-4 mt-6 mx-auto">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" 
                   class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Class
                </a>
                <div class="h-6 w-px bg-gray-300"></div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        Edit Quiz: <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                    </h1>
                    <p class="text-sm text-gray-500">
                        <?php echo htmlspecialchars($quiz['class_name']); ?> • <?php echo htmlspecialchars($quiz['class_code']); ?>
                    </p>
                </div>
            </div>
            
            <button id="saveQuizBtn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
        </div>
    </div>
</div>