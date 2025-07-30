<?php include "../../Functions/classDetailsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($classDetails['class_name']); ?> - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Main Content Area -->
        <main class="lg:p-6">
            <!-- // Define subject-specific styles -->
            <?php include "../Includes/classDetailsIncludes/subjectSpecificStyles.php" ?>

            <!-- Breadcrumb -->
            <?php include "../Includes/classDetailsIncludes/classDetailsBreadcrumb.php" ?>

            <!-- Class Header -->
            <?php include "../Includes/classDetailsIncludes/classDetailsHeader.php" ?>

            <!-- Stats Cards -->
            <?php include "../Includes/classDetailsIncludes/classDetailsStatsCards.php" ?>

            <!-- Content Grid -->
            <?php include "../Includes/classDetailsIncludes/classDetailsContentGrid.php" ?>
        </main>

    </div>


    <!-- Announcement Modal -->
    <?php include "../Modals/announcementModal.php" ?>

    <!-- Quiz Details Modal -->
    <?php include "../Modals/quizDetailsModal.php" ?>

    <!-- JavaScript for Announcement Modal -->
    <script src="../../Assets/Scripts/classDetailsModals.js"></script>

</body>

</html>