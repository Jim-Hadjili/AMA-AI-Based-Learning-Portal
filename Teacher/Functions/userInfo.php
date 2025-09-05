<?php
// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$session_token = $_SESSION['session_token'];

// Get teacher ID from database
$teacherId = null;
$query = "SELECT th_id, profile_picture, th_position, employee_id, department, subject_expertise FROM teachers_profiles_tb WHERE th_Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teacherId = $row['th_id'];
    $profile_picture = $row['profile_picture'];
    $th_position = $row['th_position'];
    $employee_id = $row['employee_id'];
    $department = $row['department'];
    $subject_expertise = $row['subject_expertise'];
    $_SESSION['profile_picture'] = $profile_picture;
}

// Get teacher's classes
$classes = [];
$activeClassesCount = 0;

if ($teacherId) {
    $classQuery = "SELECT * FROM teacher_classes_tb WHERE th_id = ? ORDER BY created_at DESC";
    $classStmt = $conn->prepare($classQuery);
    $classStmt->bind_param("s", $teacherId);
    $classStmt->execute();
    $classResult = $classStmt->get_result();

    if ($classResult->num_rows > 0) {
        while ($classRow = $classResult->fetch_assoc()) {
            $classes[] = $classRow;
            if ($classRow['status'] === 'active') {
                $activeClassesCount++;
            }
        }
    }
}
