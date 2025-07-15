<?php
// This file is included in studentDashboard.php to display notifications based on URL parameters.

// Ensure this script is only run if there are relevant GET parameters
if (isset($_GET['error']) || isset($_GET['success'])) {
    $message = '';
    $type = '';

    if (isset($_GET['error'])) {
        $type = 'error';
        switch ($_GET['error']) {
            case 'missing':
                $message = 'Class code or student ID missing.';
                break;
            case 'invalid':
                $message = 'Invalid class code. Please try again.';
                break;
            case 'already':
                $message = 'You are already enrolled in this class.';
                break;
            default:
                $message = 'An unknown error occurred.';
        }
    } elseif (isset($_GET['success']) && $_GET['success'] === 'joined') {
        $type = 'success';
        $message = 'You have successfully joined the class.';
    }

    // Only echo the JavaScript call if a message was determined
    if (!empty($message)) {
        echo "<script>";
        echo "showNotification('" . htmlspecialchars($message) . "', '" . htmlspecialchars($type) . "');";
        // Clear the URL parameters after showing the notification on initial load
        echo "history.replaceState({}, document.title, window.location.pathname);";
        echo "</script>";
    }
}
?>
