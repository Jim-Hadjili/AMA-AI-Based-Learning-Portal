<div class="text-center py-16">
    <div class="w-24 h-24 mx-auto mb-6 bg-blue-50 rounded-full flex items-center justify-center">
        <i class="fas fa-clipboard-question text-4xl text-blue-500"></i>
    </div>
    <h2 class="text-2xl font-semibold text-gray-900 mb-3">No Quizzes Found</h2>
    <p class="text-gray-500 mb-8 max-w-md mx-auto">
        This class doesn't have any quizzes yet. Create your first quiz to start engaging your students.
    </p>
    <a href="../Quiz/createQuiz.php?class_id=<?php echo $class_id; ?>" 
       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition-colors shadow-sm">
        <i class="fas fa-plus mr-2"></i>
        Create Your First Quiz
    </a>
</div>