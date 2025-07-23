<div id="students-tab" class="tab-content p-6 hidden">
    <?php if (empty($students)): ?>
        <div class="text-center py-8">
            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Enrolled</h3>
            <p class="text-gray-500 mb-4">Share your class code with students to get them enrolled.</p>
            <div class="max-w-xs mx-auto p-3 bg-gray-50 rounded-lg flex items-center justify-between mb-4">
                <span class="font-mono font-medium text-gray-800"><?php echo htmlspecialchars($classDetails['class_code']); ?></span>
                <button class="copy-code-btn text-purple-primary hover:text-purple-dark" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>
    <?php else: ?>
        <!-- <div class="mb-4 flex justify-between items-center">
            <h3 class="font-medium text-gray-900">Enrolled Students (<?php echo count($students); ?>)</h3>
            <div class="flex items-center">
                <div class="relative text-gray-500">
                    <input type="text" id="student-search" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-60 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Search students...">
                    <i class="fas fa-search absolute left-3 top-2.5"></i>
                </div>
            </div>
        </div> -->

        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 ">
                <thead class="bg-gray-50 ">
                    <tr>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Profile</th>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Student ID</th>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Strand</th>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Grade Level</th>
                        <th scope="col" class="px-6 text-center py-3 text-left text-xs font-bold text-black uppercase tracking-wider">Joined</th>
                        <!-- <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th> -->
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($students as $student): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center mx-auto">
                                    <?php if (!empty($student['st_profile_img'])): ?>
                                        <img class="h-10 w-10 rounded-full object-cover" src="<?php echo htmlspecialchars($student['st_profile_img']); ?>" alt="<?php echo htmlspecialchars($student['student_name'] ?? 'Student'); ?>">
                                    <?php else: ?>
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php echo htmlspecialchars($student['student_name'] ?? 'N/A'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($student['student_email'] ?? ''); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($student['student_id'] ?? 'N/A'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($student['strand'] ?? 'N/A'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($student['grade_level'] ?? 'N/A'); ?>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?>
                            </td>
                            <!-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="view-student-btn text-purple-primary hover:text-purple-dark mr-3" data-student-id="<?php echo $student['st_id']; ?>">
                                    View Progress
                                </button>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>