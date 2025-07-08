<!-- Header -->
<div class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-4">
                <a href="../Contents/Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" 
                   class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
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
            
            <div class="flex items-center space-x-3">
                <button id="previewQuizBtn" class="px-4 py-2 text-purple-600 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-eye mr-2"></i>Preview
                </button>
                <button id="saveQuizBtn" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>