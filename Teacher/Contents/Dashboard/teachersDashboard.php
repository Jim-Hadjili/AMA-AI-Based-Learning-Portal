<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

include_once '../../Functions/userInfo.php';

// Include function to fetch classes
include_once '../../Functions/fetchClasses.php';

// Get teacher's classes
$teacher_id = $_SESSION['user_id'];
$classes = getTeacherClasses($conn, $teacher_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - AMA Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <script src="../../Assets/Js/teacherDashboard.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">
    <!-- Add this to your CSS file for the modal animations -->
    <style>
        /* General modal overlay transition */
        #searchClassModal, #logoutConfirmationModal {
            transition: opacity 0.3s ease-out;
            /* Initially hidden with utility class, will fade in */
        }
        #searchClassModal.show, #logoutConfirmationModal.show {
            opacity: 1;
        }

        /* Modal content animation (scale and fade) */
        #searchClassModal .modal-content, #logoutConfirmationModal .modal-content {
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
            /* Initial state defined in HTML with opacity-0 and scale-95 */
        }
        #searchClassModal .modal-content.show, #logoutConfirmationModal .modal-content.show {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="closeMobileMenu()"></div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col space-y-2"></div>

    <!-- Sidebar -->
    <?php include "../Includes/teacherSideBar.php"; ?>

    <!-- Main Content -->
    <div id="main-content" class="lg:ml-16 min-h-screen transition-all duration-300">

        <!-- Top Navigation Bar -->
        <?php include "../Includes/teacherHeader.php"; ?>

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6">

            <!-- Stats Cards -->
            <?php include "../Includes/teacherStatusCards.php"; ?>

            <!-- Class Cards -->
            <?php include "../Includes/teacherClassCards.php"; ?>
            
            <!-- Content Sections -->
            <?php include "../Includes/teacherContents.php"; ?>

        </main>
    </div>

    <!-- Include Add Class Modal -->
    <?php include "../Modals/addClassModal.php"; ?>
    <!-- Include Search Class Modal -->
    <?php include "../Modals/searchClassModal.php"; ?>
    <!-- New: Include Logout Confirmation Modal -->
    <?php include "../Modals/logoutConfirmationModal.php"; ?>

</body>
<script src="../../Assets/Js/teacherDashAnimation.js"></script>
<script src="../../Assets/Js/generateRandomClassCode.js"></script>
<script src="../../Assets/Js/addClassModal.js"></script>
<!-- Include Search Modal Animation and Logic -->
<script src="../../Assets/Js/searchDashAnimation.js"></script>
<script src="../../Assets/Js/searchModal.js"></script>
<!-- New: Include Logout Modal Logic -->
<script src="../../Assets/Js/logoutModal.js"></script>

</html>
