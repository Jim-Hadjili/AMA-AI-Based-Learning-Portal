<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
    <!-- Students Card -->
    <a href="../Pages/classRoster.php?class_id=<?php echo $class_id; ?>" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl  transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-50 to-blue-100 opacity-30 rounded-full -mr-10 -mt-10"></div>

        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border-2 border-blue-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Students</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['student_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Active enrollment</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Total Quizzes Card -->
    <a href="classDetailsAllQuizzes.php?class_id=<?php echo urlencode($class_id); ?>" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-50 to-emerald-100 opacity-30 rounded-full -mr-10 -mt-10"></div>

        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center border-2 border-emerald-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-2xl text-emerald-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Published Quizzes</p>
                <?php
                // Calculate original (non-AI) quiz count
                $originalQuizQuery = "SELECT COUNT(quiz_id) as count FROM quizzes_tb WHERE class_id = ? AND quiz_type != '1' AND status = 'published'";
                $originalQuizStmt = $conn->prepare($originalQuizQuery);
                $originalQuizStmt->bind_param("i", $class_id);
                $originalQuizStmt->execute();
                $originalQuizResult = $originalQuizStmt->get_result();
                $originalQuizCount = $originalQuizResult->fetch_assoc()['count'];
                ?>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($originalQuizCount); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Assessments available</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Materials Card -->
    <a href="classDetailsAllMaterials.php?class_id=<?php echo urlencode($class_id); ?>" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl  transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-violet-50 to-violet-100 opacity-30 rounded-full -mr-10 -mt-10"></div>

        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 flex items-center justify-center border-2 border-violet-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center">
                    <i class="fas fa-book text-2xl text-violet-600"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Materials</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['material_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-violet-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Learning resources</span>
                </div>
            </div>
        </div>
    </a>

    <!-- Announcements Card -->
    <a href="classDetailsAllAnnouncements.php?class_id=<?php echo urlencode($class_id); ?>" class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-50 to-amber-100 opacity-30 rounded-full -mr-10 -mt-10"></div>

        <div class="relative flex items-center gap-4">
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center border-2 border-amber-200 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-bullhorn text-2xl text-amber-500"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Announcements</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo number_format($classDetails['announcement_count']); ?></p>
                <div class="flex items-center gap-1 mt-1">
                    <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                    <span class="text-xs text-gray-500">Class updates</span>
                </div>
            </div>
        </div>
    </a>
</div>