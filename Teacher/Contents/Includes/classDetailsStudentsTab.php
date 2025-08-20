<div id="students-tab" class="tab-content p-6 hidden">
    <?php if (empty($students)): ?>
        <!-- Empty State -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="text-center py-16 px-6">
                <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Students Enrolled Yet</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Share your class code with students to get them enrolled in your class.</p>

                <!-- Class Code Display -->
                <div class="max-w-sm mx-auto">
                    <label class="block text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Class Code</label>
                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between">
                        <span class="font-mono font-bold text-xl text-gray-800 tracking-wider"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                        <button class="copy-code-btn p-2 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors duration-200"
                            data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>"
                            title="Copy class code">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Students can use this code to join your class</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Students Table -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Table Header -->
            <div class="bg-white border-b border-gray-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Enrolled Students</h3>
                            <p class="text-sm text-gray-600">Manage and view all students in this class</p>
                        </div>
                    </div>
                    <div class="bg-white border-2 border-green-200 px-4 py-2 rounded-xl shadow-sm">
                        <div class="text-center">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Students</p>
                            <p class="text-xl font-bold text-green-600"><?php echo count($students); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Student Name
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                    Email Address
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    Student ID
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Academic Strand
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Grade Level
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                    </svg>
                                    Date Joined
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($students as $student): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <!-- Profile Picture -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex justify-center">
                                        <?php if (!empty($student['profile_picture'])): ?>
                                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 shadow-sm"
                                                src="../../../Uploads/ProfilePictures/<?php echo htmlspecialchars($student['profile_picture']); ?>"
                                                alt="<?php echo htmlspecialchars($student['student_name'] ?? 'Student'); ?>">
                                        <?php else: ?>
                                            <div class="h-12 w-12 rounded-full bg-gray-200 border-2 border-gray-300 flex items-center justify-center shadow-sm">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Student Name -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-semibold text-gray-900">
                                        <?php echo htmlspecialchars($student['student_name'] ?? 'N/A'); ?>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-600 max-w-xs truncate" title="<?php echo htmlspecialchars($student['student_email'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($student['student_email'] ?? 'N/A'); ?>
                                    </div>
                                </td>

                                <!-- Student ID -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-800">
                                        <?php echo htmlspecialchars($student['student_id'] ?? 'N/A'); ?>
                                    </span>
                                </td>

                                <!-- Academic Strand -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-800">
                                        <?php echo htmlspecialchars($student['strand'] ?? 'N/A'); ?>
                                    </span>
                                </td>

                                <!-- Grade Level -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-800">
                                        <?php echo htmlspecialchars($student['grade_level'] ?? 'N/A'); ?>
                                    </span>
                                </td>

                                <!-- Date Joined -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-600">
                                        <?php echo date('M j, Y', strtotime($student['enrollment_date'])); ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo date('g:i A', strtotime($student['enrollment_date'])); ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href=""
                                        class="inline-flex items-center px-3 py-1.5 border border-blue-300 text-xs font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Info
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>