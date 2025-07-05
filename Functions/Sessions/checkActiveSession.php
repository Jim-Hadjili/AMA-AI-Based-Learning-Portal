<?php
header('Content-Type: application/json');
require_once 'sessionsCheck.php';

// Check if the user is logged in and the session is still valid
if (isLoggedIn()) {
    echo json_encode([
        'valid' => true,
        'message' => 'Session is valid'
    ]);
} else {
    echo json_encode([
        'valid' => false,
        'message' => isset($_SESSION['success_message']) ? $_SESSION['success_message'] : 'Session invalid or expired'
    ]);
}
exit();
?>