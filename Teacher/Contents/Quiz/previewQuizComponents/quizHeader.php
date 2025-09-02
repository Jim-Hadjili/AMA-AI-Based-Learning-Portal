<!-- Quiz Info Card -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-8">
    <div class="bg-white border-b border-gray-100 px-6 py-6">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
                <p class="text-lg font-medium text-gray-700"><?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
                <p class="text-sm text-gray-500 mt-1">Preview mode &mdash; only visible to teachers</p>
            </div>
            <div class="flex-1"></div>
            <a href="editQuiz.php?quiz_id=<?php echo $quiz_id; ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Edit Quiz
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mb-8">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
        <div class="p-6 flex items-center gap-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <i class="fas fa-clock text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Time Limit</h3>
                <p class="text-2xl font-bold text-gray-900"><?php echo $quiz['time_limit'] ? $quiz['time_limit'] . ' min' : 'No limit'; ?></p>
                <p class="text-xs text-gray-500 mt-1">Quiz duration</p>
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
        <div class="p-6 flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-xl">
                <i class="fas fa-question text-green-600"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Questions</h3>
                <p class="text-2xl font-bold text-gray-900"><?php echo count($questions); ?></p>
                <p class="text-xs text-gray-500 mt-1">Total questions</p>
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
        <div class="p-6 flex items-center gap-4">
            <div class="p-3 bg-purple-100 rounded-xl">
                <i class="fas fa-star text-purple-600"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Points</h3>
                <p class="text-2xl font-bold text-gray-900"><?php echo $totalPoints; ?></p>
                <p class="text-xs text-gray-500 mt-1">Quiz points</p>
            </div>
        </div>
    </div>
</div>