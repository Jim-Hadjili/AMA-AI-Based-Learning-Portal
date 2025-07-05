<?php
/**
 * Session Management Functions
 * 
 * This file contains functions to check and manage user sessions
 */

require_once __DIR__ . '/sessionManager.php';

// Start session if not already started
function initSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Check if user is logged in
 * 
 * @return bool Returns true if user is logged in, false otherwise
 */
function isLoggedIn() {
    initSession();
    
    if (!isset($_SESSION['user_id']) || 
        !isset($_SESSION['user_name']) || 
        !isset($_SESSION['user_position']) || 
        !isset($_SESSION['login_time'])) {
        return false;
    }
    
    // Check if this is still the valid session for this user
    if (!verifyUserSession($_SESSION['user_id'])) {
        // This session has been invalidated by another login
        endSession("Your account has been logged in from another location.");
        return false;
    }
    
    // Update the last activity timestamp
    updateSessionActivity($_SESSION['user_id']);
    
    return true;
}

/**
 * Get current user data
 * 
 * @return array|null Returns array with user data if logged in, null otherwise
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'user_id' => $_SESSION['user_id'],
        'user_name' => $_SESSION['user_name'],
        'user_email' => $_SESSION['user_email'] ?? null,
        'user_position' => $_SESSION['user_position'],
        'login_time' => $_SESSION['login_time']
    ];
}

/**
 * Check if user has appropriate role for accessing a page
 * 
 * @param array $allowedRoles Array of roles allowed to access the page
 * @return bool Returns true if user has appropriate role, false otherwise
 */
function hasAccess($allowedRoles = []) {
    if (!isLoggedIn()) {
        return false;
    }
    
    // If no specific roles are required, any logged-in user can access
    if (empty($allowedRoles)) {
        return true;
    }
    
    return in_array($_SESSION['user_position'], $allowedRoles);
}

/**
 * End user session and set logout message
 * 
 * @param string $message Optional message to display after session end
 */
function endSession($message = null) {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Remove the session from the database if user was logged in
    if (isset($_SESSION['user_id'])) {
        removeUserSession($_SESSION['user_id']);
    }
    
    // Clear all session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    // Set success message if provided
    if ($message !== null) {
        // Start a new session to store the message
        session_start();
        $_SESSION['success_message'] = $message;
    }
}

/**
 * Redirect user based on their role if they're already logged in
 */
function redirectLoggedInUser() {
    if (!isLoggedIn()) {
        return;
    }
    
    $position = $_SESSION['user_position'];
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
?>
