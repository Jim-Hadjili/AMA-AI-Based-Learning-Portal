<div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
        <span class="p-2 bg-indigo-100 rounded-lg">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 4a4 4 0 110 8 4 4 0 010-8zm0 0v1m0 8v1m-4-4h1m8 0h1"/>
            </svg>
        </span>
        <h3 class="text-lg font-semibold text-gray-900">Student Engagement</h3>
    </div>
    <?php if (!empty($uniqueStudents)): ?>
        <a href="../Reports/quizResults.php" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors">
            <span>View All</span>
            <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    <?php endif; ?>
</div>