<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include_once '../../../Connection/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $announcement_id = isset($_POST['announcement_id']) ? intval($_POST['announcement_id']) : 0;
    $class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : 0; // Ensure class_id is passed back for redirection
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $content = $conn->real_escape_string($_POST['content'] ?? '');
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;

    // Basic validation
    if ($announcement_id === 0 || empty($title) || empty($content) || $class_id === 0) {
        $errorMessage = "Invalid data provided for editing announcement.";
        error_log("Edit Announcement Validation Error: " . $errorMessage . " Data: " . print_r($_POST, true));
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }

    // Prepare SQL statement to update the announcement
    $sql = "UPDATE announcements_tb SET title = ?, content = ?, is_pinned = ?, created_at = NOW() WHERE announcement_id = ? AND class_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $errorMessage = "Database error: Could not prepare statement for update. Error: " . $conn->error;
        error_log($errorMessage);
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }

    // Bind parameters and execute the statement
    // 'ssiii' corresponds to string, string, int, int, int
    $stmt->bind_param("ssiii", $title, $content, $is_pinned, $announcement_id, $class_id);
    
    if ($stmt->execute()) {
        $successMessage = "Announcement updated successfully!";
        error_log("Announcement ID " . $announcement_id . " updated successfully.");
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=success&message=" . urlencode($successMessage));
        exit();
    } else {
        $errorMessage = "Error updating announcement: " . $stmt->error;
        error_log($errorMessage);
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }
    $stmt->close();
} else {
    // If accessed directly without POST data
    error_log("handle-edit-announcement.php accessed directly without POST data.");
    header("Location: ../Views/Teachers/teachersDashboard.php"); // Redirect to a default page
    exit();
}

$conn->close();
?>
