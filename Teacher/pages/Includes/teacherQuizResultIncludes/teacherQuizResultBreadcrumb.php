<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="../Contents/Dashboard/teachersDashboard.php" class="text-gray-700 hover:text-blue-600">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                <a href="../Contents/Tabs/classDetails.php?class_id=<?php echo $class_id; ?>" class="text-gray-700 hover:text-blue-600">
                    Quizzes
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                <span class="text-gray-500">Student Results</span>
            </div>
        </li>
    </ol>
</nav>