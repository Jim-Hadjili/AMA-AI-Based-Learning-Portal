<div class="bg-white shadow rounded-lg overflow-hidden mb-8">
    <div class="border-b border-gray-200 px-6 py-5">
        <h1 class="text-xl font-bold text-gray-900">Student Quiz Attempt</h1>
    </div>
    <div class="px-6 py-5">
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Student</h3>
                <div class="mt-1 flex items-center">
                    <?php if (!empty($attempt['profile_picture'])): ?>
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($attempt['profile_picture']); ?>"
                                alt="<?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?>">
                        </div>
                    <?php else: ?>
                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-blue-100 rounded-full">
                            <span class="text-blue-800 font-medium"><?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($attempt['student_name']); ?></p>
                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($attempt['student_email']); ?></p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Quiz</h3>
                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($attempt['quiz_title']); ?></p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Attempt Date</h3>
                <p class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y, g:i a', strtotime($attempt['end_time'])); ?></p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Duration</h3>
                <p class="mt-1 text-sm text-gray-900"><?php echo $durationStr; ?></p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Score</h3>
                <p class="mt-1 text-sm font-medium <?php echo strtolower($attempt['result']) === 'passed' ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo "{$earnedPoints}/{$totalPoints} ({$scorePercent}%)"; ?>
                </p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Result</h3>
                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo strtolower($attempt['result']) === 'passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo ucfirst($attempt['result']); ?>
                </span>
            </div>
        </div>
    </div>
</div>