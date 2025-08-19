<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">My Classes</h2>
        <div class="flex items-center space-x-4">
        </div>

        <button onclick="showClassSearchModal()" type="button"
            class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <div class="font-semibold">Search Enrolled Classes</div>
        </button>

    </div>

    <?php
    // Define status colors for the badges
    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-red-100 text-red-800',
        'archived' => 'bg-gray-100 text-gray-800',
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
        ],
        // Default style for subjects not explicitly listed
        'Default' => [
            'strip' => 'bg-gray-500',
            'icon_bg' => 'bg-gray-100',
            'icon_color' => 'text-gray-600',
            'border' => 'border-gray-200',
            'link_color' => 'text-gray-600 hover:text-gray-800',
            'icon_class' => 'fas fa-graduation-cap'
        ]
    ];
    ?>



    <?php if (empty($enrolledClasses)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="inline-block mb-4 p-4 bg-blue-50 rounded-full">
                <i class="fas fa-graduation-cap text-blue-500 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">You haven't enrolled in any classes yet. Join a class using the class code provided by your teacher.</p>
            <button onclick="showJoinClassModal()" class="bg-blue-primary hover:bg-blue-dark text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-search mr-2"></i> Join Your First Class
            </button>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $totalClasses = count($enrolledClasses);
            $initialDisplayCount = 6;
            $hasMoreClasses = ($totalClasses > $initialDisplayCount);

            foreach ($enrolledClasses as $index => $class):
                $isHidden = ($index >= $initialDisplayCount) ? 'hidden' : '';
                $description = !empty($class['class_description']) ? $class['class_description'] : 'No description provided.';
                $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
                $studentCount = $class['student_count'] ?? 0; // Use fetched count
                $quizCount = $class['quiz_count'] ?? 0; // Use fetched count

                // Determine subject-specific styles using the derived class_subject
                $subject = $class['class_subject'] ?? null;
                
                // If no specific subject is set, try to detect from class name
                if (!$subject) {
                    $className = strtolower($class['class_name']);
                    foreach ($subjectStyles as $subjectName => $style) {
                        if (strpos($className, strtolower($subjectName)) !== false) {
                            $subject = $subjectName;
                            break;
                        }
                    }
                }
                
                // If still no subject found, use default
                if (!$subject || !isset($subjectStyles[$subject])) {
                    $subject = 'Default';
                }
                
                $style = $subjectStyles[$subject];
            ?>
                <div class="bg-white rounded-xl shadow-sm border <?php echo $style['border']; ?> hover:shadow-md transition-all duration-200 overflow-hidden transform hover:-translate-y-1 class-card <?php echo $isHidden; ?>"
                    data-index="<?php echo $index; ?>">
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
                            <a href="../Pages/classDetails.php?class_id=<?php echo $class['class_id']; ?>" 
                               class="w-full inline-block text-center py-2 rounded-lg <?php echo $style['icon_bg']; ?> <?php echo $style['link_color']; ?> font-medium hover:opacity-90 transition-opacity">
                                View Class <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($hasMoreClasses): ?>
            <div class="text-center mt-4">
                <button type="button"
                    onclick="window.location.href='../Pages/studentAllClasses.php'"
                    class="inline-flex items-center justify-center space-x-2 py-3 px-6 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="font-semibold">View All Classes</span>
                    <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-xs font-bold ml-2">
                        <?php echo $totalClasses; ?>
                    </span>
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Student Search Enrolled Classes Modal -->
<?php include 'dashboardSearchModal.php'; ?>

<script src="../../Assets/Scripts/searchSuggestions.js"></script>