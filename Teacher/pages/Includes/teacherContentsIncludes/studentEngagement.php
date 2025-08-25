<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Student Engagement</h3>
        <?php if (!empty($uniqueStudents)): ?>
            <a href="../Reports/quizResults.php" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                <span>View All</span>
                <i class="fas fa-chevron-right text-xs"></i>
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($uniqueStudents)): ?>
        <div class="text-center py-12">
            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
            <p class="text-gray-500 mb-2">No student engagement data yet</p>
            <p class="text-sm text-gray-400">Add your first class to get started</p>
        </div>
    <?php else: ?>
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                <div class="text-xs font-medium text-blue-600 uppercase tracking-wide mb-1">Total Students</div>
                <div class="text-2xl font-bold text-gray-900"><?php echo $totalStudentsEnrolled ?? 0; ?></div>
                <div class="text-sm text-gray-500 mt-1">Across <?php echo $totalClassesCount; ?> classes</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                <div class="text-xs font-medium text-green-600 uppercase tracking-wide mb-1">Quizzes Created</div>
                <div class="text-2xl font-bold text-gray-900"><?php echo $totalQuizzesCreated ?? 0; ?></div>
                <div class="text-sm text-gray-500 mt-1">Published by you</div>
            </div>
        </div>

        <!-- Student Performance Table -->
        <div class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Classes</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    // For each student, we'll need to find their performance metrics
                    // This would normally be in the studentEngagementFunction.php but we'll add it here temporarily
                    foreach ($uniqueStudents as $studentId => &$student) {
                        // Initialize with defaults
                        $student['best_quiz_name'] = '';
                        $student['needs_improvement_quiz_name'] = '';
                        $student['best_score_value'] = 0;
                        $student['needs_improvement_score'] = 100;

                        // Get all quiz attempts for this student
                        if (isset($students) && !empty($students)) {
                            $studentQuizScores = [];

                            // Find best and worst performing quizzes
                            foreach ($students as $attempt) {
                                if ($attempt['student_id'] == $studentId) {
                                    $quizId = $attempt['quiz_id'];

                                    // Keep track of latest score for each quiz
                                    if (
                                        !isset($studentQuizScores[$quizId]) ||
                                        $attempt['score_percent'] > $studentQuizScores[$quizId]['score']
                                    ) {
                                        $studentQuizScores[$quizId] = [
                                            'score' => $attempt['score_percent'],
                                            'quiz_title' => $attempt['quiz_title']
                                        ];
                                    }
                                }
                            }

                            // Find best and needs improvement quizzes
                            foreach ($studentQuizScores as $quizId => $data) {
                                if ($data['score'] > $student['best_score_value']) {
                                    $student['best_score_value'] = $data['score'];
                                    $student['best_quiz_name'] = $data['quiz_title'];
                                }
                                if ($data['score'] < $student['needs_improvement_score']) {
                                    $student['needs_improvement_score'] = $data['score'];
                                    $student['needs_improvement_quiz_name'] = $data['quiz_title'];
                                }
                            }
                        }

                        // Reset if no quizzes found
                        if ($student['needs_improvement_score'] == 100) {
                            $student['needs_improvement_score'] = 0;
                        }
                    }
                    unset($student); // Break the reference
                    ?>

                    <?php foreach (array_slice($uniqueStudents, 0, 5) as $studentId => $student): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php if (!empty($student['profile_picture'])): ?>
                                            <img class="h-10 w-10 rounded-full" src="../../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>" alt="">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-semibold"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($student['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($student['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo $student['enrolled_classes']; ?> out of <?php echo $totalClassesCount; ?>
                                </span>
                                <div class="text-xs text-gray-500 mt-1"> Class Enrolled In</div>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                   <?php echo $student['attempts']; ?>
                                </span>
                                <div class="text-sm  mt-1"> Total Quiz Submitted</div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (count($uniqueStudents) > 5): ?>
            <div class="text-center mt-4">
                <a href="../Reports/quizResults.php" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                    View all students
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>