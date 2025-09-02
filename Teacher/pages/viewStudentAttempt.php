<?php include "Functions/viewStudentAttemptFunction.php" ?>

<!DOCTYPE html>

<html lang="en">

<?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptHeadTag.php" ?>

<?php include "Includes/floatingButton.php" ?>

<body class="bg-gray-50 font-[sans-serif]">

    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <?php include "Includes/viewStudentAttemptIncludes/viewStudentAttemptBreadcrumb.php" ?>

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