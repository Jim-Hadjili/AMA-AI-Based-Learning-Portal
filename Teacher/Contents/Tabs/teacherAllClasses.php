<?php include "../../Functions/teacherAllClassesFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Classes - Teacher Dashboard - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <script src="../../Assets/Js/teacherDashboard.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">
</head>

<body class="bg-gray-100 min-h-screen font-[sans-serif]">
    <!-- Notification Container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2"></div>

    <!-- Main Content -->
    <div class="min-h-screen">
        <!-- Main Content Area -->
        <main class="p-4 lg:p-6 max-w-8xl mx-auto">
            <!-- All Classes Section -->
            <div>
                <?php include "AllClassesComponents/allClassesBreadcrumb.php"; ?>

                <?php include "AllClassesComponents/allClassesStats.php"; ?>

                <?php include "AllClassesComponents/allClassesFilters.php"; ?>

                <?php include "AllClassesComponents/allClassesCardsSection.php"; ?>
            </div>
        </main>
    </div>

    <!-- Include Add Class Modal -->
    <?php include "../Modals/addClassModal.php"; ?>

</body>

<script src="../../Assets/Js/teacherDashAnimation.js"></script>
<script src="../../Assets/Js/addClassModal.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
    const addEmptyClassBtn = document.getElementById('addEmptyClassBtn');
    if (addEmptyClassBtn) {
        addEmptyClassBtn.addEventListener('click', function() {
            if (typeof window.openAddClassModal === 'function') {
                window.openAddClassModal();
            } else {
                console.error("openAddClassModal function not found");
            }
        });
    }
});
</script>
</html>