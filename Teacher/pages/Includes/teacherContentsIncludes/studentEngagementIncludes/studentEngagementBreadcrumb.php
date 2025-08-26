<div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-semibold text-gray-900">Student Engagement</h3>
    <?php if (!empty($uniqueStudents)): ?>
        <a href="../Reports/quizResults.php" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
            <span>View All</span>
            <i class="fas fa-chevron-right text-xs"></i>
        </a>
    <?php endif; ?>
</div>