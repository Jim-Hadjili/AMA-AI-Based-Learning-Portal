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
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="showStudentModal('<?php echo $studentId; ?>')">
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
        
        <!-- Student Detail Modals -->
        <?php foreach ($uniqueStudents as $studentId => $student): ?>
            <div id="studentModal-<?php echo $studentId; ?>" class="fixed inset-0 z-50 hidden overflow-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-4xl max-h-[90vh] overflow-auto">
                    <!-- Modal Header -->
                    <div class="px-6 py-4 border-b flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 mr-4">
                                <?php if (!empty($student['profile_picture'])): ?>
                                    <img class="h-12 w-12 rounded-full" src="../../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>" alt="">
                                <?php else: ?>
                                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($student['name']); ?></h3>
                                <p class="text-gray-500"><?php echo htmlspecialchars($student['email']); ?></p>
                            </div>
                        </div>
                        <button onclick="closeStudentModal('<?php echo $studentId; ?>')" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Content -->
                    <div class="p-6">
                        <!-- Student Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-lg p-4 text-center">
                                <div class="text-xs font-medium text-blue-600 uppercase tracking-wide mb-1">Enrolled Classes</div>
                                <div class="text-2xl font-bold text-gray-900"><?php echo $student['enrolled_classes']; ?> / <?php echo $totalClassesCount; ?></div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 text-center">
                                <div class="text-xs font-medium text-green-600 uppercase tracking-wide mb-1">Quizzes Completed</div>
                                <div class="text-2xl font-bold text-gray-900"><?php echo $student['attempts']; ?></div>
                            </div>
                        </div>
                        
                        <!-- Classes Enrolled -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-3">Classes Enrolled</h4>
                            <?php if (isset($studentEnrollments[$studentId]) && !empty($studentEnrollments[$studentId]['classes'])): ?>
                                <div class="bg-white border rounded-lg overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollment Date</th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($studentEnrollments[$studentId]['classes'] as $class): ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($class['class_name']); ?></td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($class['enrollment_date'])); ?></td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                        <a href="../../Contents/Tabs/classDetails.php?class_id=<?php echo $class['class_id']; ?>" 
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                            Go to Class
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-gray-500 italic">No classes found.</div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Performance Summary -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold mb-3">Performance Summary</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white border rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Best Score</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-green-600"><?php echo $student['best_percent']; ?>%</span>
                                        <span class="text-sm text-gray-500"><?php echo htmlspecialchars($student['best_quiz_name']); ?></span>
                                    </div>
                                </div>
                                <div class="bg-white border rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Average Score</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-blue-600"><?php echo $student['avg_percent']; ?>%</span>
                                        <span class="text-sm text-gray-500">Across all quizzes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity Status -->
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Activity Status</h4>
                            <div class="bg-white border rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Activity Level</span>
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        <?php if ($student['activity_level'] == 'High'): ?>
                                            bg-green-100 text-green-800
                                        <?php elseif ($student['activity_level'] == 'Medium'): ?>
                                            bg-yellow-100 text-yellow-800
                                        <?php else: ?>
                                            bg-red-100 text-red-800
                                        <?php endif; ?>
                                    ">
                                        <?php echo $student['activity_level']; ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Days Enrolled</span>
                                    <span class="text-sm text-gray-500"><?php echo $student['days_enrolled']; ?> days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t text-right">
                        <a href="../Reports/studentProfile.php?student_id=<?php echo $studentId; ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            View Full Profile
                        </a>
                        <button onclick="closeStudentModal('<?php echo $studentId; ?>')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Add JavaScript for modal functionality -->
<script>
    function showStudentModal(studentId) {
        document.getElementById(`studentModal-${studentId}`).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeStudentModal(studentId) {
        document.getElementById(`studentModal-${studentId}`).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Close modal when clicking outside of it
    document.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('[id^="studentModal-"]');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
</script>