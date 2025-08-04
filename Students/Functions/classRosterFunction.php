<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Auth/login.php");
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_position = $_SESSION['user_position'];

// Get the student ID if user is a student
$student_id = $_SESSION['st_id'] ?? null;

// Get class ID from URL parameter
$class_id = $_GET['class_id'] ?? null;

if (!$class_id) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Fetch class details
$classDetails = null;
$classQuery = "SELECT tc.* FROM teacher_classes_tb tc WHERE tc.class_id = ?";
$stmt = $conn->prepare($classQuery);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $classDetails = $result->fetch_assoc();
} else {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Check if user has access to this class
$hasAccess = false;
if ($user_position === 'teacher') {
    // Teachers can access classes they created
    $hasAccess = ($classDetails['th_id'] === $user_id);
} else {
    // Students can access classes they're enrolled in
    $enrollmentCheck = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ? AND status = 'active'");
    if ($student_id) {
        $enrollmentCheck->bind_param("is", $class_id, $student_id);
        $enrollmentCheck->execute();
        $hasAccess = ($enrollmentCheck->get_result()->num_rows > 0);
    }
}

if (!$hasAccess) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Fetch all classmates with ALL available information from class_enrollments_tb
$classmates = [];
$classmatesQuery = "SELECT 
                   ce.*,
                   sp.st_userName,
                   sp.st_email as profile_email,
                   sp.profile_picture,
                   sp.grade_level,
                   sp.strand,
                   sp.student_id as profile_student_id
                FROM class_enrollments_tb ce
                LEFT JOIN students_profiles_tb sp ON ce.st_id = sp.st_id
                WHERE ce.class_id = ? AND ce.status = 'active'
                ORDER BY sp.st_userName, ce.student_name";

$classmatesStmt = $conn->prepare($classmatesQuery);
$classmatesStmt->bind_param("i", $class_id);
$classmatesStmt->execute();
$classmatesResult = $classmatesStmt->get_result();

while ($student = $classmatesResult->fetch_assoc()) {
    // Use the student profile name if available, otherwise fall back to enrollment name
    if (!empty($student['st_userName'])) {
        $student['student_name'] = $student['st_userName'];
    }
    
    // Use profile email if available, otherwise fall back to enrollment email
    if (!empty($student['profile_email'])) {
        $student['email'] = $student['profile_email'];
    } else {
        $student['email'] = $student['student_email'] ?? 'No email available';
    }
    
    // Use profile student ID if available
    if (!empty($student['profile_student_id'])) {
        $student['student_id'] = $student['profile_student_id'];
    }
    
    $classmates[] = $student;
}
?>