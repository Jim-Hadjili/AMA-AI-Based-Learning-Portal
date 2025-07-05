<?php
/**
 * Session Manager
 * 
 * Handles tracking and managing user sessions to ensure only one active session per user
 */

require_once __DIR__ . '/../../Connection/conn.php';

/**
 * Register a new user session in the database
 * 
 * @param string $userId The ID of the logged-in user
 * @return bool True if session was registered successfully
 */
function registerUserSession($userId) {
    global $conn;
    
    // Get the current session ID
    $sessionId = session_id();
    
    // Get user's IP and user agent
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // First, check if there's any existing session for this user
    $checkQuery = "SELECT * FROM user_sessions WHERE user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $userId); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User already has a session, invalidate it
        $deleteQuery = "DELETE FROM user_sessions WHERE user_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
    }
    
    // Register the new session
    $insertQuery = "INSERT INTO user_sessions (session_id, user_id, login_time, last_activity, ip_address, user_agent) 
                    VALUES (?, ?, NOW(), NOW(), ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $sessionId, $userId, $ipAddress, $userAgent);
    
    return $stmt->execute();
}

/**
 * Verify if the current session is valid for the logged-in user
 * 
 * @param string $userId The ID of the logged-in user
 * @return bool True if session is valid, false if another session exists
 */
function verifyUserSession($userId) {
    global $conn;
    
    // Get the current session ID
    $sessionId = session_id();
    
    // Check if this session ID matches the one stored for this user
    $query = "SELECT * FROM user_sessions WHERE user_id = ? AND session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $userId, $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

/**
 * Update the last activity timestamp for a user session
 * 
 * @param string $userId The ID of the logged-in user
 * @return bool True if update was successful
 */
function updateSessionActivity($userId) {
    global $conn;
    
    $sessionId = session_id();
    $query = "UPDATE user_sessions SET last_activity = NOW() WHERE user_id = ? AND session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $userId, $sessionId);
    
    return $stmt->execute();
}

/**
 * Remove a user's session from the database
 * 
 * @param string $userId The ID of the user to remove
 * @return bool True if removal was successful
 */
function removeUserSession($userId) {
    global $conn;
    
    $query = "DELETE FROM user_sessions WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userId);
    
    return $stmt->execute();
}
?>