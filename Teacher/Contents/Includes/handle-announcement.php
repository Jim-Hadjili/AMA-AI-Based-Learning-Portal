<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// This script handles the submission of a new announcement.

// Corrected path to conn.php assuming handle-announcement.php is in 'Includes/'
// and 'Connection/' is a sibling directory at the project root.
include_once '../../../Connection/conn.php';

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Log received POST data for debugging
    error_log("Received POST data: " . print_r($_POST, true));
    echo "<pre>POST Data: "; print_r($_POST); echo "</pre>"; // Display for immediate debugging

    // Sanitize and retrieve form data
    $class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : 0;
    $teacher_id = $conn->real_escape_string($_POST['teacher_id'] ?? ''); // Get teacher_id from POST
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0; // Checkbox value

    // Validate input (basic validation)
    if (empty($title) || empty($content) || $class_id === 0 || empty($teacher_id)) {
        $errorMessage = "All fields (Title, Content, Class ID, Teacher ID) are required. Missing: ";
        if (empty($title)) $errorMessage .= "Title, ";
        if (empty($content)) $errorMessage .= "Content, ";
        if ($class_id === 0) $errorMessage .= "Class ID, ";
        if (empty($teacher_id)) $errorMessage .= "Teacher ID, ";
        $errorMessage = rtrim($errorMessage, ", "); // Remove trailing comma and space

        error_log("Validation Error: " . $errorMessage);
        echo "Validation Error: " . $errorMessage . "<br>"; // Display for immediate debugging
        // Temporarily remove header redirect to see errors
        // header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }

    // Prepare an SQL statement to insert the announcement into announcements_tb
    $sql = "INSERT INTO announcements_tb (class_id, teacher_id, title, content, is_pinned, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $errorMessage = "Database error: Could not prepare statement. Error: " . $conn->error;
        error_log($errorMessage);
        echo $errorMessage . "<br>"; // Display for immediate debugging
        // Temporarily remove header redirect to see errors
        // header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }

    // Bind parameters and execute the statement
    // 'isssi' corresponds to int, string, string, string, int (for class_id, teacher_id, title, content, is_pinned)
    $stmt->bind_param("isssi", $class_id, $teacher_id, $title, $content, $is_pinned);
    
    if ($stmt->execute()) {
        error_log("Announcement created successfully for class_id: " . $class_id);
        echo "Announcement created successfully!<br>"; // Display for immediate debugging
        // Re-enable this header redirect once debugging is complete
        header("Location: ../Tabs/classDetails.php?class_id=" . $class_id . "&status=success&message=Announcement created successfully!");
        exit();
    } else {
        $errorMessage = "Error creating announcement: " . $stmt->error;
        error_log($errorMessage);
        echo $errorMessage . "<br>"; // Display for immediate debugging
        // Temporarily remove header redirect to see errors
        // header("Location: ../Views/Teachers/classDetails.php?class_id=" . $class_id . "&status=error&message=" . urlencode($errorMessage));
        exit();
    }
    $stmt->close();
} else {
    // If accessed directly without POST data
    error_log("handle-announcement.php accessed directly without POST data.");
    echo "Access Denied: This script should only be accessed via POST.<br>"; // Display for immediate debugging
    header("Location: ../Views/Teachers/teachersDashboard.php"); // Redirect to a default page
    exit();
}

$conn->close();
?>
