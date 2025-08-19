<div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8 border border-gray-200">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between px-8 py-6 border-b border-gray-100">
        <div class="flex items-center gap-3 mb-4 md:mb-0">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path d="M12 14l6.16-3.422A2 2 0 0120 12.764V17a2 2 0 01-2 2H6a2 2 0 01-2-2v-4.236a2 2 0 011.84-2.186L12 14z"/>
            </svg>
            <div>
                <h1 class="text-2xl font-extrabold text-blue-900">Student Quiz Attempt</h1>
                <p class="text-sm text-gray-500">Review the latest quiz attempt and student details</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-blue-100 px-4 py-2 rounded text-center">
                <span class="block text-xs text-gray-600 font-semibold">Total Attempts</span>
                <span class="block text-xl font-bold text-blue-800">
                    <?php echo count($chronologicalAttempts); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="px-8 py-6">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Student Info -->
            <div class="bg-gray-50 rounded-lg p-5 flex gap-4 items-center border border-gray-200">
                <?php if (!empty($attempt['profile_picture'])): ?>
                    <img class="h-16 w-16 rounded-full object-cover border-2 border-blue-300 shadow" src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($attempt['profile_picture']); ?>" alt="<?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?>">
                <?php else: ?>
                    <div class="h-16 w-16 flex items-center justify-center bg-blue-200 rounded-full border-2 border-blue-300 shadow">
                        <span class="text-blue-800 font-bold text-xl"><?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?></span>
                    </div>
                <?php endif; ?>
                <div>
                    <p class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($attempt['student_name']); ?></p>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-blue-400 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 12v1a4 4 0 01-8 0v-1"/><path d="M12 17v2"/><path d="M12 7v2"/><path d="M12 3v2"/></svg>
                        <?php echo htmlspecialchars($attempt['student_email']); ?>
                    </p>
                    <div class="mt-2 flex flex-wrap gap-2 text-xs">
                        <span class="bg-blue-200 text-blue-700 px-2 py-1 rounded font-medium">
                            Grade: 
                            <?php
                                // Format grade_level (e.g., 'grade_11' => 'Grade 11')
                                $gradeFormatted = preg_replace('/^grade[_\s]?(\d+)/i', 'Grade $1', $attempt['grade_level']);
                                echo htmlspecialchars($gradeFormatted);
                            ?>
                        </span>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded font-medium">Strand: <?php echo htmlspecialchars($attempt['strand']); ?></span>
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded font-medium">Student ID: <?php echo htmlspecialchars($attempt['student_id']); ?></span>
                    </div>
                </div>
            </div>
            <!-- Quiz Info -->
            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Quiz Information</h3>
                <div class="mb-2">
                    <span class="text-xs text-gray-500">Title:</span>
                    <span class="text-base text-gray-900 font-medium">
                        <?php
                            // Get the original quiz title (root quiz)
                            $rootQuizId = $root_quiz_id ?? null;
                            $originalQuizTitle = '';
                            if ($rootQuizId) {
                                $origQuizStmt = $conn->prepare("SELECT quiz_title FROM quizzes_tb WHERE quiz_id = ?");
                                $origQuizStmt->bind_param("i", $rootQuizId);
                                $origQuizStmt->execute();
                                $origQuizRes = $origQuizStmt->get_result();
                                if ($origQuizRow = $origQuizRes->fetch_assoc()) {
                                    $originalQuizTitle = $origQuizRow['quiz_title'];
                                }
                            }
                            echo htmlspecialchars($originalQuizTitle);
                        ?>
                    </span>
                </div>
                <div class="mb-2">
                    <span class="text-xs text-gray-500">Class:</span>
                    <span class="text-base text-gray-900 font-medium"><?php echo htmlspecialchars($attempt['class_name'] ?? ''); ?></span>
                </div>
            </div>
            <!-- Attempt Info -->
            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Latest Attempt</h3>
                <div class="mb-2">
                    <span class="text-xs text-gray-500">Date:</span>
                    <span class="text-base text-gray-900 font-medium"><?php echo date('F j, Y, g:i a', strtotime($newestAttempt['end_time'])); ?></span>
                </div>
                <div class="mb-2">
                    <span class="text-xs text-gray-500">Score:</span>
                    <span class="text-base font-bold <?php echo strtolower($newestAttempt['result']) === 'passed' ? 'text-green-600' : 'text-red-600'; ?>">
                        <?php echo "{$newestEarnedPoints}/{$newestTotalPoints} ({$newestScorePercent}%)"; ?>
                    </span>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Result:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo strtolower($newestAttempt['result']) === 'passed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <?php echo ucfirst($newestAttempt['result']); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>