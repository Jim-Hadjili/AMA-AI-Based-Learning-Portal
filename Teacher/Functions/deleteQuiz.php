<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    $response = [
        'success' => false,
        'message' => 'Unauthorized access'
    ];
    echo json_encode($response);
    exit;
}

// Check if request is POST and has required data
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['quiz_id'])) {
    $response = [
        'success' => false,
        'message' => 'Invalid request'
    ];
    echo json_encode($response);
    exit;
}

// Database connection
require_once __DIR__ . '/../../Config/Database.php';

try {
    $quizId = intval($_POST['quiz_id']);
    $teacherId = $_SESSION['user_id'];
    
    // First, verify that the quiz belongs to the logged-in teacher
    $stmt = $conn->prepare("SELECT quiz_id FROM quizzes_tb WHERE quiz_id = ? AND th_id = ?");
    $stmt->bind_param("is", $quizId, $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $response = [
            'success' => false,
            'message' => 'Quiz not found or you do not have permission to delete it'
        ];
        echo json_encode($response);
        exit;
    }
    
    // If we get here, the quiz exists and belongs to the teacher
    // Due to foreign key constraints and cascading deletes, we only need to delete from the quizzes_tb
    $stmt = $conn->prepare("DELETE FROM quizzes_tb WHERE quiz_id = ?");
    $stmt->bind_param("i", $quizId);
    $success = $stmt->execute();
    
    if ($success) {
        $response = [
            'success' => true,
            'message' => 'Quiz deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting quiz: ' . $conn->error
        ];
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ];
    echo json_encode($response);
}
?>