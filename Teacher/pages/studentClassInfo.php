<?php
include_once 'Functions/studentClassInfoFunction.php';
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'Includes/studentClassInfoIncludes/studentClassInfoHeadTag.php'; ?>

<?php include "Includes/floatingButton.php" ?>

<body class="bg-gray-50 font-[sans-serif]">

    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <?php include 'Includes/studentClassInfoIncludes/studentClassInfoBreadcrumb.php'; ?>

        <!-- Student Profile Card Header -->
        <?php include 'Includes/studentClassInfoIncludes/studentClassInfoStudentProfileHeader.php'; ?>

        <!-- Performance Overview -->
        <?php include 'Includes/studentClassInfoIncludes/studentClassInfoQuizzesOverview.php'; ?>

        <!-- Search and Filter Section -->
        <?php include 'Includes/studentClassInfoIncludes/studentClassInfoSearchFilter.php'; ?>

        <!-- Quizzes Table -->
        <?php include 'Includes/studentClassInfoIncludes/studentClassInfoTable.php'; ?>
    </div>

    <script src="Includes/studentClassInfoIncludes/studentClassInfoScript.js"></script>

</body>

</html>

<script src="Scripts/floatingButtonScript.js"></script>