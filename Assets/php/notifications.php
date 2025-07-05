<?php 
// Initialize notification variables
$notification = '';
$notificationType = '';

// Handle notification messages
if (isset($_SESSION['success_message'])) {
    $notification = $_SESSION['success_message'];
    $notificationType = 'success';
    unset($_SESSION['success_message']);
} elseif (isset($_SESSION['error_message'])) {
    $notification = $_SESSION['error_message'];
    $notificationType = 'error';
    unset($_SESSION['error_message']);
}

?>