<?php
// Session validation function
function validateSession() {
    // Check if session exists
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['login_time']) || !isset($_SESSION['session_token'])) {
        return false;
    }
    
    // Check session timeout (24 hours = 86400 seconds)
    $session_timeout = 86400;
    if (time() - $_SESSION['login_time'] > $session_timeout) {
        // Session expired
        session_unset();
        session_destroy();
        return false;
    }
    
    // Verify the session token matches the one in the URL or POST data if present
    if (isset($_GET['token']) && $_GET['token'] !== $_SESSION['session_token']) {
        return false;
    }
    
    return true;
}

// Function to check user role access
function checkUserAccess($required_role) {
    if (!validateSession()) {
        header("Location: ../../index.php");
        exit();
    }
    
    if ($_SESSION['user_position'] !== $required_role) {
        header("Location: ../../index.php");
        exit();
    }
    
    // Add token to any links in the page
    $token = $_SESSION['session_token'];
    
    return true;
}

// Function to prevent back button access after logout
function preventBackButton() {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
}

// Function to generate a random session token
function generateSessionToken() {
    return bin2hex(random_bytes(16)); // 32 character random string
}
?>