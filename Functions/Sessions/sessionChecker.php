<?php
/**
 * Session Checker
 * 
 * Provides functions to check and maintain user sessions across the application.
 * Include this file at the top of pages that require authentication.
 */

// Include the core session functions
require_once __DIR__ . '/sessionsCheck.php';

/**
 * Verifies if a user is logged in and redirects appropriately
 * 
 * @param bool $requireLogin Whether login is required for this page
 * @param array $allowedRoles Array of user roles allowed to access the page
 * @param string $loginRedirect URL to redirect to if login is required but user is not logged in
 * @param string $accessDeniedRedirect URL to redirect to if user doesn't have appropriate role
 * @return bool True if session is valid, redirects otherwise
 */
function checkSession($requireLogin = true, $allowedRoles = [], $loginRedirect = '../../index.php', $accessDeniedRedirect = '../../index.php') {
    // Initialize the session
    initSession();
    
    // If login is required but user is not logged in
    if ($requireLogin && !isLoggedIn()) {
        // Store the requested URL to redirect back after login
        $_SESSION['redirect_after_login'] = getCurrentPageURL();
        
        // Set message and redirect
        $_SESSION['error_message'] = "Please log in to access this page.";
        header("Location: $loginRedirect");
        exit();
    }
    
    // If specific roles are required and user doesn't have them
    if ($requireLogin && !empty($allowedRoles) && !hasAccess($allowedRoles)) {
        $_SESSION['error_message'] = "You don't have permission to access this page.";
        header("Location: $accessDeniedRedirect");
        exit();
    }
    
    return true;
}

/**
 * Get the current page URL
 * 
 * @return string The current page URL
 */
function getCurrentPageURL() {
    $pageURL = 'http';
    
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $pageURL .= "s";
    }
    
    $pageURL .= "://";
    
    if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    
    return $pageURL;
}

/**
 * Redirect after login based on stored redirect or user role
 */
function redirectAfterLogin() {
    // Check if there's a stored redirect URL
    if (isset($_SESSION['redirect_after_login'])) {
        $redirectUrl = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        header("Location: $redirectUrl");
        exit();
    }
    
    // Otherwise, redirect based on user role
    $position = $_SESSION['user_position'] ?? '';
    $redirectUrl = '';
    
    switch ($position) {
        case 'student':
            $redirectUrl = './Components/Dashboards/studentsDashboards.php';
            break;
        case 'teacher':
            $redirectUrl = './Components/Dashboards/teachersDashboard.php';
            break;
        case 'admin':
            $redirectUrl = './Components/Dashboards/adminDashboards.php';
            break;
        default:
            $redirectUrl = './index.php';
            break;
    }
    
    header("Location: $redirectUrl");
    exit();
}

/**
 * Process user logout
 * 
 * @param string $message Optional message to display after logout
 * @param string $redirectUrl URL to redirect to after logout
 */
function logout($message = null, $redirectUrl = '../../index.php') {
    // End the session (using function from sessionsCheck.php)
    endSession($message);
    
    // Redirect after logout
    header("Location: $redirectUrl");
    exit();
}
?>
<?php
require_once '../../Functions/Sessions/sessionChecker.php';

// For pages that require login with specific roles
checkSession(true, ['admin', 'teacher']);  

// For pages that require just being logged in
// checkSession(true); 

// For public pages that enhance experience when logged in but don't require it
// checkSession(false);
?>