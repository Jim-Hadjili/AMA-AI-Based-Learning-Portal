<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Attempts -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                    <i class="fas fa-clipboard-list text-blue-600 text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Attempts</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900"><?php echo $totalAttempts; ?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Unique Students -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Unique Students</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900"><?php echo $totalStudents; ?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Score -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Average Score</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900"><?php echo $avgScore; ?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass Rate -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                    <i class="fas fa-percentage text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pass Rate</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900"><?php echo $passRate; ?>%</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>