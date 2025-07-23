<?php
session_start();
require_once "../../Connection/conn.php";

header('Content-Type: application/json');

$student_id = $_SESSION['st_id'] ?? null;
$class_id = $_POST['class_id'] ?? null;

if (!$student_id || !$class_id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing student ID or class ID for enrollment.']);
    exit;
}

// Fetch student details (now also fetching strand and student_id)
$student_stmt = $conn->prepare("SELECT st_userName, st_email, grade_level, strand, student_id FROM students_profiles_tb WHERE st_id = ?");
$student_stmt->bind_param("s", $student_id);
$student_stmt->execute();
$student_result = $student_stmt->get_result();

if ($student_result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Student profile not found.']);
    exit;
}
$student = $student_result->fetch_assoc();
$student_name = $student['st_userName'];
$student_email = $student['st_email'];
$grade_level = $student['grade_level'];
$strand = $student['strand'];
$student_number = $student['student_id']; // This is the actual student number/id

// Check if already enrolled
$check = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ?");
$check->bind_param("is", $class_id, $student_id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'You are already enrolled in this class.']);
    exit;
}

// Enroll student with additional info (including strand and student_id)
$enroll = $conn->prepare("INSERT INTO class_enrollments_tb (class_id, st_id, student_id, student_name, student_email, grade_level, strand, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
$enroll->bind_param("issssss", $class_id, $student_id, $student_number, $student_name, $student_email, $grade_level, $strand);

if ($enroll->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Successfully joined the class!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to enroll in class. Please try again.']);
}
exit;
?>
