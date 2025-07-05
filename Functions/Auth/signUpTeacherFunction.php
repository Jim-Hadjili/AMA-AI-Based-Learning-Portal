<?php
header('Content-Type: application/json');
session_start();
include_once '../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $employee_id = $_POST['employee_id'] ?? '';
    $department = $_POST['department'] ?? '';
    $subject_expertise = $_POST['subject_expertise'] ?? '';
    
    // Validation
    $errors = [];
    
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if (empty($employee_id)) {
        $errors[] = "Employee ID is required";
    }
    
    if (empty($department)) {
        $errors[] = "Department is required";
    }
    
    if (empty($subject_expertise)) {
        $errors[] = "Subject expertise is required";
    }
    
    // Check if email already exists in users_tb
    $check_query = "SELECT * FROM users_tb WHERE userEmail = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errors[] = "This email is already registered";
    }
    
    // Check if the teacher ID already exists - only check by th_id
    $check_th_query = "SELECT * FROM teachers_profiles_tb WHERE th_id = ?";
    $check_th_stmt = $conn->prepare($check_th_query);
    $check_th_stmt->bind_param("s", $employee_id);
    $check_th_stmt->execute();
    $th_result = $check_th_stmt->get_result();
    
    if ($th_result->num_rows > 0) {
        $errors[] = "Employee ID is already registered";
    }
    
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => implode("<br>", $errors)
        ]);
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Generate a unique user ID
    $user_id = 'TC' . date('Ymd') . rand(1000, 9999);
    
    try {
        // Begin transaction
        $conn->begin_transaction();
        
        // Insert into users_tb
        $user_query = "INSERT INTO users_tb (user_id, userName, userEmail, userPosition, userPassword) 
                       VALUES (?, ?, ?, 'teacher', ?)";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param("ssss", $user_id, $fullname, $email, $hashed_password);
        $user_stmt->execute();
        
        // Insert into teachers_profiles_tb with employee_id as th_id
        $profile_query = "INSERT INTO teachers_profiles_tb (th_id, th_userName, th_Email, th_position, th_teacherPasswor, department, subject_expertise) 
                          VALUES (?, ?, ?, 'teacher', ?, ?, ?)";
        $profile_stmt = $conn->prepare($profile_query);
        $profile_stmt->bind_param("ssssss", $employee_id, $fullname, $email, $hashed_password, $department, $subject_expertise);
        $profile_stmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        // Set session data for automatic login
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $fullname;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_position'] = 'teacher';
        $_SESSION['login_time'] = time();
        
        echo json_encode([
            'success' => true,
            'message' => "Teacher account created successfully!",
            'redirect' => './content/dashboards/teachersDashboard.php'
        ]);
        exit();
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'message' => "Registration failed: " . $e->getMessage()
        ]);
        exit();
    }
}

// If not POST request, return error
echo json_encode([
    'success' => false,
    'message' => "Invalid request method"
]);
exit();
?>