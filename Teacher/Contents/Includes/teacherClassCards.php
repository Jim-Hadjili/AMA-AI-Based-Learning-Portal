<!-- Class Cards Section -->
<div class="mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-900">Your Classes</h2>
        <div class="flex items-center gap-4">
            <!-- Enhanced Add Class Button with Animation -->
            <a
                href="#"
                id="searchSidebarBtn"
                onclick="window.openSearchClassModal && window.openSearchClassModal()"
                class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-blue-600 bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-600 hover:text-white transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1">
                <span class="flex items-center justify-center w-5 h-5">
                    <i class="fas fa-search text-[15px] leading-none"></i>
                </span>
                <span class="leading-none whitespace-nowrap">Search Class</span>
            </a>
        </div>
    </div>

    <?php if (isset($classes) && count($classes) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php
            // Define status colors for the badges
            $statusColors = [
                'active' => 'bg-green-100 text-green-800',
                'inactive' => 'bg-gray-100 text-gray-800',
                'archived' => 'bg-red-100 text-red-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
            ];

            // Define subject-specific styles with solid colors
            $subjectStyles = [
                'English' => [
                    'strip' => 'bg-blue-500',
                    'icon_bg' => 'bg-blue-100',
                    'icon_color' => 'text-blue-600',
                    'border' => 'border-blue-200',
                    'link_color' => 'text-blue-600 hover:text-blue-800',
                    'icon_class' => 'fas fa-book-reader'
                ],
                'Math' => [
                    'strip' => 'bg-green-500',
                    'icon_bg' => 'bg-green-100',
                    'icon_color' => 'text-green-600',
                    'border' => 'border-green-200',
                    'link_color' => 'text-green-600 hover:text-green-800',
                    'icon_class' => 'fas fa-calculator'
                ],
                'Science' => [
                    'strip' => 'bg-purple-500',
                    'icon_bg' => 'bg-purple-100',
                    'icon_color' => 'text-purple-600',
                    'border' => 'border-purple-200',
                    'link_color' => 'text-purple-600 hover:text-purple-800',
                    'icon_class' => 'fas fa-flask'
                ],
                'History' => [
                    'strip' => 'bg-yellow-500',
                    'icon_bg' => 'bg-yellow-100',
                    'icon_color' => 'text-yellow-600',
                    'border' => 'border-yellow-200',
                    'link_color' => 'text-yellow-600 hover:text-yellow-800',
                    'icon_class' => 'fas fa-landmark'
                ],
                'Arts' => [
                    'strip' => 'bg-pink-500',
                    'icon_bg' => 'bg-pink-100',
                    'icon_color' => 'text-pink-600',
                    'border' => 'border-pink-200',
                    'link_color' => 'text-pink-600 hover:text-pink-800',
                    'icon_class' => 'fas fa-paint-brush'
                ],
                'PE' => [
                    'strip' => 'bg-red-500',
                    'icon_bg' => 'bg-red-100',
                    'icon_color' => 'text-red-600',
                    'border' => 'border-red-200',
                    'link_color' => 'text-red-600 hover:text-red-800',
                    'icon_class' => 'fas fa-running'
                ],
                'ICT' => [
                    'strip' => 'bg-indigo-500',
                    'icon_bg' => 'bg-indigo-100',
                    'icon_color' => 'text-indigo-600',
                    'border' => 'border-indigo-200',
                    'link_color' => 'text-indigo-600 hover:text-indigo-800',
                    'icon_class' => 'fas fa-laptop-code'
                ],
                'Home Economics' => [
                    'strip' => 'bg-orange-500',
                    'icon_bg' => 'bg-orange-100',
                    'icon_color' => 'text-orange-600',
                    'border' => 'border-orange-200',
                    'link_color' => 'text-orange-600 hover:text-orange-800',
                    'icon_class' => 'fas fa-utensils'
                ],
                'Filipino' => [
                    'strip' => 'bg-rose-500',
                    'icon_bg' => 'bg-rose-100',
                    'icon_color' => 'text-rose-600',
                    'border' => 'border-rose-200',
                    'link_color' => 'text-rose-600 hover:text-rose-800',
                    'icon_class' => 'fas fa-book'
                ],
                'Literature' => [
                    'strip' => 'bg-amber-500',
                    'icon_bg' => 'bg-amber-100',
                    'icon_color' => 'text-amber-600',
                    'border' => 'border-amber-200',
                    'link_color' => 'text-amber-600 hover:text-amber-800',
                    'icon_class' => 'fas fa-feather'
                ],
                'Music' => [
                    'strip' => 'bg-violet-500',
                    'icon_bg' => 'bg-violet-100',
                    'icon_color' => 'text-violet-600',
                    'border' => 'border-violet-200',
                    'link_color' => 'text-violet-600 hover:text-violet-800',
                    'icon_class' => 'fas fa-music'
                ],
                'Computer' => [
                    'strip' => 'bg-cyan-500',
                    'icon_bg' => 'bg-cyan-100',
                    'icon_color' => 'text-cyan-600',
                    'border' => 'border-cyan-200',
                    'link_color' => 'text-cyan-600 hover:text-cyan-800',
                    'icon_class' => 'fas fa-desktop'
                ],
                'Programming' => [
                    'strip' => 'bg-slate-500',
                    'icon_bg' => 'bg-slate-100',
                    'icon_color' => 'text-slate-600',
                    'border' => 'border-slate-200',
                    'link_color' => 'text-slate-600 hover:text-slate-800',
                    'icon_class' => 'fas fa-code'
                ]
            ];
            
            // Default style for subjects not explicitly listed - Consistent for all unrecognized classes
            $defaultStyle = [
                'strip' => 'bg-gray-500',
                'icon_bg' => 'bg-gray-100',
                'icon_color' => 'text-gray-600',
                'border' => 'border-gray-200',
                'link_color' => 'text-gray-600 hover:text-gray-800',
                'icon_class' => 'fas fa-graduation-cap'
            ];
            
            // Display only the first 6 classes
            $displayClasses = array_slice($classes, 0, 6);
            foreach ($displayClasses as $class):
                // Count enrolled students for this class - with error handling
                $studentCount = 0; // Default value
                
                try {
                    // Check if the table exists first
                    $tableCheckQuery = "SHOW TABLES LIKE 'class_enrollments_tb'";
                    $tableCheckResult = $conn->query($tableCheckQuery);
                    
                    if ($tableCheckResult->num_rows > 0) {
                        // Table exists, proceed with the count
                        $enrollmentQuery = "SELECT COUNT(*) as student_count FROM class_enrollments_tb WHERE class_id = ? AND status = 'active'";
                        $enrollmentStmt = $conn->prepare($enrollmentQuery);
                        $enrollmentStmt->bind_param("i", $class['class_id']);
                        $enrollmentStmt->execute();
                        $enrollmentResult = $enrollmentStmt->get_result();
                        $studentCount = $enrollmentResult->fetch_assoc()['student_count'];
                    }
                } catch (Exception $e) {
                    // Silently handle the error, keeping the default value
                }

                // Get quiz count for this class - with error handling
                $quizCount = 0; // Default value
                
                try {
                    // Check if the table exists first
                    $tableCheckQuery = "SHOW TABLES LIKE 'quizzes_tb'";
                    $tableCheckResult = $conn->query($tableCheckQuery);
                    
                    if ($tableCheckResult->num_rows > 0) {
                        // Table exists, proceed with the count
                        $quizQuery = "SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ? AND status = 'published' AND quiz_type = 'manual'";
                        $quizStmt = $conn->prepare($quizQuery);
                        $quizStmt->bind_param("i", $class['class_id']);
                        $quizStmt->execute();
                        $quizResult = $quizStmt->get_result();
                        $quizCount = $quizResult->fetch_assoc()['quiz_count'];
                    }
                } catch (Exception $e) {
                    // Silently handle the error, keeping the default value
                }

                // Default values for missing fields
                $description = !empty($class['class_description']) ? $class['class_description'] : 'No description available';
                $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
                
                // Determine subject based on class name
                $className = strtolower($class['class_name']);
                $subjectFound = false;
                $style = $defaultStyle; // Default to the consistent default style
                
                foreach ($subjectStyles as $subject => $styles) {
                    if (strpos($className, strtolower($subject)) !== false) {
                        $style = $styles;
                        $subjectFound = true;
                        break;
                    }
                }
            ?>
                <div class="bg-white rounded-xl shadow-sm border <?php echo $style['border']; ?> hover:shadow-md transition-all duration-200 overflow-hidden transform hover:-translate-y-1">
                    <!-- Class Card Header with Solid Color Strip -->
                    <div class="h-3 <?php echo $style['strip']; ?>"></div>
                    <div class="p-5">
                        <div class="flex items-start mb-4">
                            <!-- Subject Icon -->
                            <div class="inline-block p-3 rounded-full <?php echo $style['icon_bg']; ?> mr-3 shadow-sm">
                                <i class="<?php echo $style['icon_class']; ?> text-xl <?php echo $style['icon_color']; ?>"></i>
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-lg text-gray-900"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                                    <span class="px-2 py-1 text-xs rounded-full <?php echo isset($statusColors[$class['status']]) ? $statusColors[$class['status']] : $statusColors['inactive']; ?> ml-2">
                                        <?php echo ucfirst($class['status']); ?>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-key mr-1"></i>
                                    Code: <span class="font-mono font-medium"><?php echo htmlspecialchars($class['class_code']); ?></span>
                                </p>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo htmlspecialchars($description); ?></p>

                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                <p class="text-xs text-gray-500">Grade</p>
                                <p class="font-medium text-sm text-gray-800">Grade <?php echo htmlspecialchars($class['grade_level']); ?></p>
                            </div>
                            <div class="bg-gray-50 p-2 rounded-lg border border-gray-100">
                                <p class="text-xs text-gray-500">Strand</p>
                                <p class="font-medium text-sm text-gray-800"><?php echo htmlspecialchars($strand); ?></p>
                            </div>
                        </div>

                        <div class="flex justify-between text-sm">
                            <div class="flex items-center text-gray-600">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo $style['icon_bg']; ?> mr-2">
                                    <i class="fas fa-users <?php echo $style['icon_color']; ?>"></i>
                                </div>
                                <span><?php echo $studentCount; ?> Students</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo $style['icon_bg']; ?> mr-2">
                                    <i class="fas fa-book <?php echo $style['icon_color']; ?>"></i>
                                </div>
                                <span><?php echo $quizCount; ?> Quizzes</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="../Tabs/classDetails.php?class_id=<?php echo $class['class_id']; ?>" 
                               class="w-full inline-block text-center py-2 rounded-lg <?php echo $style['icon_bg']; ?> <?php echo $style['link_color']; ?> font-medium hover:opacity-90 transition-opacity">
                                View Class <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (isset($classes) && count($classes) > 6): ?>
            <div class="text-center mt-6">
                <a href="../Tabs/teacherAllClasses.php"
                   class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5zm3 2a1 1 0 011 1v2h2V8a1 1 0 112 0v2h2a1 1 0 110 2h-2v2a1 1 0 11-2 0v-2H8a1 1 0 110-2h2V8a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="font-semibold">View All <?php echo count($classes); ?> Classes</div>
                </a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="inline-block p-4 bg-gray-100 rounded-full text-gray-500 mb-4">
                <i class="fas fa-book-open text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
            <p class="text-gray-500 mb-4 max-w-md mx-auto">You haven't created any classes yet. Create your first class to get started.</p>
            <button id="addEmptyClassBtn" class="px-5 py-2.5 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>Add Your First Class
            </button>
        </div>
    <?php endif; ?>
</div>

<script>
    // Make sure the empty state button also triggers the modal
    document.addEventListener('DOMContentLoaded', function() {
        const addEmptyClassBtn = document.getElementById('addEmptyClassBtn');
        if (addEmptyClassBtn) {
            addEmptyClassBtn.addEventListener('click', function() {
                if (typeof window.openAddClassModal === 'function') {
                    window.openAddClassModal();
                }
            });
        }
    });
</script>