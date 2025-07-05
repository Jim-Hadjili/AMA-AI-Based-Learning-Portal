<?php
header('Content-Type: application/json');
session_start();
include_once '../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $student_id = $_POST['student_id'] ?? '';
    $grade_level = $_POST['grade_level'] ?? '';
    $strand = $_POST['strand'] ?? '';
    
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
    
    if (empty($student_id)) {
        $errors[] = "Student ID is required";
    }
    
    if (empty($grade_level)) {
        $errors[] = "Grade level is required";
    }
    
    if (empty($strand)) {
        $errors[] = "Strand is required";
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
    
    // Check if student ID already exists
    $check_st_query = "SELECT * FROM students_profiles_tb WHERE student_id = ?";
    $check_st_stmt = $conn->prepare($check_st_query);
    $check_st_stmt->bind_param("s", $student_id);
    $check_st_stmt->execute();
    $st_result = $check_st_stmt->get_result();
    
    if ($st_result->num_rows > 0) {
        $errors[] = "Student ID is already registered";
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
    $user_id = 'ST' . date('Ymd') . rand(1000, 9999);
    
    try {
        // Begin transaction
        $conn->begin_transaction();
        
        // Insert into users_tb
        $user_query = "INSERT INTO users_tb (user_id, userName, userEmail, userPosition, userPassword) 
                       VALUES (?, ?, ?, 'student', ?)";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param("ssss", $user_id, $fullname, $email, $hashed_password);
        $user_stmt->execute();
        
        // Insert into students_profiles_tb
        $profile_query = "INSERT INTO students_profiles_tb (st_id, st_userName, st_email, st_position, st_studentdPassword, student_id, grade_level, strand) 
                          VALUES (?, ?, ?, 'student', ?, ?, ?, ?)";
        $profile_stmt = $conn->prepare($profile_query);
        $profile_stmt->bind_param("sssssss", $user_id, $fullname, $email, $hashed_password, $student_id, $grade_level, $strand);
        $profile_stmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        echo json_encode([
            'success' => true,
            'message' => "Student account created successfully! You can now log in.",
            'redirect' => './index.php'
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