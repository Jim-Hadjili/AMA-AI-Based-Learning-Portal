<div class="w-full max-w-9xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8 border border-gray-200">
        <!-- Header Section -->
        <div class="bg-white border-b-2 border-gray-200 px-6 py-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Quiz Results Dashboard</h1>
                    <p class="text-lg font-medium text-gray-700">
                        <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Comprehensive analysis of student performance and quiz statistics</p>
                </div>
            </div>
        </div>

        <div class="w-full">
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                    <!-- Total Attempts Card -->
                    <div class="group p-6 bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-blue-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-clipboard-check text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Attempts</h3>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $totalAttempts; ?></p>
                                <p class="text-xs text-gray-500 mt-1">All quiz submissions</p>
                            </div>
                        </div>
                    </div>

                    <!-- Unique Students Card -->
                    <div class="group p-6 bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-green-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-user-graduate text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Unique Students</h3>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $totalStudents; ?></p>
                                <p class="text-xs text-gray-500 mt-1">Students participated</p>
                            </div>
                        </div>
                    </div>

                    <!-- Average Score Card -->
                    <div class="group p-6 bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-purple-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-chart-line text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Average Score</h3>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-2xl font-bold <?php echo $avgScore >= 65 ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $avgScore; ?>%
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Class performance</p>
                                <!-- Mini Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                    <div class="<?php echo $avgScore >= 65 ? 'bg-green-500' : 'bg-red-500'; ?> h-1.5 rounded-full transition-all duration-300" 
                                         style="width: <?php echo $avgScore; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pass Rate Card -->
                    <div class="group p-6 bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl overflow-hidden border border-orange-400 hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <div class="flex items-center gap-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-award text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Pass Rate</h3>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-2xl font-bold <?php echo $passRate >= 70 ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $passRate; ?>%
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Students passing (≥65%)</p>
                                <!-- Mini Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                    <div class="<?php echo $passRate >= 70 ? 'bg-green-500' : 'bg-red-500'; ?> h-1.5 rounded-full transition-all duration-300" 
                                         style="width: <?php echo $passRate; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>