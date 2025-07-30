<?php include "../../Functions/studentAllClassesFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <title>All Classes - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>

    <!-- Notification Container -->
    <link rel="stylesheet" href="../../Assets/Css/dashboardNotificationContainer.css">

    <link rel="stylesheet" href="../../Assets/Css/studentAllClasses.css">
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen transition-all duration-300 flex justify-center">
        <!-- Main Content Area, now full width -->
        <main class="p-4 lg:p-8 w-full max-w-full">

            <div class="mb-4">
                <!-- Page Header -->
                <?php include "../Includes/studentAllClassesIncludes/studentAllClassesHeader.php" ?>

                <!-- Search and Filter Section -->
                <?php include "../Includes/studentAllClassesIncludes/studentAllClassesSearchSection.php" ?>

            </div>

            <!-- Classes Grid -->
            <div id="classesContainer">
                <?php include "../Includes/studentAllClassesIncludes/allClassesGrid.php" ?>
            </div>

            <!-- No Results Message -->
            <?php include "../Includes/studentAllClassesIncludes/resultsMessage.php" ?>
        </main>
    </div>

    <!-- Join Class Modal (Search Modal) -->
    <?php include "../Dashboard/DashboardsIncludes/dashboardClassSearchModal.php" ?>

    <!-- Confirmation Modal -->
    <?php include "../Modals/dashboardJoinClassConfirmationModal.php" ?>

    <!-- Load the main notification function first -->
    <script src="../../Assets/Scripts/notif.js"></script>
    <!-- Then load the modal script that uses the notification function -->
    <script src="../../Assets/Scripts/dashboardSearchModal.js"></script>
    <!-- All Classes specific scripts -->
    <script src="../../Assets/Scripts/allClasses.js"></script>

    <!-- Finally, include the PHP script that triggers notifications on page load -->
    <?php include "../../Functions/showNotificationParameters.php" ?>

</body>

</html>