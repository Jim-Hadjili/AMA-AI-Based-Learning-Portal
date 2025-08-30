<?php
session_start();
include "Functions/allRecentActivityFunction.php";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'Includes/allRecentActivityIncludes/allRecentActivityHeadTag.php'; ?>

<body class="bg-gray-50 font-[Poppins]">

    <div class="max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <?php include "Includes/allRecentActivityIncludes/allRecentActivityBreadcrumb.php"; ?>

        <!-- Header Card -->
        <?php include "Includes/allRecentActivityIncludes/allRecentActivityHeader.php"; ?>

        <!-- Filters Card -->
        <?php include "Includes/allRecentActivityIncludes/allRecentActivitySearchFilter.php"; ?>

        <!-- Activity Timeline Card -->
        <?php include "Includes/allRecentActivityIncludes/allRecentActivityTimelineCard.php"; ?>

        <?php include "Includes/allRecentActivityIncludes/allRecentActivityModal.php" ?>

    </div>

    <?php include 'Scripts/allrecentActivityScript.php'; ?>

    <script src="Includes/allRecentActivityIncludes/allRecentActivitySearchFilter.js"></script>

</body>

</html>