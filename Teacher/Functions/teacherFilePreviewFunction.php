<?php
session_start();
include_once '../../Assets/Auth/sessionCheck.php';
include_once '../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Check if material_id is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$material_id = intval($_GET['id']);
$teacher_id = $_SESSION['user_id'];

// Get material details
$stmt = $conn->prepare("SELECT m.*, c.class_name FROM learning_materials_tb m 
                       JOIN teacher_classes_tb c ON m.class_id = c.class_id 
                       WHERE m.material_id = ? AND m.teacher_id = ?");
$stmt->bind_param("is", $material_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Material not found or doesn't belong to this teacher
    header("Location: ../Dashboard/teachersDashboard.php");
    exit;
}

$material = $result->fetch_assoc();
$file_path = '../../' . $material['file_path'];
$extension = pathinfo($material['file_path'], PATHINFO_EXTENSION);

// Helper function for file size formatting
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>