<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
    <!-- Total Students Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-blue-100 hover:shadow-xl transition-shadow duration-200">
        <div class="p-6 flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 4a4 4 0 110 8 4 4 0 010-8zm0 0v1m0 8v1m-4-4h1m8 0h1"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">Total Students</h3>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalStudentsEnrolled ?? 0; ?></p>
                <p class="text-sm text-gray-500 mt-1">Across all <?php echo $totalClassesCount; ?> classes</p>
            </div>
        </div>
    </div>
    <!-- Quizzes Created Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-green-100 hover:shadow-xl transition-shadow duration-200">
        <div class="p-6 flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-xl">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-xs font-semibold text-green-600 uppercase tracking-wide mb-1">Quizzes Created</h3>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzesCreated ?? 0; ?></p>
                <p class="text-sm text-gray-500 mt-1">Published by you all Across the <?php echo $totalClassesCount; ?> Classes</p>
            </div>
        </div>
    </div>
</div>