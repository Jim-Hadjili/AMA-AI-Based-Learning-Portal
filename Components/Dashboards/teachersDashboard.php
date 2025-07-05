<?php
// Add these lines at the very top of each dashboard file
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require_once '../../Functions/Sessions/sessionChecker.php';

// Only teachers can access this page
checkSession(true, ['teacher']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Teacher Dashboard - AMA College</title>
    <!-- Security script must be loaded before any other scripts -->
    <script src="../../Assets/Js/dashboardSecurity.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Additional stylesheets -->
</head>
<body>
    <!-- Dashboard content here -->
    
    <a href="../../Functions/Auth/logoutFunction.php" class="logout-btn">Logout</a>
    
    <!-- Include the session confirmation modal -->
    <?php include_once '../Shared/sessionConfirmationModal.php'; ?>
    
    <!-- Include necessary scripts -->
    <script src="../../Assets/Js/sessionConfirmation.js"></script>
    <script src="../../Assets/Js/sessionStatus.js"></script>
</body>
</html>