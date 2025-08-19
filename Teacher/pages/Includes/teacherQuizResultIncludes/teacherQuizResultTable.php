<div class="bg-white shadow rounded-lg overflow-hidden mb-8">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Students
        </h3>
    </div>
    <div class="overflow-x-auto">
        <?php if (empty($uniqueStudents)): ?>
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No attempts yet</h3>
                <p class="text-gray-500 mt-2">Students haven't attempted this quiz yet.</p>
            </div>
        <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Strand</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Score</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($uniqueStudents as $studentId => $student): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php if (!empty($studentInfo[$studentId]['profile_picture'])): ?>
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($studentInfo[$studentId]['profile_picture']); ?>"
                                                alt="<?php echo htmlspecialchars(substr($student['name'], 0, 2)); ?>">
                                        <?php else: ?>
                                            <div class="flex items-center justify-center bg-blue-100 rounded-full h-10 w-10">
                                                <span class="text-blue-800 font-medium"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($student['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($student['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($studentInfo[$studentId]['student_id'] ?? 'Unknown'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($studentInfo[$studentId]['formatted_grade'] ?? 'Unknown'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars(ucfirst($studentInfo[$studentId]['strand'] ?? 'Unknown')); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo $student['attempts']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium <?php echo $student['best_percent'] >= 65 ? 'text-green-600' : 'text-red-600'; ?>">
                                    <?php echo $student['best_percent']; ?>%
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="viewStudentAttempt.php?attempt_id=<?php echo $student['latest_attempt_id']; ?>" class="text-blue-600 hover:text-blue-900">View Latest</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>