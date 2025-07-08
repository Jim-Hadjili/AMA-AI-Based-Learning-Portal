<?php if ($hasMoreQuizzes): ?>
    <div class="text-center py-6 border-t border-gray-200">
        <a href="../Quiz/allQuizzes.php?class_id=<?php echo $class_id; ?>" 
           class="inline-flex items-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 focus:ring-2 focus:ring-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
            <i class="fas fa-th-large mr-2"></i>
            View All <?php echo count($quizzes); ?> Quizzes
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
<?php endif; ?>