<?php include "Functions/viewAttemptDetailsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsHeadTag.php"; ?>

<?php include "Includes/floatingButton.php" ?>

<body class="bg-gray-50 min-h-screen">

    

    <div class="max-w-9xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

    <?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsBreadcrumb.php"; ?>

    <!-- Enhanced Header -->
    <?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsHeader.php"; ?>

        <!-- Student Profile & Performance Overview -->
        <?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsOverview.php"; ?>

        <!-- Question Type Performance Analysis -->
        <?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsQuestionsAnalysis.php"; ?>

        <!-- Detailed Question Analysis -->
         <?php include "Includes/viewAttemptDetailsIncludes/viewAttemptDetailsQuestionsPreview.php"; ?>

    </div>

    <!-- JavaScript for Enhanced Functionality -->
    <script src="Scripts/viewAttemptDetailsScript.js"></script>


</body>

</html>

<script src="Scripts/floatingButtonScript.js"></script>