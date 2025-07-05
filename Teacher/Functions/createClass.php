<?php
session_start();
require_once '../../Connection/conn.php';

// Set header for JSON response
header('Content-Type: application/json');

// Check if user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get teacher ID from session
    $teacher_id = $_SESSION['user_id'];
    
    // Get form data
    $class_name = trim($_POST['class_name'] ?? '');
    $class_code = trim($_POST['class_code'] ?? '');
    $class_description = trim($_POST['class_description'] ?? '');
    $grade_level = trim($_POST['grade_level'] ?? '');
    $strand = trim($_POST['strand'] ?? '');
    
    // Validate inputs
    if (empty($class_name)) {
        echo json_encode(['success' => false, 'message' => 'Class name is required']);
        exit;
    }
    
    if (empty($class_code)) {
        echo json_encode(['success' => false, 'message' => 'Class code is required']);
        exit;
    }
    
    if (empty($grade_level)) {
        echo json_encode(['success' => false, 'message' => 'Grade level is required']);
        exit;
    }
    
    // Check if class code already exists
    $check_code_sql = "SELECT class_id FROM teacher_classes_tb WHERE class_code = ?";
    $check_stmt = $conn->prepare($check_code_sql);
    $check_stmt->bind_param("s", $class_code);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Class code already exists. Please use a different code.']);
        exit;
    }
    
    // Insert the new class into the database
    $sql = "INSERT INTO teacher_classes_tb (th_id, class_name, class_code, class_description, grade_level, strand, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'active')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $teacher_id, $class_name, $class_code, $class_description, $grade_level, $strand);
    
    if ($stmt->execute()) {
        $class_id = $conn->insert_id;
        echo json_encode([
            'success' => true, 
            'message' => 'Class created successfully!',
            'class' => [
                'id' => $class_id,
                'name' => $class_name,
                'code' => $class_code
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating class: ' . $conn->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>