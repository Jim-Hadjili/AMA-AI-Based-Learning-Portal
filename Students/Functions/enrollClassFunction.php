<?php
session_start();
require_once "../../Connection/conn.php"; // Update path as needed

header('Content-Type: application/json'); // Set header for JSON response

// Get student ID from session
$student_id = $_SESSION['st_id'] ?? null;
// Get class ID from POST request
$class_id = $_POST['class_id'] ?? null;

if (!$student_id || !$class_id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing student ID or class ID for enrollment.']);
    exit;
}

// Re-check if already enrolled (important for security and data integrity)
$check = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ?");
$check->bind_param("is", $class_id, $student_id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You are already enrolled in this class.']);
    exit;
}

// Enroll student
$enroll = $conn->prepare("INSERT INTO class_enrollments_tb (class_id, st_id, status) VALUES (?, ?, 'active')");
$enroll->bind_param("is", $class_id, $student_id);

if ($enroll->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Successfully joined the class!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to enroll in class. Please try again.']);
}
exit;
?>
