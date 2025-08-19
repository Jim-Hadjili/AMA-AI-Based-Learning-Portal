<div class="bg-blue-100 shadow-lg rounded-xl overflow-hidden mb-8 border-2">
    <!-- Header Section -->
    <div class="bg-white border-b border-blue-100">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between px-6 py-5">
            <div class="flex items-center gap-4 mb-4 lg:mb-0">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422A2 2 0 0120 12.764V17a2 2 0 01-2 2H6a2 2 0 01-2-2v-4.236a2 2 0 011.84-2.186L12 14z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Student Quiz Attempt Review</h1>
                    <p class="text-sm text-gray-600">Detailed analysis of student performance and attempt history</p>
                </div>
            </div>
            
            <!-- Total Attempts Badge -->
            <div class="bg-white border-2 px-6 py-3 rounded-xl shadow-sm">
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Attempts</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo count($chronologicalAttempts); ?></p>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Content Section -->
    <div class="p-6">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- Student Information Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Student Information
                    </h3>
                </div>
                
                <div class="flex items-start gap-4">
                    <!-- Profile Picture -->
                    <div class="flex-shrink-0">
                        <?php if (!empty($attempt['profile_picture'])): ?>
                            <img class="h-16 w-16 rounded-full object-cover border-2 border-blue-200 shadow-md" 
                                 src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($attempt['profile_picture']); ?>" 
                                 alt="<?php echo htmlspecialchars($attempt['student_name']); ?>">
                        <?php else: ?>
                            <div class="h-16 w-16 flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 rounded-full border-2 border-blue-200 shadow-md">
                                <span class="text-white font-bold text-xl"><?php echo strtoupper(substr($attempt['student_name'], 0, 2)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Student Details -->
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($attempt['student_name']); ?></h4>
                        
                        <div class="space-y-2">
                            <!-- Email -->
                            <div class="flex items-center gap-2 text-md font-semibold  px-3 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                                <span class="truncate"><?php echo htmlspecialchars($attempt['student_email']); ?></span>
                            </div>
                            
                            <!-- Student ID -->
                            <div class="flex items-center gap-2 text-md font- px-3 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                                <span class="font-semibold">ID #:</span> <span><?php echo htmlspecialchars($attempt['student_id']); ?></span>
                            </div>
                        </div>
                        
                        <!-- Academic Info Tags -->
                        <div class="space-y-2 mt-2">
                            <!-- Grade Level -->
                            <div class="flex items-center gap-2 text-md px-3 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 17v-2a4 4 0 014-4h8a4 4 0 014 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <span class="font-semibold">Grade:</span>
                                <span>
                                    <?php
                                        $gradeFormatted = preg_replace('/^grade[_\s]?(\d+)/i', 'Grade $1', $attempt['grade_level']);
                                        echo htmlspecialchars($gradeFormatted);
                                    ?>
                                </span>
                            </div>
                            <!-- Strand -->
                            <div class="flex items-center gap-2 text-md px-3 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 20l9-5-9-5-9 5 9 5z"/>
                                    <path d="M12 12V4"/>
                                </svg>
                                <span class="font-semibold">Strand:</span>
                                <span><?php echo htmlspecialchars($attempt['strand']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Information Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Quiz Details
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-md font-bold uppercase tracking-wide mb-1">Quiz Title:</label>
                        <p class="text-base font-medium text-gray-900 leading-relaxed">
                            <?php
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
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-md font-bold uppercase tracking-wide mb-1">Class:</label>
                        <p class="text-base font-medium text-gray-900"><?php echo htmlspecialchars($attempt['class_name'] ?? 'Not specified'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Latest Attempt Results Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-2 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Latest Attempt
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-md font-bold uppercase tracking-wide mb-1">Completed On:</label>
                        <p class="text-base font-medium text-gray-900"><?php echo date('F j, Y', strtotime($newestAttempt['end_time'])); ?></p>
                        <p class="text-sm text-gray-600"><?php echo date('g:i A', strtotime($newestAttempt['end_time'])); ?></p>
                    </div>
                    
                    <!-- Score Display -->
                    <div>
                        <label class="block text-md font-bold uppercase tracking-wide mb-2">Score:</label>
                        <div class="flex items-center gap-3">
                            <div class="text-2xl font-bold <?php echo strtolower($newestAttempt['result']) === 'passed' ? 'text-green-600' : 'text-red-600'; ?>">
                                <?php echo $newestScorePercent; ?>%
                            </div>
                            <div class="text-sm text-gray-600">
                                <?php echo "{$newestEarnedPoints} / {$newestTotalPoints} points"; ?>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="<?php echo strtolower($newestAttempt['result']) === 'passed' ? 'bg-green-500' : 'bg-red-500'; ?> h-2 rounded-full transition-all duration-300" 
                                 style="width: <?php echo $newestScorePercent; ?>%"></div>
                        </div>
                    </div>
                    
                    <!-- Result Badge -->
                    <div>
                        <label class="block text-md font-bold uppercase tracking-wide mb-2">Result:</label>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold <?php echo strtolower($newestAttempt['result']) === 'passed' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'; ?>">
                            <?php if (strtolower($newestAttempt['result']) === 'passed'): ?>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            <?php else: ?>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            <?php endif; ?>
                            <?php echo ucfirst($newestAttempt['result']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>