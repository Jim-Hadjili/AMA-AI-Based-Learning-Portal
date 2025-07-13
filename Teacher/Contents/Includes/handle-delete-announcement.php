<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once  '../../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve announcement_id and class_id
    $announcement_id = isset($_POST['announcement_id']) ? intval($_POST['announcement_id']) : 0;
    $class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : 0; // For redirection

    // Basic validation
    if ($announcement_id === 0 || $class_id === 0) {
        $errorMessage = "Invalid announcement ID or class ID provided for deletion.";
        error_log("Delete Announcement Validation Error: " . $errorMessage . " Data: " . print_r($_POST, true));
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }

    // Prepare SQL statement to delete the announcement
    // Add class_id to the WHERE clause for security, ensuring only announcements from the current class can be deleted
    $sql = "DELETE FROM announcements_tb WHERE announcement_id = ? AND class_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $errorMessage = "Database error: Could not prepare statement for delete. Error: " . $conn->error;
        error_log($errorMessage);
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }

    // Bind parameters and execute the statement
    // 'ii' corresponds to int, int
    $stmt->bind_param("ii", $announcement_id, $class_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $successMessage = "Announcement deleted successfully!";
            error_log("Announcement ID " . $announcement_id . " deleted successfully.");
            header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=success&message=" . urlencode($successMessage));
            exit();
        } else {
            $errorMessage = "No announcement found with ID " . $announcement_id . " in class " . $class_id . " or it was already deleted.";
            error_log($errorMessage);
            header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
            exit();
        }
    } else {
        $errorMessage = "Error deleting announcement: " . $stmt->error;
        error_log($errorMessage);
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }
    $stmt->close();
} else {
    // If accessed directly without POST data
    error_log("handle-delete-announcement.php accessed directly without POST data.");
    header("Location: ../Views/Teachers/teachersDashboard.php"); // Redirect to a default page
    exit();
}

$conn->close();
?>
