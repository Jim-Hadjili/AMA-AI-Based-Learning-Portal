<?php
// This is a temporary file for testing purposes
// Redirect to the real controller for actual functionality

session_start();

// Log the request for debugging
error_log("Test controller received request: " . json_encode($_POST));

// Forward the request to the real controller
include_once 'classActionController.php';

// The code should never reach here as classActionController.php exits
// But just in case, return a success response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'Test controller forwarded request to real controller',
    'received_data' => $_POST
]);
?>