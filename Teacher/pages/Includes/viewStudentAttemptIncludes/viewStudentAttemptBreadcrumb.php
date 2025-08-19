<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="../index.php" class="text-gray-700 hover:text-blue-600">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                <a href="../pages/manageCourses.php?class_id=<?php echo $class_id; ?>" class="text-gray-700 hover:text-blue-600">
                    <?php echo htmlspecialchars($attempt['class_name']); ?>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                <a href="../pages/quizzes.php?class_id=<?php echo $class_id; ?>" class="text-gray-700 hover:text-blue-600">
                    Quizzes
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                <a href="../pages/teacherQuizResult.php?quiz_id=<?php echo $quiz_id; ?>" class="text-gray-700 hover:text-blue-600">
                    Quiz Results
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                <span class="text-gray-500">Student Attempt</span>
            </div>
        </li>
    </ol>
</nav>