<div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <div class="p-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Students Card -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-1">
                    <span class="text-sm font-medium text-gray-600">Students</span>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <span class="text-xl font-bold text-gray-900"><?php echo $activeStudentCount; ?></span>
                    <?php if ($pendingStudentCount > 0): ?>
                        <span class="ml-1 text-xs text-gray-500">+ <?php echo $pendingStudentCount; ?> pending</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quizzes Card -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-1">
                    <span class="text-sm font-medium text-gray-600">Quizzes</span>
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-tasks text-purple-600"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <span class="text-xl font-bold text-gray-900">
                        <?php
                        if (isset($class_id)) {
                            $debug_stmt = $conn->prepare("SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ?");
                            $debug_stmt->bind_param("i", $class_id);
                            $debug_stmt->execute();
                            $debug_result = $debug_stmt->get_result();
                            $debug_row = $debug_result->fetch_assoc();
                            $direct_count = $debug_row['quiz_count'];
                            echo $direct_count;
                        } else {
                            echo '0';
                        }
                        ?>
                    </span>
                    <span class="ml-1 text-xs text-gray-500">total</span>
                    <?php if ($activeQuizCount > 0): ?>
                        <span class="ml-1 text-xs text-gray-500">(<?php echo $activeQuizCount; ?> active)</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Class Code Card -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-1">
                    <span class="text-sm font-medium text-gray-600">Class Code</span>
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-key text-green-600"></i>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-base font-mono font-medium text-gray-900"><?php echo htmlspecialchars($classDetails['class_code'] ?? 'N/A'); ?></span>
                    <?php if (isset($classDetails['class_code'])): ?>
                        <button class="copy-code-btn ml-2 text-purple-primary hover:text-purple-dark" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>">
                            <i class="fas fa-copy"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Grade Level Card -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-1">
                    <span class="text-sm font-medium text-gray-600">Grade Level</span>
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-yellow-600"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <span class="text-xl font-bold text-gray-900">Grade <?php echo htmlspecialchars($classDetails['grade_level'] ?? 'N/A'); ?></span>
                    <?php if (!empty($classDetails['strand'])): ?>
                        <span class="ml-1 text-xs text-gray-500">(<?php echo htmlspecialchars($classDetails['strand']); ?>)</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>