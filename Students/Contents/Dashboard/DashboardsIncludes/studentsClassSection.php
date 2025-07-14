<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">My Classes</h2>
        <div class="flex items-center space-x-4">
        </div>
    </div>

    <?php if (empty($enrolledClasses)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="inline-block mb-4 p-4 bg-blue-50 rounded-full">
                <i class="fas fa-graduation-cap text-blue-500 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">You haven't enrolled in any classes yet. Join a class using the class code provided by your teacher.</p>
            <button onclick="openClassSearchModal()" class="bg-blue-primary hover:bg-blue-dark text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-search mr-2"></i> Join Your First Class
            </button>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $totalClasses = count($enrolledClasses);
            $initialDisplayCount = 3;
            $hasMoreClasses = ($totalClasses > $initialDisplayCount);

            foreach ($enrolledClasses as $index => $class):
                $isHidden = ($index >= $initialDisplayCount) ? 'hidden' : '';
            ?>
                <a href="../classroom/studentClassRoom.php?class_id=<?php echo $class['class_id']; ?>"
                    class="group relative overflow-hidden bg-white rounded-xl border border-gray-200 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg class-card <?php echo $isHidden; ?>"
                    data-index="<?php echo $index; ?>">
                    <!-- Color stripe based on strand -->
                    <?php
                    $gradientClass = '';
                    switch ($class['strand']) {
                        case 'STEM':
                            $gradientClass = 'from-blue-400 to-indigo-500';
                            $iconBg = 'bg-blue-100';
                            $iconColor = 'text-blue-600';
                            break;
                        case 'HUMSS':
                            $gradientClass = 'from-yellow-400 to-orange-500';
                            $iconBg = 'bg-yellow-100';
                            $iconColor = 'text-yellow-600';
                            break;
                        case 'ABM':
                            $gradientClass = 'from-green-400 to-emerald-500';
                            $iconBg = 'bg-green-100';
                            $iconColor = 'text-green-600';
                            break;
                        case 'TVL-ICT':
                            $gradientClass = 'from-purple-400 to-violet-500';
                            $iconBg = 'bg-purple-100';
                            $iconColor = 'text-purple-600';
                            break;
                        case 'TVL-HE':
                            $gradientClass = 'from-red-400 to-rose-500';
                            $iconBg = 'bg-red-100';
                            $iconColor = 'text-red-600';
                            break;
                        default:
                            $gradientClass = 'from-gray-400 to-slate-500';
                            $iconBg = 'bg-gray-100';
                            $iconColor = 'text-gray-600';
                    }
                    ?>

                    <div class="h-1.5 bg-gradient-to-r <?php echo $gradientClass; ?>"></div>

                    <div class="p-5">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 flex-shrink-0 <?php echo $iconBg; ?> rounded-full flex items-center justify-center mt-1">
                                <i class="<?php
                                            switch ($class['strand']) {
                                                case 'STEM':
                                                    echo 'fas fa-flask';
                                                    break;
                                                case 'HUMSS':
                                                    echo 'fas fa-book';
                                                    break;
                                                case 'ABM':
                                                    echo 'fas fa-chart-line';
                                                    break;
                                                case 'TVL-ICT':
                                                    echo 'fas fa-laptop-code';
                                                    break;
                                                case 'TVL-HE':
                                                    echo 'fas fa-utensils';
                                                    break;
                                                default:
                                                    echo 'fas fa-graduation-cap';
                                            }
                                            ?> <?php echo $iconColor; ?> text-lg"></i>
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-gray-900 mb-1 pr-8 line-clamp-2"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                                    <span class="text-xs font-medium px-2 py-1 bg-blue-50 text-blue-700 rounded-full flex-shrink-0">
                                        Grade <?php echo htmlspecialchars($class['grade_level']); ?>
                                    </span>
                                </div>

                                <p class="text-xs font-medium text-gray-500 mb-3">
                                    <span class="inline-flex items-center space-x-1">
                                        <i class="fas fa-layer-group"></i>
                                        <span><?php echo htmlspecialchars($class['strand']); ?></span>
                                    </span>
                                </p>

                                <?php if (!empty($class['class_description'])): ?>
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo htmlspecialchars($class['class_description']); ?></p>
                                <?php endif; ?>

                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                    <span class="text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        <?php echo date('M j, Y', strtotime($class['created_at'])); ?>
                                    </span>
                                    <div class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                        View Class
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hover effect overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($hasMoreClasses): ?>
            <div class="text-center mt-6">
                <div class="flex justify-center space-x-4">

                    <a href="studentAllClasses.php" class="bg-blue-50 border border-blue-200 text-blue-600 hover:bg-blue-100 px-6 py-2 rounded-lg text-sm font-medium transition-all duration-200 inline-flex items-center">
                        <i class="fas fa-th-large mr-2"></i>View All Classes
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>