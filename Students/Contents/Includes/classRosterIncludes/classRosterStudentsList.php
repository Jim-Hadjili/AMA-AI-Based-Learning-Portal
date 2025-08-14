<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="h-1 bg-blue-500"></div>
    <div class="p-5 border-b border-gray-100 flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
            <span class="flex-shrink-0 w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
            </span>
            Class Members
            <span class="ml-1 text-sm font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                <?php echo count($classmates); ?>
            </span>
        </h2>
        <?php if (count($classmates) > 0): ?>
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative flex-1 min-w-[220px]">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input id="rosterSearch" type="text" placeholder="Search students..."
                        class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring focus:ring-blue-100 text-sm transition bg-gray-50 focus:bg-white outline-none">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if (count($classmates) > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Student ID #</th>
                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Grade Level</th>
                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Strand</th>
                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-center text-[11px] font-semibold tracking-wider text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody id="rosterTableBody" class="bg-white divide-y divide-gray-100 text-sm">
                    <?php foreach ($classmates as $index => $student):
                        $status = strtolower($student['status'] ?? 'unknown');
                        $statusColors = match ($status) {
                            'active'   => 'bg-green-100 text-green-700',
                            'inactive' => 'bg-gray-200 text-gray-700',
                            'pending'  => 'bg-yellow-100 text-yellow-700',
                            default    => 'bg-gray-100 text-gray-600'
                        };
                    ?>
                        <tr class="student-row hover:bg-blue-50/40 transition cursor-pointer <?php echo ($student['st_id'] === $student_id) ? 'bg-blue-50/60 ring-1 ring-blue-100' : ''; ?>"
                            data-name="<?php echo htmlspecialchars(strtolower($student['student_name'])); ?>"
                            data-status="<?php echo htmlspecialchars($status); ?>"
                            onclick="openStudentModal('<?php echo $index; ?>')">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center overflow-hidden border border-blue-100">
                                            <?php if (!empty($student['profile_picture']) && file_exists('../../../Uploads/ProfilePictures/' . $student['profile_picture'])): ?>
                                                <img src="../../../Uploads/ProfilePictures/<?php echo $student['profile_picture']; ?>" alt="Profile" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <span class="text-blue-600 font-semibold">
                                                    <?php
                                                    $initials = explode(' ', trim($student['student_name']));
                                                    echo strtoupper(substr($initials[0] ?? '', 0, 1) . (isset($initials[1]) ? substr($initials[1], 0, 1) : ''));
                                                    ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 flex items-center gap-2">
                                            <?php echo htmlspecialchars($student['student_name']); ?>
                                            <?php if ($student['st_id'] === $student_id): ?>
                                                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[11px] font-semibold">You</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?php echo strtoupper($student['strand'] ?? ''); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                <?php echo htmlspecialchars($student['student_id'] ?? '—'); ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-700">
                                <?php
                                $grade = str_replace('_', ' ', $student['grade_level'] ?? 'Not specified');
                                echo ucwords($grade);
                                ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-700">
                                <?php echo strtoupper($student['strand'] ?? 'N/A'); ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-gray-600"><?php echo htmlspecialchars($student['email']); ?></span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                <?php
                                if (!empty($student['enrollment_date'])) {
                                    $enrollDate = new DateTime($student['enrollment_date']);
                                    echo $enrollDate->format('M d, Y');
                                } else {
                                    echo '—';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold <?php echo $statusColors; ?>">
                                    <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                    <?php echo ucfirst($student['status'] ?? 'Unknown'); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="p-10 text-center">
            <p class="text-gray-500 text-sm">No students enrolled in this class yet.</p>
        </div>
    <?php endif; ?>
</div>