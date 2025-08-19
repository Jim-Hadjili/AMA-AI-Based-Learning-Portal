<div class="w-full mb-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Attempts Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Total Attempts</h3>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $totalAttempts; ?></p>
                        <p class="text-xs text-gray-500 mt-1">All quiz submissions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unique Students Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-1">Unique Students</h3>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $totalStudents; ?></p>
                        <p class="text-xs text-gray-500 mt-1">Students participated</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Score Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
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
        </div>

        <!-- Pass Rate Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-orange-100 rounded-xl">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
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