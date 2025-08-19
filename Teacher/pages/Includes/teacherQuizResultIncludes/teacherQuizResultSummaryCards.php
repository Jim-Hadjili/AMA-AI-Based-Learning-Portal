<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Attempts -->
    <div class="bg-white overflow-hidden shadow rounded-xl border">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-100 rounded-full p-4">
                    <i class="fas fa-clipboard-list text-blue-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-semibold text-gray-800">Total Attempts</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-bold text-gray-900"><?php echo $totalAttempts; ?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Unique Students -->
    <div class="bg-white overflow-hidden shadow rounded-xl border">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-100 rounded-full p-4">
                    <i class="fas fa-users text-purple-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-semibold text-gray-800">Unique Students</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-bold text-gray-900"><?php echo $totalStudents; ?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Score -->
    <div class="bg-white overflow-hidden shadow rounded-xl border">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-100 rounded-full p-4">
                    <i class="fas fa-chart-line text-green-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-semibold text-gray-800">Average Score</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-bold text-gray-900"><?php echo $avgScore; ?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass Rate -->
    <div class="bg-white overflow-hidden shadow rounded-xl border">
        <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-100 rounded-full p-4">
                    <i class="fas fa-percentage text-yellow-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-base font-semibold text-gray-800">Pass Rate</dt>
                        <dd class="flex items-baseline">
                            <div class="text-3xl font-bold text-gray-900"><?php echo $passRate; ?>%</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>