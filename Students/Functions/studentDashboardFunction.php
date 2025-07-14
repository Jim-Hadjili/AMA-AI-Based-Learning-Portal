<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a student
checkUserAccess('student');

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$session_token = $_SESSION['session_token']; // Get the session token

// Get student ID from database
$studentId = null;
$query = "SELECT st_id FROM students_profiles_tb WHERE st_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $studentId = $row['st_id'];
}

// Get enrolled classes
$enrolledClasses = [];
$enrolledCount = 0;

if ($studentId) {
    // Get classes the student is enrolled in
    $classQuery = "SELECT tc.* FROM teacher_classes_tb tc 
                   INNER JOIN class_enrollments_tb ce ON tc.class_id = ce.class_id 
                   WHERE ce.st_id = ? AND tc.status = 'active'
                   ORDER BY tc.created_at DESC";
    $classStmt = $conn->prepare($classQuery);
    $classStmt->bind_param("s", $studentId);
    $classStmt->execute();
    $classResult = $classStmt->get_result();

    while ($class = $classResult->fetch_assoc()) {
        $enrolledClasses[] = $class;
    }
    $enrolledCount = count($enrolledClasses);
}
