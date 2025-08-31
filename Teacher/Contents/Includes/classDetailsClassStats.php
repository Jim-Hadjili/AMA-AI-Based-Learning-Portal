<div class="max-w-8xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 mb-6 overflow-hidden">
    <div class="p-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Students Card -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col items-center shadow">
                <div class="flex items-center justify-between w-full mb-1">
                    <span class="text-sm font-medium text-gray-600">Students</span>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <span class="text-xl font-bold text-gray-900">
                        <?php
                        if (isset($class_id)) {
                            $debug_stmt = $conn->prepare("SELECT COUNT(*) as student_count FROM class_enrollments_tb WHERE class_id = ?");
                            $debug_stmt->bind_param("i", $class_id);
                            $debug_stmt->execute();
                            $debug_result = $debug_stmt->get_result();
                            $debug_row = $debug_result->fetch_assoc();
                            $direct_count = $debug_row['student_count'];
                            echo $direct_count;
                        } else {
                            echo '0';
                        }
                        ?>
                    </span>
                    <span class="ml-1 text-xs text-gray-500">Total</span>
                </div>
            </div>

            <!-- Quizzes Card -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col items-center shadow">
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
                            $debug_stmt = $conn->prepare("SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ? AND quiz_type = 'manual'");
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
                    <span class="ml-1 text-xs text-gray-500">Total</span>
                    <?php if ($activeQuizCount > 0): ?>
                        <span class="ml-1 text-xs text-gray-500">(<?php echo $activeQuizCount; ?> active)</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Class Code Card -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col items-center shadow">
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
            <div class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col items-center shadow">
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