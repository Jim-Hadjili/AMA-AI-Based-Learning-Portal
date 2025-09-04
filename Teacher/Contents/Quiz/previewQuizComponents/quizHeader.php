<!-- Quiz Info Card -->
<div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-white/50 mb-8">
    <div class="bg-white border-b-2 border-gray-200 px-6 py-6">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
            <div class="p-4 bg-blue-100 rounded-xl self-start">
                <i class="fas fa-book text-blue-600 text-3xl"></i>
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
                <p class="text-lg font-medium text-gray-700"><?php echo htmlspecialchars($quiz['quiz_description']); ?></p>
                <p class="text-sm text-gray-500 mt-1">Preview mode &mdash; only visible to teachers</p>
            </div>
            <button
                type="button"
                onclick="window.location.href='editQuiz.php?quiz_id=<?php echo $quiz_id; ?>'"
                class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden mt-4 md:mt-0"
                aria-label="Edit Quiz">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <i class="fas fa-edit h-5 w-5 mr-2 pt-[2px] group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="relative">Edit Quiz</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 px-6 py-6">
        <div class="group bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-blue-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
            <div class="p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Time Limit</h3>
                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo $quiz['time_limit'] ? $quiz['time_limit'] . ' min' : 'No limit'; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Quiz duration</p>
                </div>
            </div>
        </div>
        <div class="group bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-green-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
            <div class="p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-question text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Questions</h3>
                    <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent"><?php echo count($questions); ?></p>
                    <p class="text-xs text-gray-500 mt-1">Total questions</p>
                </div>
            </div>
        </div>
        <div class="group bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-purple-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
            <div class="p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Points</h3>
                    <p class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent"><?php echo $totalPoints; ?></p>
                    <p class="text-xs text-gray-500 mt-1">Quiz points</p>
                </div>
            </div>
        </div>
    </div>
</div>
