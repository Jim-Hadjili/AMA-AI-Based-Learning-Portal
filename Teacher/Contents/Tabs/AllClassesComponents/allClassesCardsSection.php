<?php if (isset($classes) && count($classes) > 0): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
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
                    $quizQuery = "SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ? AND status = 'published'";
                    $quizStmt = $conn->prepare($quizQuery);
                    $quizStmt->bind_param("i", $class['class_id']);
                    $quizStmt->execute();
                    $quizResult = $quizStmt->get_result();
                    $quizCount = $quizResult->fetch_assoc()['quiz_count'];
                }
            } catch (Exception $e) {
                // Silently handle the error, keeping the default value
            }

            // Define status badge colors
            $statusColors = [
                'active' => 'bg-green-100 text-green-800',
                'inactive' => 'bg-gray-100 text-gray-800',
                'archived' => 'bg-red-100 text-red-800'
            ];

            // Default values for missing fields
            $description = !empty($class['class_description']) ? $class['class_description'] : 'No description available';
            $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
        ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
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
                        <a href="../Tabs/classDetails.php?class_id=<?php echo $class['class_id']; ?>" class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                            View Class <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php include "../Modals/pagination.php" ?>

<?php else: ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center max-w-8xl mx-auto">
        <i class="fas fa-book-open text-gray-300 text-4xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
        <p class="text-gray-500 mb-4">You haven't created any classes yet. Create your first class to get started.</p>
        <button id="addEmptyClassBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>Add Your First Class
        </button>
    </div>
<?php endif; ?>