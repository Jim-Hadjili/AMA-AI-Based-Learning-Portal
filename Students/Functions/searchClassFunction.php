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

// Find class by code, including status, student count, and quiz count
$stmt = $conn->prepare("SELECT
                            tc.class_id,
                            tc.class_name,
                            tc.class_description,
                            tc.grade_level,
                            tc.strand,
                            tc.created_at,
                            tc.status,
                            (SELECT COUNT(DISTINCT ce.st_id) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count,
                            (SELECT COUNT(q.quiz_id) FROM quizzes_tb q WHERE q.class_id = tc.class_id AND q.status = 'published') AS quiz_count
                        FROM teacher_classes_tb tc
                        WHERE tc.class_code = ?");
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
