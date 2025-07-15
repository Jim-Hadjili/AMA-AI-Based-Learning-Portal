<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">My Classes</h2>
        <div class="flex items-center space-x-4">
        </div>
    </div>

    <?php
    // Define status colors for the badges
    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-red-100 text-red-800',
        'archived' => 'bg-gray-100 text-gray-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
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
            $initialDisplayCount = 3;
            $hasMoreClasses = ($totalClasses > $initialDisplayCount);

            foreach ($enrolledClasses as $index => $class):
                $isHidden = ($index >= $initialDisplayCount) ? 'hidden' : '';
                $description = !empty($class['class_description']) ? $class['class_description'] : 'No description provided.';
                $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
                $studentCount = $class['student_count'] ?? 0; // Use fetched count
                $quizCount = $class['quiz_count'] ?? 0; // Use fetched count
            ?>
                <a href="../classroom/studentClassRoom.php?class_id=<?php echo $class['class_id']; ?>"
                    class="group relative overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 class-card <?php echo $isHidden; ?>"
                    data-index="<?php echo $index; ?>">
                    <!-- Class Card Header with Color Strip -->
                    <div class="h-2 bg-purple-primary"></div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-semibold text-lg text-gray-900"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                            <span class="px-2 py-1 text-xs rounded-full <?php echo isset($statusColors[$class['status']]) ? $statusColors[$class['status']] : $statusColors['inactive']; ?>">
                                <?php echo ucfirst($class['status']); ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo htmlspecialchars($description); ?></p>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="bg-gray-50 p-2 rounded">
                                <p class="text-xs text-gray-500">Grade</p>
                                <p class="font-medium text-sm text-gray-800">Grade <?php echo htmlspecialchars($class['grade_level']); ?></p>
                            </div>
                            <div class="bg-gray-50 p-2 rounded">
                                <p class="text-xs text-gray-500">Strand</p>
                                <p class="font-medium text-sm text-gray-800"><?php echo htmlspecialchars($strand); ?></p>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-users mr-2 text-purple-primary"></i>
                                <span><?php echo $studentCount; ?> Students</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-book mr-2 text-purple-primary"></i>
                                <span><?php echo $quizCount; ?> Quizzes</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-key mr-1"></i>
                                Code: <span class="font-mono font-medium"><?php echo htmlspecialchars($class['class_code']); ?></span>
                            </div>
                            <div class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                                View Class <i class="fas fa-arrow-right ml-1"></i>
                            </div>
                        </div>
                    </div>
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
