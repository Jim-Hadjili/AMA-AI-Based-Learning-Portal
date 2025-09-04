<div class="max-w-8xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-white/50 backdrop-blur-sm mb-6 overflow-hidden">
        <!-- Accent strip -->
        <div class="p-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Students Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-blue-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex flex-col items-center">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 w-full">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Students</span>
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-2">
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
                        </div>
                        <div class="text-xs text-gray-500 font-medium">Total</div>
                    </div>
                </div>

                <!-- Quizzes Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-purple-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex flex-col items-center">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 w-full">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Quizzes</span>
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-tasks text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
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
                        </div>
                        <div class="text-xs text-gray-500 font-medium">
                            Total
                            <?php if ($activeQuizCount > 0): ?>
                                <span class="ml-1">(<?php echo $activeQuizCount; ?> active)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Class Code Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-green-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex flex-col items-center">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 w-full">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Class Code</span>
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-key text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="text-base font-mono font-medium bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                                <?php echo htmlspecialchars($classDetails['class_code'] ?? 'N/A'); ?>
                            </span>
                            <?php if (isset($classDetails['class_code'])): ?>
                                <button class="copy-code-btn ml-2 text-green-600 hover:text-green-800" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>">
                                    <i class="fas fa-copy"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Grade Level Card -->
                <div class="group relative bg-white/80 backdrop-blur-sm p-6 rounded-2xl border border-yellow-400 shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 overflow-hidden flex flex-col items-center">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 w-full">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700 tracking-wide">Grade Level</span>
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-yellow-800 bg-clip-text text-transparent mb-2">
                            Grade <?php echo htmlspecialchars($classDetails['grade_level'] ?? 'N/A'); ?>
                            <?php if (!empty($classDetails['strand'])): ?>
                                <span class="ml-1 text-xs text-gray-500">(<?php echo htmlspecialchars($classDetails['strand']); ?>)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>