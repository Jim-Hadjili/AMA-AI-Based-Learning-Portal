<!-- Class Info Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Class Information</h3>
    
    <div class="space-y-4">
        <!-- Grade Level -->
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Grade Level:</span>
            <span class="text-sm font-medium text-gray-900">Grade <?php echo htmlspecialchars($classDetails['grade_level'] ?? 'N/A'); ?></span>
        </div>
        
        <!-- Strand -->
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Strand:</span>
            <span class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars(!empty($classDetails['strand']) ? $classDetails['strand'] : 'N/A'); ?></span>
        </div>
        
        <!-- Class Code -->
        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Class Code:</span>
            <div class="flex items-center">
                <span class="text-sm font-mono font-medium text-gray-900 mr-2"><?php echo htmlspecialchars($classDetails['class_code'] ?? 'N/A'); ?></span>
                <?php if (isset($classDetails['class_code'])): ?>
                <button class="copy-code-btn text-purple-primary hover:text-purple-dark" data-code="<?php echo htmlspecialchars($classDetails['class_code']); ?>" title="Copy class code">
                    <i class="fas fa-copy"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Created Date -->
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Created:</span>
            <span class="text-sm text-gray-900">
                <?php 
                if (isset($classDetails['date_created'])) {
                    echo date('M d, Y', strtotime($classDetails['date_created'])); 
                } else {
                    echo 'N/A';
                }
                ?>
            </span>
        </div>
    </div>
    
</div>

<!-- Quick Stats Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <!-- Students -->
        <div class="bg-blue-50 rounded-lg p-3">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-medium text-blue-600">Students</span>
                <i class="fas fa-users text-blue-400"></i>
            </div>
            <div class="flex items-end">
                <span class="text-xl font-bold text-gray-900"><?php echo $activeStudentCount; ?></span>
                <?php if ($pendingStudentCount > 0): ?>
                <span class="ml-1 text-xs text-gray-500">+ <?php echo $pendingStudentCount; ?> pending</span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quizzes -->
        <div class="bg-purple-50 rounded-lg p-3">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-medium text-purple-600">Quizzes</span>
                <i class="fas fa-tasks text-purple-400"></i>
            </div>
            <div class="flex items-end">
                <span class="text-xl font-bold text-gray-900"><?php echo count($quizzes); ?></span>
                <?php if ($activeQuizCount > 0): ?>
                <span class="ml-1 text-xs text-gray-500">(<?php echo $activeQuizCount; ?> active)</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Quiz -->
    <?php
    // Get the next upcoming quiz
    $upcomingQuiz = null;
    $currentDate = date('Y-m-d H:i:s');
    
    foreach ($quizzes as $quiz) {
        if (isset($quiz['due_date']) && $quiz['due_date'] > $currentDate && $quiz['status'] === 'published') {
            if ($upcomingQuiz === null || $quiz['due_date'] < $upcomingQuiz['due_date']) {
                $upcomingQuiz = $quiz;
            }
        }
    }
    
    if ($upcomingQuiz): 
    ?>
    <div class="border border-gray-200 rounded-lg p-4 mb-4">
        <div class="flex items-start">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                <i class="fas fa-bell text-yellow-600"></i>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900">Upcoming Due Date</h4>
                <p class="text-xs text-gray-500 mb-1"><?php echo date('M d, Y', strtotime($upcomingQuiz['due_date'])); ?></p>
                <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($upcomingQuiz['quiz_title']); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- View Reports -->
    <a href="../Reports/classReports.php?class_id=<?php echo $class_id; ?>" class="block w-full mt-2 text-center px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors">
        <i class="fas fa-chart-line mr-2"></i> View Full Reports
    </a>
</div>

<!-- Recently Active Students -->
<?php if (count($students) > 0): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Recently Active Students</h3>
    
    <div class="space-y-4">
        <?php 
        // Sort students by most recent activity (just using enrollment date for now)
        usort($students, function($a, $b) {
            return strtotime($b['enrollment_date']) - strtotime($a['enrollment_date']);
        });
        
        $recentStudents = array_slice($students, 0, 3);
        
        foreach ($recentStudents as $student): 
        ?>
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                    <?php if (!empty($student['st_profile_img'])): ?>
                        <img class="h-10 w-10 rounded-full" src="<?php echo htmlspecialchars($student['st_profile_img']); ?>" alt="<?php echo htmlspecialchars($student['st_name']); ?>">
                    <?php else: ?>
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($student['st_name']); ?></p>
                    <p class="text-xs text-gray-500">Last active: <?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?></p>
                </div>
                <button class="message-student-btn text-gray-400 hover:text-purple-primary" data-student-id="<?php echo $student['st_id']; ?>">
                    <i class="fas fa-comment"></i>
                </button>
            </div>
        <?php endforeach; ?>
        
        <?php if (count($students) > 3): ?>
            <a href="#" class="view-all-students-btn block text-center text-sm text-purple-primary hover:text-purple-dark mt-2 py-1">
                View all students
            </a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>