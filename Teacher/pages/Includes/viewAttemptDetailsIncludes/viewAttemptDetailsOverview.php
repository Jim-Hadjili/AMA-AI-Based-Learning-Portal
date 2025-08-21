<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
    <!-- Student Profile Card -->
    <div class="xl:col-span-1">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 animate-fade-in hover:shadow-xl transition-shadow duration-200">
            <div class="bg-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-user-graduate mr-2"></i>
                    Student Profile
                </h3>
            </div>

            <div class="p-6">
                <!-- Profile Picture and Basic Info -->
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 ring-4 ring-indigo-100">
                        <?php if ($attempt['profile_picture']): ?>
                            <img src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($attempt['profile_picture']); ?>"
                                alt="Student" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-500">
                                <i class="fas fa-user text-2xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="ml-4 min-w-0">
                        <h4 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($attempt['student_name']); ?></h4>
                        <p class="text-gray-600"><?php echo ucfirst(str_replace('_', ' ', $attempt['grade_level'])); ?></p>
                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($attempt['strand']); ?></p>
                    </div>
                </div>

                <!-- Student Details -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Student ID</span>
                        <span class="text-sm text-gray-900"><?php echo htmlspecialchars($attempt['student_id'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Subject Name</span>
                        <span class="text-sm text-gray-900"><?php echo htmlspecialchars($attempt['class_name']); ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Class Strand</span>
                        <span class="text-sm text-gray-900"><?php echo htmlspecialchars($attempt['subject']); ?></span>
                    </div>
                </div>

                <!-- Performance Badge -->
                <div class="mt-6 p-4 rounded-xl <?php echo $scorePercentage >= 90 ? 'bg-green-50 border border-green-200' : ($scorePercentage >= 75 ? 'bg-blue-50 border border-blue-200' : ($scorePercentage >= 60 ? 'bg-yellow-50 border border-yellow-200' : 'bg-red-50 border border-red-200')); ?>">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium <?php echo $scorePercentage >= 90 ? 'text-green-800' : ($scorePercentage >= 75 ? 'text-blue-800' : ($scorePercentage >= 60 ? 'text-yellow-800' : 'text-red-800')); ?>">
                                <?php
                                if ($scorePercentage >= 90) echo "Excellent Performance";
                                elseif ($scorePercentage >= 75) echo "Good Performance";
                                elseif ($scorePercentage >= 60) echo "Satisfactory";
                                else echo "Needs Improvement";
                                ?>
                            </p>
                            <p class="text-xs <?php echo $scorePercentage >= 90 ? 'text-green-600' : ($scorePercentage >= 75 ? 'text-blue-600' : ($scorePercentage >= 60 ? 'text-yellow-600' : 'text-red-600')); ?>">
                                <?php echo $attempt['result'] === 'passed' ? 'Passed' : 'Failed'; ?>
                            </p>
                        </div>
                        <div class="text-2xl <?php echo $scorePercentage >= 90 ? 'text-green-500' : ($scorePercentage >= 75 ? 'text-blue-500' : ($scorePercentage >= 60 ? 'text-yellow-500' : 'text-red-500')); ?>">
                            <?php
                            if ($scorePercentage >= 90) echo '<i class="fas fa-trophy"></i>';
                            elseif ($scorePercentage >= 75) echo '<i class="fas fa-medal"></i>';
                            elseif ($scorePercentage >= 60) echo '<i class="fas fa-thumbs-up"></i>';
                            else echo '<i class="fas fa-exclamation-triangle"></i>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Analytics -->
    <div class="xl:col-span-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 animate-fade-in hover:shadow-xl transition-shadow duration-200">
            <div class="bg-blue-500 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Performance Analytics
                </h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Score Visualization -->
                    <div class="text-center">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Overall Score</h4>
                        <div class="relative inline-flex items-center justify-center">
                            <svg class="w-32 h-32 progress-ring">
                                <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="8" fill="transparent"></circle>
                                <circle cx="64" cy="64" r="56" stroke="<?php echo $scorePercentage >= 75 ? '#10b981' : ($scorePercentage >= 60 ? '#f59e0b' : '#ef4444'); ?>"
                                    stroke-width="8" fill="transparent"
                                    stroke-dasharray="<?php echo 2 * pi() * 56; ?>"
                                    stroke-dashoffset="<?php echo 2 * pi() * 56 * (1 - $scorePercentage / 100); ?>"
                                    class="progress-ring-circle"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-3xl font-bold <?php echo $scorePercentage >= 75 ? 'text-green-600' : ($scorePercentage >= 60 ? 'text-yellow-600' : 'text-red-600'); ?>">
                                        <?php echo $scorePercentage; ?>%
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo $totalPointsEarned; ?>/<?php echo $totalPossiblePoints; ?> pts
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comparison with Class Average -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Performance Comparison</h4>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-700">Student Score</span>
                                    <span class="font-bold <?php echo $scorePercentage >= $classAvgPercentage ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $scorePercentage; ?>%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="<?php echo $scorePercentage >= 75 ? 'bg-green-500' : ($scorePercentage >= 60 ? 'bg-yellow-500' : 'bg-red-500'); ?> h-3 rounded-full transition-all duration-1000"
                                        style="width: <?php echo $scorePercentage; ?>%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-700">Class Average</span>
                                    <span class="font-bold text-gray-600"><?php echo $classAvgPercentage; ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gray-500 h-3 rounded-full transition-all duration-1000"
                                        style="width: <?php echo $classAvgPercentage; ?>%"></div>
                                </div>
                            </div>

                            <!-- Performance Indicator -->
                            <div class="mt-4 p-3 rounded-lg <?php echo $scorePercentage >= $classAvgPercentage ? 'bg-green-50 border border-green-200' : 'bg-orange-50 border border-orange-200'; ?>">
                                <div class="flex items-center">
                                    <i class="fas <?php echo $scorePercentage >= $classAvgPercentage ? 'fa-arrow-up text-green-500' : 'fa-arrow-down text-orange-500'; ?> mr-2"></i>
                                    <span class="text-sm font-medium <?php echo $scorePercentage >= $classAvgPercentage ? 'text-green-800' : 'text-orange-800'; ?>">
                                        <?php
                                        $diff = abs($scorePercentage - $classAvgPercentage);
                                        echo $scorePercentage >= $classAvgPercentage ?
                                            ($diff > 0 ? "{$diff}% above class average" : "At class average") :
                                            "{$diff}% below class average";
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>