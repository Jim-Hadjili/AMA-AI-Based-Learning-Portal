<?php
session_start();
include_once "Functions/allStudentEngagementFunction.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php include "Includes/allStudentEngagementIncludes/allStudentEngagementHeadTag.php"; ?>

<?php include "Includes/floatingButton.php" ?>

<body class="bg-gray-50 font-[sans-serif]">

    <div class="max-w-9xl mx-auto px-4 py-4 sm:px-6 lg:px-8">

        <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementBreadcrumb.php"; ?>

        <!-- Header Card -->
        <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementHeader.php"; ?>

        <!-- Empty State or Main Content -->
        <?php if (empty($uniqueStudents)): ?>
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-12">
                <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementEmptyState.php"; ?>
            </div>
        <?php else: ?>

            <!-- Summary Cards -->
            <div class="mb-8">
                <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementSummaryCards.php"; ?>
            </div>

            <!-- Search & Filter Bar -->
            <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementSearchFilter.php"; ?>

            <!-- Student Table Card -->
            <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementTable.php"; ?>

            <!-- Student Detail Modals -->
            <?php foreach ($uniqueStudents as $studentId => $student): ?>
                <?php include "Includes/allStudentEngagementIncludes/allStudentEngagementModal.php"; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <script src="Includes/allStudentEngagementIncludes/allStudentEngagementSearchandFilter.js"></script>

</body>

</html>

<script src="Scripts/floatingButtonScript.js"></script>