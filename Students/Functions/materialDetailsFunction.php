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

// Get material ID from URL parameter
$material_id = $_GET['material_id'] ?? null;

if (!$material_id) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Helper function to determine subject from class name
function getSubjectFromClassName($className) {
    $classNameLower = strtolower($className);
    $subjectKeywords = [
        'english' => 'English',
        'math' => 'Math',
        'science' => 'Science',
        'history' => 'History',
        'arts' => 'Arts',
        'pe' => 'PE',
        'ict' => 'ICT',
        'home economics' => 'Home Economics',
    ];

    foreach ($subjectKeywords as $keyword => $subject) {
        if (strpos($classNameLower, $keyword) !== false) {
            return $subject;
        }
    }
    return 'Default';
}

// Helper function to get file type icon
function getFileTypeIcon($fileType) {
    $icons = [
        'pdf' => 'fas fa-file-pdf',
        'doc' => 'fas fa-file-word',
        'docx' => 'fas fa-file-word',
        'ppt' => 'fas fa-file-powerpoint',
        'pptx' => 'fas fa-file-powerpoint',
        'xls' => 'fas fa-file-excel',
        'xlsx' => 'fas fa-file-excel',
        'txt' => 'fas fa-file-alt',
        'jpg' => 'fas fa-file-image',
        'jpeg' => 'fas fa-file-image',
        'png' => 'fas fa-file-image',
        'gif' => 'fas fa-file-image',
        'mp4' => 'fas fa-file-video',
        'avi' => 'fas fa-file-video',
        'mov' => 'fas fa-file-video',
        'mp3' => 'fas fa-file-audio',
        'wav' => 'fas fa-file-audio',
        'zip' => 'fas fa-file-archive',
        'rar' => 'fas fa-file-archive',
    ];
    
    return $icons[strtolower($fileType)] ?? 'fas fa-file';
}

// Helper function to format file size
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

// Fetch material details with class information
$materialDetails = null;
$materialQuery = "SELECT lm.*, tc.class_name, tc.class_code, tc.grade_level, tc.strand, tc.th_id,
                         tp.th_userName as teacher_name
                  FROM learning_materials_tb lm
                  JOIN teacher_classes_tb tc ON lm.class_id = tc.class_id
                  LEFT JOIN teachers_profiles_tb tp ON tc.th_id = tp.th_id
                  WHERE lm.material_id = ?";

$stmt = $conn->prepare($materialQuery);
$stmt->bind_param("i", $material_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $materialDetails = $result->fetch_assoc();
    $materialDetails['class_subject'] = getSubjectFromClassName($materialDetails['class_name']);
    $materialDetails['file_icon'] = getFileTypeIcon($materialDetails['file_type']);
    $materialDetails['formatted_file_size'] = formatFileSize($materialDetails['file_size']);
} else {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Check if user has access to this material
$hasAccess = false;
if ($user_position === 'teacher') {
    // Teachers can access materials from classes they created
    $hasAccess = ($materialDetails['th_id'] === $user_id);
} else {
    // Students can access materials from classes they're enrolled in
    $enrollmentCheck = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ? AND status = 'active'");
    $student_id = $_SESSION['st_id'] ?? null;
    if ($student_id) {
        $enrollmentCheck->bind_param("is", $materialDetails['class_id'], $student_id);
        $enrollmentCheck->execute();
        $hasAccess = ($enrollmentCheck->get_result()->num_rows > 0);
    }
}

if (!$hasAccess) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Check if file exists - materialPreview.php is in Contents/Dashboard/, so we need to go up 2 levels
$serverFilePath = "../../../" . $materialDetails['file_path'];
$fileExists = file_exists($serverFilePath);

// For web access (iframe, img src), use the same path since it's relative to materialPreview.php
$webFilePath = "../../../" . $materialDetails['file_path'];

// Determine if file can be previewed in browser
$previewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'];
$canPreview = in_array(strtolower($materialDetails['file_type']), $previewableTypes);




?>
