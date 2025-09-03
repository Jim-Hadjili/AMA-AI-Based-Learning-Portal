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
        <button type="button" onclick="showJoinClassModal()" class="group relative inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden" aria-label="Join Your First Class">
            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm4.293-9.707a1 1 0 00-1.414 0L10 11.172l-2.879-2.879a1 1 0 10-1.414 1.414l3.586 3.586a1 1 0 001.414 0l3.586-3.586a1 1 0 000-1.414z" clip-rule="evenodd" />
            </svg>
            <span class="relative">Join Your First Class</span>
        </button>
    </div>
<?php else: ?>
    <style>
        #classesGrid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            #classesGrid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            #classesGrid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>

    <div id="classesGrid">
        <?php foreach ($enrolledClasses as $index => $class):
            $description = !empty($class['class_description']) ? $class['class_description'] : 'No description provided.';
            $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
            $studentCount = $class['student_count'] ?? 0;
            $quizCount = $class['quiz_count'] ?? 0;

            // Determine subject-specific styles
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
            <div class="bg-white rounded-xl shadow-sm border <?php echo $style['border']; ?> hover:shadow-md transition-all duration-200 transform hover:-translate-y-1 overflow-hidden class-card"
                data-class-name="<?php echo strtolower(htmlspecialchars($class['class_name'])); ?>"
                data-class-status="<?php echo strtolower($class['status']); ?>"
                data-class-subject="<?php echo strtolower($subject); ?>"
                data-class-strand="<?php echo strtolower($strand); ?>">

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
                            <p class="text-sm text-gray-500 mt-1">Teacher: <?php echo htmlspecialchars($class['teacher_name'] ?? 'N/A'); ?></p>
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

                    <div class="flex justify-between text-sm mb-4">
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

                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center mb-3">
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-key mr-1"></i>
                                Code: <span class="font-mono font-medium"><?php echo htmlspecialchars($class['class_code']); ?></span>
                            </div>
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                <?php echo date('M j, Y', strtotime($class['created_at'])); ?>
                            </div>
                        </div>

                        <a href="../Pages/classDetails.php?class_id=<?php echo $class['class_id']; ?>"
                            class="w-full inline-block text-center py-2 rounded-lg <?php echo $style['icon_bg']; ?> <?php echo $style['link_color']; ?> font-medium hover:opacity-90 transition-opacity">
                            <i class="fas fa-arrow-right mr-2"></i>View Class Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>