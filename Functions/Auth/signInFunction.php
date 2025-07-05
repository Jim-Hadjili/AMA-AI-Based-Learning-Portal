<?php
header('Content-Type: application/json');
require_once '../Sessions/sessionsCheck.php';
include_once '../../Connection/conn.php';

// Initialize session
initSession();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validation
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => implode("<br>", $errors)
        ]);
        exit();
    }
    
    // Check if user exists
    $query = "SELECT * FROM users_tb WHERE userEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => "User not found. Please check your credentials or register."
        ]);
        exit();
    }
    
    $user = $result->fetch_assoc();
    
    // Verify password
    if (!password_verify($password, $user['userPassword'])) {
        echo json_encode([
            'success' => false,
            'message' => "Incorrect password. Please try again."
        ]);
        exit();
    }
    
    // Set session data
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['userName'];
    $_SESSION['user_email'] = $user['userEmail'];
    $_SESSION['user_position'] = $user['userPosition'];
    $_SESSION['login_time'] = time();
    
    // Register this session in the database
    // This will invalidate any existing session for this user
    registerUserSession($user['user_id']);
    
    // Determine redirect URL based on role
    $redirect_url = '';
    if ($user['userPosition'] === 'student') {
        $redirect_url = './Components/Dashboards/studentsDashboards.php';
    } else if ($user['userPosition'] === 'teacher') {
        $redirect_url = './Components/Dashboards/teachersDashboard.php';
    } else {
        $redirect_url = './Components/Dashboards/adminDashboards.php';
    }
    
    echo json_encode([
        'success' => true,
        'message' => "Welcome back, " . $user['userName'] . "!",
        'redirect' => $redirect_url
    ]);
    exit();
}

// If not POST request, return error
echo json_encode([
    'success' => false,
    'message' => "Invalid request method"
]);
exit();
?>