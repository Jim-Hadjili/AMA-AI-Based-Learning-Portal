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

<body class="bg-gray-100 min-h-screen m-3 lg:-mt-2">

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

    <?php if (isset($_GET['error']) && $_GET['error'] === 'ai_generation_failed'): ?>
    <div id="regenerationFailedModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div
            class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center flex flex-col items-center animate-in fade-in-0 zoom-in-95 duration-200">
            <div class="mb-6 mt-2 flex justify-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-red-700 mb-2">Quiz Regeneration Failed</h2>
            <p class="text-gray-700 mb-4">Sorry, we couldn't generate a new quiz at this time. Please try again.
            </p>
            <button
                onclick="document.getElementById('regenerationFailedModal').style.display='none';document.body.classList.remove('overflow-hidden');removeErrorParam();"
                class="px-6 py-2.5 bg-red-500 hover:bg-red-700 text-white rounded-xl transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                Close
            </button>
        </div>
    </div>
    <script>
        document.body.classList.add('overflow-hidden');
        function removeErrorParam() {
            const url = new URL(window.location);
            url.searchParams.delete('error');
            window.history.replaceState({}, document.title, url);
        }
    </script>
    <?php endif; ?>

</body>

</html>