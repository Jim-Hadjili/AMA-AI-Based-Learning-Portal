<?php
session_start();

// Fix the paths using __DIR__ to make paths absolute
include_once __DIR__ . '/../../Connection/conn.php';
include_once __DIR__ . '/../../Assets/Auth/sessionCheck.php';

// Check if user is logged in and is a teacher
if (!function_exists('checkUserAccess')) {
    // Fallback function if sessionCheck.php didn't load correctly
    function checkUserAccess($role) {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $role) {
            // Return an error response instead of redirecting since this is an AJAX endpoint
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            exit;
        }
    }
}

checkUserAccess('teacher');

// Handle different actions based on request
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Response array
$response = ['success' => false, 'message' => 'Invalid action'];

switch ($action) {
    case 'updateClass':
        $response = updateClass($conn);
        break;
    // Other actions can be added here
    default:
        // Invalid action, response is already set
        break;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;

/**
 * Update class details
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function updateClass($conn) {
    try {
        // Log the incoming data for debugging
        error_log("Update Class Request: " . json_encode($_POST));

        // Validate required fields
        if (!isset($_POST['class_id']) || !isset($_POST['class_name']) || empty($_POST['class_name'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }

        $class_id = intval($_POST['class_id']);
        $class_name = trim($_POST['class_name']);
        $class_description = isset($_POST['class_description']) ? trim($_POST['class_description']) : '';
        $grade_level = isset($_POST['grade_level']) ? trim($_POST['grade_level']) : '';
        $strand = isset($_POST['strand']) ? trim($_POST['strand']) : '';
        $status = isset($_POST['status']) ? trim($_POST['status']) : 'active';

        // Verify the class belongs to the current teacher
        // If the teacher_id is stored differently in your session, adjust this line
        $teacher_id = $_SESSION['user_id']; 
        
        $checkQuery = "SELECT class_id FROM teacher_classes_tb WHERE class_id = ? AND th_id = ?";
        $stmt = $conn->prepare($checkQuery);
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
        }
        
        $stmt->bind_param("is", $class_id, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'You do not have permission to edit this class'];
        }

        // Update the class
        $updateQuery = "UPDATE teacher_classes_tb SET 
                        class_name = ?, 
                        class_description = ?, 
                        grade_level = ?, 
                        strand = ?, 
                        status = ?,
                        updated_at = NOW() 
                        WHERE class_id = ?";
        
        $stmt = $conn->prepare($updateQuery);
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
        }
        
        $stmt->bind_param("sssssi", 
                          $class_name, 
                          $class_description, 
                          $grade_level, 
                          $strand, 
                          $status, 
                          $class_id);
        
        $result = $stmt->execute();
        
        if ($result) {
            return [
                'success' => true, 
                'message' => 'Class updated successfully',
                'class_id' => $class_id,
                'class_name' => $class_name,
                'class_description' => $class_description,
                'grade_level' => $grade_level,
                'strand' => $strand,
                'status' => $status
            ];
        } else {
            return ['success' => false, 'message' => 'Failed to update class: ' . $stmt->error];
        }
    } catch (Exception $e) {
        error_log("Error updating class: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while updating the class: ' . $e->getMessage()];
    }
}
?>