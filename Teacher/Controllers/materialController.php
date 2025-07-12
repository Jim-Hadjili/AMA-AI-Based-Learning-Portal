<?php
session_start();
include_once '../../Assets/Auth/sessionCheck.php';
include_once '../../Connection/conn.php';

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Get current teacher ID
$teacherId = $_SESSION['user_id'];

// Handle different actions
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'upload':
        uploadMaterial($conn, $teacherId);
        break;
    case 'delete':
        deleteMaterial($conn, $teacherId);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit;
}

/**
 * Handle material upload
 */
function uploadMaterial($conn, $teacherId) {
    // Check if all required fields are present
    if (!isset($_POST['class_id']) || !isset($_FILES['material_file'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    $classId = intval($_POST['class_id']);
    $materialTitle = trim($_POST['material_title']);
    $materialDescription = trim($_POST['material_description']);
    
    // Validate if class exists and belongs to this teacher
    $stmt = $conn->prepare("SELECT class_id FROM teacher_classes_tb WHERE class_id = ? AND th_id = ?");
    $stmt->bind_param("is", $classId, $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Class not found or access denied']);
        exit;
    }
    
    // File validation
    $file = $_FILES['material_file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];
    
    // Get file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Allowed file extensions
    $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
    
    // Check if file extension is allowed
    if (!in_array($fileExt, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'File type not allowed']);
        exit;
    }
    
    // Check if there was an error uploading the file
    if ($fileError !== 0) {
        echo json_encode(['success' => false, 'message' => 'Error uploading file']);
        exit;
    }
    
    // Check file size (50MB max)
    if ($fileSize > 50000000) { // 50MB in bytes
        echo json_encode(['success' => false, 'message' => 'File size exceeds limit (50MB)']);
        exit;
    }
    
    // Create directory if it doesn't exist
    $uploadDir = "../../Uploads/Materials/{$classId}/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate unique filename
    $newFileName = uniqid() . '_' . $fileName;
    $uploadPath = $uploadDir . $newFileName;
    
    // Try to move the uploaded file
    if (!move_uploaded_file($fileTmpName, $uploadPath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
        exit;
    }
    
    // File path to store in database (relative path)
    $dbFilePath = "Uploads/Materials/{$classId}/" . $newFileName;
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO learning_materials_tb (class_id, teacher_id, material_title, material_description, file_path, file_name, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $classId, $teacherId, $materialTitle, $materialDescription, $dbFilePath, $fileName, $fileSize, $fileExt);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Material uploaded successfully']);
    } else {
        // If database insert fails, remove the uploaded file
        unlink($uploadPath);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
}

/**
 * Handle material deletion
 */
function deleteMaterial($conn, $teacherId) {
    // Check if material_id is provided
    if (!isset($_POST['material_id']) || !isset($_POST['class_id'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
        exit;
    }
    
    $materialId = intval($_POST['material_id']);
    $classId = intval($_POST['class_id']);
    
    // First get the file path to delete the file
    $stmt = $conn->prepare("SELECT file_path FROM learning_materials_tb WHERE material_id = ? AND teacher_id = ? AND class_id = ?");
    $stmt->bind_param("isi", $materialId, $teacherId, $classId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Material not found or access denied']);
        exit;
    }
    
    $material = $result->fetch_assoc();
    $filePath = '../../' . $material['file_path'];
    
    // Delete from database
    $stmt = $conn->prepare("DELETE FROM learning_materials_tb WHERE material_id = ? AND teacher_id = ? AND class_id = ?");
    $stmt->bind_param("isi", $materialId, $teacherId, $classId);
    
    if ($stmt->execute()) {
        // Try to delete the file
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        echo json_encode(['success' => true, 'message' => 'Material deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
}