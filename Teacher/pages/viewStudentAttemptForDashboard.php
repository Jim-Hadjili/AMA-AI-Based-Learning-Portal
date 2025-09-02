<?php include "Functions/viewStudentAttemptFunction.php" ?>

<!DOCTYPE html>

<html lang="en">

<?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptHeadTag.php" ?>

<?php include "Includes/floatingButton.php" ?>

<body class="bg-gray-50 font-[sans-serif]">

    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex mb-4 -mt-4" aria-label="Breadcrumb">
            <div class="bg-white backdrop-blur-sm rounded-2xl border border-gray-100/60 shadow-sm px-4 py-3">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li>
                        <div class="flex items-center space-x-3">
                            <a href="../Contents/Dashboard/teachersDashboard.php" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                                <i class="fas fa-home mr-2"></i>
                                <span>Back to Dashboard</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-black mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="px-3 py-2 text-gray-900 font-medium bg-gray-50 rounded-xl">
                                Student Attemptsss </span>
                        </div>
                    </li>
                </ol>
            </div>
        </nav>

        <!-- Student and Quiz Information -->
        <?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptHeader.php" ?>

        <!-- Performance Trend -->
        <?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptGraph.php" ?>

        <!-- All Attempts -->
        <?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptTable.php" ?>

    </div>

    <?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptScript.php"; ?>

</body>

</html>

<script src="Scripts/floatingButtonScript.js"></script>