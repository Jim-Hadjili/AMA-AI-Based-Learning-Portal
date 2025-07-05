<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$session_token = $_SESSION['session_token'];

// Get teacher ID from database
$teacherId = null;
$query = "SELECT th_id FROM teachers_profiles_tb WHERE th_Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teacherId = $row['th_id'];
}

// Get teacher's classes
$classes = [];
$activeClassesCount = 0;

if ($teacherId) {
    $classQuery = "SELECT * FROM teacher_classes_tb WHERE th_id = ? ORDER BY created_at DESC";
    $classStmt = $conn->prepare($classQuery);
    $classStmt->bind_param("s", $teacherId);
    $classStmt->execute();
    $classResult = $classStmt->get_result();

    if ($classResult->num_rows > 0) {
        while ($classRow = $classResult->fetch_assoc()) {
            $classes[] = $classRow;
            if ($classRow['status'] === 'active') {
                $activeClassesCount++;
            }
        }
    }
}
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

            <!-- Content Sections -->
            <?php include "../Includes/teacherContents.php"; ?>
        </main>
    </div>


</body>
<script src="../../Assets/Js/teacherDashAnimation.js"></script>
<script src="../../Assets/Js/generateRandomClassCode.js"></script>

</html>