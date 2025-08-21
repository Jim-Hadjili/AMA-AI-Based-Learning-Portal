<?php include "Functions/teacherQuizResultFunction.php" ?>

<!DOCTYPE html>

<html lang="en">

<?php include "Includes/teacherQuizResultIncludes/teacherQuizResultHeadTag.php"; ?>

<?php include "Includes/floatingButton.php" ?>

<body class="bg-gray-50 font-[Poppins]">

    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <?php include "Includes/teacherQuizResultIncludes/teacherQuizResultBreadcrumb.php"; ?>

        <!-- Page Header -->
        <?php include "Includes/teacherQuizResultIncludes/teacherQuizResultHeader.php"; ?>

        <!-- Summary Cards -->
        <?php include "Includes/teacherQuizResultIncludes/teacherQuizResultSummaryCards.php"; ?>

        <!-- Graph -->
        <?php include "Includes/teacherQuizResultIncludes/teacherQuizResultGraph.php"; ?>

        <!-- Unique Students Table -->
        <?php include "Includes/teacherQuizResultIncludes/teacherQuizResultTable.php"; ?>

    </div>

    <?php include "Includes/teacherQuizResultIncludes/teacherQuizResultScript.php"; ?>

</body>

</html>

<script src="Scripts/floatingButtonScript.js"></script>