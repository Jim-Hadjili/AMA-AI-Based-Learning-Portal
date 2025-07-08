<div class="max-w-7xl sticky top-0 bg-white/95 backdrop-blur-sm rounded-xl z-10 shadow-sm border border-gray-400 mb-4 mt-6 mx-auto">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="../Tabs/classDetails.php?class_id=<?php echo $class_id; ?>" 
                   class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Back to Class</span>
                </a>

                <div class="h-4 w-px bg-gray-300"></div>
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">All Quizzes</h1>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($classInfo['class_name']); ?></p>
                </div>
            </div>
            
            <button id="addQuizBtn" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                New Quiz
            </button>
        </div>
    </div>
</div>