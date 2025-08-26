<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
        <div class="text-xs font-medium text-blue-600 uppercase tracking-wide mb-1">Total Students</div>
        <div class="text-2xl font-bold text-gray-900"><?php echo $totalStudentsEnrolled ?? 0; ?></div>
        <div class="text-sm text-gray-500 mt-1">Across <?php echo $totalClassesCount; ?> classes</div>
    </div>
    <div class="bg-green-50 rounded-lg p-4 border border-green-100">
        <div class="text-xs font-medium text-green-600 uppercase tracking-wide mb-1">Quizzes Created</div>
        <div class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzesCreated ?? 0; ?></div>
        <div class="text-sm text-gray-500 mt-1">Published by you</div>
    </div>
</div>