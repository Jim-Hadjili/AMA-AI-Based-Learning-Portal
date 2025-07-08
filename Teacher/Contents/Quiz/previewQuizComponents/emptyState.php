<!-- Empty state for no questions -->
<div class="text-center py-10">
    <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
        <i class="fas fa-question-circle text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-medium text-gray-800 mb-3">No Questions Added</h3>
    <p class="text-gray-500 max-w-md mx-auto mb-6">
        This quiz doesn't have any questions yet. Add questions to complete your quiz setup.
    </p>
    <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>&section=questions" 
       class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        <i class="fas fa-plus mr-2"></i>
        Add Questions
    </a>
</div>