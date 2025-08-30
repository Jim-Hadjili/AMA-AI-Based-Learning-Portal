<?php 
include "Functions/recentActivityFunction.php";
include "Functions/studentEngagementFunction.php";
?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

    <!-- Recent Activity -->
    <?php include 'Includes/teacherContentsIncludes/recentActivity.php'; ?>

    <!-- Student Engagement -->
    <?php include 'Includes/teacherContentsIncludes/studentEngagement.php'; ?>

</div>

<?php include "Includes/teacherContentsIncludes/recentActivityModal.php" ?>

<?php include 'Scripts/recentActivityScript.php'; ?>