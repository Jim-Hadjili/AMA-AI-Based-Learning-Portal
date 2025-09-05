<?php
header('Content-Type: application/json');
session_start();
include_once '../../Connection/conn.php';
include_once 'sessionCheck.php'; // Include session functions

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
    $_SESSION['session_token'] = generateSessionToken();
    if ($user['userPosition'] === 'student') {
        $_SESSION['st_id'] = $user['user_id'];
        // Load grade_level and strand for student
        $stmt = $conn->prepare("SELECT grade_level, strand FROM students_profiles_tb WHERE st_id = ?");
        $stmt->bind_param("s", $_SESSION['st_id']);
        $stmt->execute();
        $stmt->bind_result($grade_level, $strand);
        if ($stmt->fetch()) {
            $_SESSION['grade_level'] = $grade_level;
            $_SESSION['strand'] = $strand;
        }
        $stmt->close();
    }
    
    // Determine redirect URL based on role
    $redirect_url = '';
    if ($user['userPosition'] === 'student') {
        $redirect_url = './Students/Contents/Dashboard/studentDashboard.php';
    } else if ($user['userPosition'] === 'teacher') {
        $redirect_url = './Teacher/Contents/Dashboard/teachersDashboard.php';
    } else {
        $redirect_url = './content/dashboards/adminDashboard.php';
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