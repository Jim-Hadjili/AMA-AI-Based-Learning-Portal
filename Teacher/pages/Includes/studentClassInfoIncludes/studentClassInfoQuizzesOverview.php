<style>
    .group:hover .group-hover-rotate {
        transform: rotate(12deg);
        transition: transform 0.3s;
    }
</style>

<div class="w-full mb-8">
    <div class="bg-white rounded-2xl shadow-lg border border-white/50 backdrop-blur-sm overflow-hidden mb-4">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 p-6">
            <!-- Total Quizzes Card -->
            <div class="group bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-blue-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-4 p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg transform transition-transform duration-300 group-hover-rotate">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Quizzes</h3>
                        <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent"><?php echo $totalQuizzes; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Available quizzes</p>
                    </div>
                </div>
            </div>

            <!-- Completed Quizzes Card -->
            <div class="group bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-green-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-4 p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg transform transition-transform duration-300 group-hover-rotate">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Completed</h3>
                        <p class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent"><?php echo $completedQuizzes; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Finished quizzes</p>
                    </div>
                </div>
            </div>

            <!-- Pending Quizzes Card -->
            <div class="group bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-yellow-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                <div class="flex items-center gap-4 p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg transform transition-transform duration-300 group-hover-rotate">
                        <i class="fas fa-hourglass-half text-white text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Pending</h3>
                        <p class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-yellow-800 bg-clip-text text-transparent"><?php echo $totalQuizzes - $completedQuizzes; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Not yet attempted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>