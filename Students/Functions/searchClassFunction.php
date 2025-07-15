<?php
session_start();
require_once "../../Connection/conn.php"; // Update path as needed

header('Content-Type: application/json'); // Set header for JSON response

// Get student ID from session (adjust key as needed)
$student_id = $_SESSION['st_id'] ?? null;
$class_code = $_POST['class_code'] ?? '';

if (!$student_id || !$class_code) {
    echo json_encode(['status' => 'error', 'message' => 'Class code or student ID missing.']);
    exit;
}

// Find class by code
$stmt = $conn->prepare("SELECT class_id, class_name, class_description, grade_level, strand, created_at FROM teacher_classes_tb WHERE class_code = ?");
$stmt->bind_param("s", $class_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid class code. Please try again.']);
    exit;
}

$class = $result->fetch_assoc();
$class_id = $class['class_id'];

// Check if already enrolled
$check = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ?");
$check->bind_param("is", $class_id, $student_id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You are already enrolled in this class.']);
    exit;
}

// If class found and not enrolled, return class details
echo json_encode(['status' => 'success', 'class' => $class]);
exit;
?>
