<div class="bg-white shadow rounded-lg overflow-hidden mb-8">
    <div class="border-b border-gray-200 px-6 py-5">
        <h1 class="text-xl font-bold text-gray-900">Student Quiz Attempt</h1>
    </div>
    <div class="px-6 py-5">
        <?php
        // Get the newest attempt data (last element in chronological order)
        $newestAttempt = end($chronologicalAttempts);
        
        // Fetch total points and earned points for the newest attempt
        $newestAttemptsScoreStmt = $conn->prepare("
            SELECT SUM(qq.question_points) as total_points, SUM(sa.points_awarded) as earned_points
            FROM student_answers_tb sa
            JOIN quiz_questions_tb qq ON sa.question_id = qq.question_id
            WHERE sa.attempt_id = ?
        ");
        $newestAttemptsScoreStmt->bind_param("i", $newestAttempt['attempt_id']);
        $newestAttemptsScoreStmt->execute();
        $newestScoreData = $newestAttemptsScoreStmt->get_result()->fetch_assoc();
        $newestTotalPoints = $newestScoreData['total_points'] ?? 0;
        $newestEarnedPoints = $newestScoreData['earned_points'] ?? 0;
        
        // Calculate the correct percentage
        $newestScorePercent = ($newestTotalPoints > 0) ? round(($newestEarnedPoints / $newestTotalPoints) * 100) : 0;
        
        // Reset array pointer after using end()
        reset($chronologicalAttempts);
        ?>
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
                <p class="mt-1 text-sm text-gray-900"><?php echo htmlspecialchars($newestAttempt['quiz_title']); ?></p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Latest Attempt Date</h3>
                <p class="mt-1 text-sm text-gray-900"><?php echo date('F j, Y, g:i a', strtotime($newestAttempt['end_time'])); ?></p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Latest Duration</h3>
                <?php
                $newestStartTime = new DateTime($newestAttempt['start_time']);
                $newestEndTime = new DateTime($newestAttempt['end_time']);
                $newestDuration = $newestStartTime->diff($newestEndTime);
                $newestDurationStr = '';

                if ($newestDuration->h > 0) {
                    $newestDurationStr .= $newestDuration->h . ' hour' . ($newestDuration->h > 1 ? 's' : '') . ' ';
                }
                if ($newestDuration->i > 0) {
                    $newestDurationStr .= $newestDuration->i . ' minute' . ($newestDuration->i > 1 ? 's' : '') . ' ';
                }
                if ($newestDuration->s > 0 || $newestDurationStr === '') {
                    $newestDurationStr .= $newestDuration->s . ' second' . ($newestDuration->s !== 1 ? 's' : '');
                }
                ?>
                <p class="mt-1 text-sm text-gray-900"><?php echo $newestDurationStr; ?></p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Latest Score</h3>
                <p class="mt-1 text-sm font-medium <?php echo strtolower($newestAttempt['result']) === 'passed' ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo "{$newestEarnedPoints}/{$newestTotalPoints} ({$newestScorePercent}%)"; ?>
                </p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Latest Result</h3>
                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo strtolower($newestAttempt['result']) === 'passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo ucfirst($newestAttempt['result']); ?>
                </span>
            </div>
        </div>
    </div>
</div>