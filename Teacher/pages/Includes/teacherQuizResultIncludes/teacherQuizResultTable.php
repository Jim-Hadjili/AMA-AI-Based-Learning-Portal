<div class="w-full">
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 shadow-lg rounded-xl overflow-hidden mb-8 border border-blue-200">
        <!-- Table Header -->
        <div class="bg-white border-b border-blue-100 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Student Performance Overview</h3>
                        <p class="text-sm text-gray-600">Comprehensive view of all student quiz attempts and scores</p>
                    </div>
                </div>
                <?php if (!empty($uniqueStudents)): ?>
                    <div class="bg-white px-4 py-2 rounded-xl shadow-sm">
                        <div class="text-center">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Students</p>
                            <p class="text-xl font-bold text-green-600"><?php echo count($uniqueStudents); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Table Content -->
        <div class="bg-white">
            <?php if (empty($uniqueStudents)): ?>
                <div class="text-center py-16 px-6">
                    <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Student Attempts Yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Students haven't attempted this quiz yet. Once they start taking the quiz, their results will appear here.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Student Information
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                        Student ID
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        Grade Level
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        Academic Strand
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        Total Attempts
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        Best Score
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Actions
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($uniqueStudents as $studentId => $student): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <!-- Student Information -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0">
                                                <?php if (!empty($studentInfo[$studentId]['profile_picture'])): ?>
                                                    <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 shadow-sm"
                                                        src="../../Uploads/ProfilePictures/<?php echo htmlspecialchars($studentInfo[$studentId]['profile_picture']); ?>"
                                                        alt="<?php echo htmlspecialchars($student['name']); ?>">
                                                <?php else: ?>
                                                    <div class="flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 rounded-full h-12 w-12 border-2 border-gray-200 shadow-sm">
                                                        <span class="text-white font-bold text-lg"><?php echo strtoupper(substr($student['name'], 0, 2)); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-semibold text-gray-900 mb-1"><?php echo htmlspecialchars($student['name']); ?></div>
                                                <div class="text-xs text-gray-500 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                                    </svg>
                                                    <span class="truncate"><?php echo htmlspecialchars($student['email']); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Student ID -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 text-sm font-semibold">
                                            <?php echo htmlspecialchars($studentInfo[$studentId]['student_id'] ?? 'Unknown'); ?>
                                        </span>
                                    </td>

                                    <!-- Grade Level -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 text-sm font-semibold">
                                            <?php echo htmlspecialchars($studentInfo[$studentId]['formatted_grade'] ?? 'Unknown'); ?>
                                        </span>
                                    </td>

                                    <!-- Academic Strand -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 text-sm font-semibold ">
                                            <?php echo htmlspecialchars(ucfirst($studentInfo[$studentId]['strand'] ?? 'Unknown')); ?>
                                        </span>
                                    </td>

                                    <!-- Total Attempts -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="w-8 h-8 text-gray-700 flex items-center justify-center font-semibold text-sm">
                                                <?php echo $student['attempts']; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Best Score -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <div class="text-lg font-semibold <?php echo $student['best_percent'] >= 65 ? 'text-green-600' : 'text-red-600'; ?>">
                                                <?php echo $student['best_percent']; ?>%
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="viewStudentAttempt.php?attempt_id=<?php echo $student['latest_attempt_id']; ?>" 
                                           class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-xs font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Attempts
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>