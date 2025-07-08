<!-- Top Navigation Bar -->
<nav class="bg-white shadow-soft rounded-lg px-6 py-4 mb-8 flex items-center justify-between">
    <div class="flex items-center space-x-2">
        <a href="../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" 
           class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
            <i class="fas fa-arrow-left mr-2"></i>
            <span><?php echo htmlspecialchars($quiz['class_name']); ?></span>
        </a>
    </div>
    
    <div class="flex items-center space-x-3">
        <span class="text-sm text-gray-500">Preview Mode</span>
        <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>
            Edit Quiz
        </a>
    </div>
</nav>