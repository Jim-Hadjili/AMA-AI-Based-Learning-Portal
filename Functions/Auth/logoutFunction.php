<?php
// Add these security headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require_once '../Sessions/sessionChecker.php';

// Determine the proper redirect URL based on the request context
// Check if we're in a subdirectory (Components, etc.)
$redirectUrl = '../../index.php'; // Default path when called from Components folder

// If HTTP_REFERER is available, use it to determine our location
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    
    // If not in Components folder (likely at root level)
    if (strpos($referer, '/Components/') === false && strpos($referer, '/Functions/') === false) {
        $redirectUrl = './index.php';
    }
}

// Process logout with optional message
$message = $_GET['message'] ?? "You have been logged out successfully.";
logout($message, $redirectUrl);
?>