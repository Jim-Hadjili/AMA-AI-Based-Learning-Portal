<?php
require_once '../../Functions/Sessions/sessionChecker.php';

// Only admin users can access this page
checkSession(true, ['admin']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AMA College</title>
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