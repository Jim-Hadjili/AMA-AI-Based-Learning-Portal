<div id="studentModal-<?php echo $studentId; ?>" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto transition-all duration-300">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-white border-b border-gray-100 px-6 py-5 rounded-t-xl flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0 h-12 w-12 mr-2">
                    <?php
                    // Get student profile from students_profiles_tb if available
                    $profile = [];
                    if (isset($studentEnrollments[$studentId]['profile'])) {
                        $profile = $studentEnrollments[$studentId]['profile'];
                    } else {
                        // Try to get from students_profiles_tb if not set
                        $profileQuery = $conn->prepare("SELECT * FROM students_profiles_tb WHERE st_id = ?");
                        $profileQuery->bind_param("s", $studentId);
                        $profileQuery->execute();
                        $profileRes = $profileQuery->get_result();
                        if ($profileRes && $profileRes->num_rows > 0) {
                            $profile = $profileRes->fetch_assoc();
                        } else {
                            $profile = $student;
                        }
                    }
                    ?>
                    <?php if (!empty($profile['profile_picture'])): ?>
                        <img class="h-12 w-12 rounded-full border-2 border-blue-100" src="../../../Uploads/ProfilePictures/<?php echo htmlspecialchars($profile['profile_picture']); ?>" alt="">
                    <?php else: ?>
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-200">
                            <span class="text-blue-600 font-semibold"><?php echo strtoupper(substr($profile['st_userName'] ?? $student['name'], 0, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($profile['st_userName'] ?? $student['name']); ?></h3>
                    <p class="text-gray-500"><?php echo htmlspecialchars($profile['st_email'] ?? $student['email']); ?></p>
                    <div class="mt-2 text-sm text-gray-700">
                        <div><span class="font-semibold">Position:</span> <?php echo htmlspecialchars($profile['st_position'] ?? 'student'); ?></div>
                        <div><span class="font-semibold">ID Number:</span> <?php echo htmlspecialchars($profile['student_id'] ?? $studentId); ?></div>
                        <div><span class="font-semibold">Grade Level:</span>
                            <?php
                            // Clean up grade_level display
                            $gradeRaw = $profile['grade_level'] ?? ($student['grade_level'] ?? '');
                            // If multiple grades, pick the latest (or first), or just clean up the string
                            if (is_array($gradeRaw)) {
                                $gradeRaw = end($gradeRaw);
                            }
                            // Replace underscores and commas
                            $gradeClean = preg_replace('/_/', ' ', $gradeRaw);
                            $gradeClean = preg_replace('/,/', ' or ', $gradeClean);
                            echo htmlspecialchars(trim($gradeClean));
                            ?>
                        </div>
                        <div><span class="font-semibold">Strand:</span> <?php echo htmlspecialchars($profile['strand'] ?? ($student['strand'] ?? '')); ?></div>
                        <div><span class="font-semibold">Status:</span> <?php echo htmlspecialchars($profile['status'] ?? ($student['status'] ?? 'Active')); ?></div>
                    </div>
                </div>
            </div>
            <button onclick="closeStudentModal('<?php echo $studentId; ?>')" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
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
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Quizzes Submitted</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($studentEnrollments[$studentId]['classes'] as $class): ?>
                                    <?php
                                    $classId = $class['class_id'];
                                    $totalOriginalQuizzes = $availableQuizzesPerClass[$classId] ?? 0;
                                    $submittedQuizzes = 0;
                                    if (isset($students) && !empty($students)) {
                                        $submittedQuizIds = [];
                                        foreach ($students as $attempt) {
                                            if (
                                                $attempt['student_id'] == $studentId &&
                                                $attempt['class_id'] == $classId &&
                                                isset($attempt['quiz_id']) &&
                                                isset($attempt['quiz_title']) &&
                                                (!isset($attempt['parent_quiz_id']) || !$attempt['parent_quiz_id'])
                                            ) {
                                                $submittedQuizIds[$attempt['quiz_id']] = true;
                                            }
                                        }
                                        $submittedQuizzes = count($submittedQuizIds);
                                    }
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($class['class_name']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($class['enrollment_date'])); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                <?php echo $submittedQuizzes . ' out of ' . $totalOriginalQuizzes; ?>
                                            </span>
                                        </td>
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
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 rounded-b-xl flex justify-end items-center gap-2">
            <a href="../Reports/studentProfile.php?student_id=<?php echo $studentId; ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all duration-200">
                View Full Profile
            </a>
            <button onclick="closeStudentModal('<?php echo $studentId; ?>')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-all duration-200">
                Close
            </button>
        </div>
    </div>
</div>