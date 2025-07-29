<?php include "../../Functions/studentDashboardFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
        <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>

    <!-- Notification Container -->
    <link rel="stylesheet" href="../../Assets/Css/dashboardNotificationContainer.css">
    
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen transition-all duration-300">

        <!-- Header -->
        <?php include "DashboardsIncludes/studentsHeader.php" ?>

        <!-- Main Content Area with padding to offset fixed header -->
        <main class="p-4 lg:p-6 pt-6">
            <!-- Welcome Section with Search Button -->
            <?php include "DashboardsIncludes/welcomeSection.php" ?>

            <!-- Stats Cards -->
            <?php include "DashboardsIncludes/studentsStatsCards.php" ?>

            <!-- My Classes Section -->
            <?php include "DashboardsIncludes/studentsClassSection.php" ?>

            <!-- Content Sections -->
            <?php include "DashboardsIncludes/studentsContentSection.php" ?>
        </main>
    </div>

    <!-- Toggle Classe sView -->
    <script src="../../Assets/Scripts/toggleClassesView.js"> </script>

    <!-- Join Class Modal (Search Modal) -->
    <?php include "DashboardsIncludes/dashboardClassSearchModal.php" ?>

    <!-- Confirmation Modal -->
    <?php include "../Modals/dashboardJoinClassConfirmationModal.php" ?>

    <!-- Load the main notification function first -->
    <script src="../../Assets/Scripts/notif.js"></script> 
    <!-- Then load the modal script that uses the notification function -->
    <script src="../../Assets/Scripts/dashboardSearchModal.js"></script> 

    <!-- Finally, include the PHP script that triggers notifications on page load -->
    <?php include "../../Functions/showNotificationParameters.php" ?>

    <!-- Edit Profile Modal -->
    <?php include "../Modals/studentEditProfileModal.php" ?>

</body>

</html>
