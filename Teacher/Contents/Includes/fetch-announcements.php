<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
// Adjust path as necessary based on your project structure
// Assuming this file is in 'Includes/' and 'Connection/conn.php' is at the project root
include_once  '../../../Connection/conn.php';

echo "<!-- Debug: fetch-announcements.php loaded -->\n";

$announcements = []; // Initialize an empty array for announcements

// Ensure class_id is available, typically from a GET parameter or session
// For this example, we assume class_id is passed via GET
if (isset($_GET['class_id'])) {
    $class_id = intval($_GET['class_id']);
    echo "<!-- Debug: class_id received: " . htmlspecialchars($class_id) . " -->\n";

    if ($class_id > 0) {
        // Prepare and execute the SQL query to fetch announcements
        $sql = "SELECT announcement_id, title, content, created_at, is_pinned FROM announcements_tb WHERE class_id = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "<!-- Debug: Database error preparing statement: " . htmlspecialchars($conn->error) . " -->\n";
            error_log("Database error: Could not prepare statement for fetching announcements. Error: " . $conn->error);
        } else {
            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<!-- Debug: Found " . $result->num_rows . " announcements. -->\n";
                while ($row = $result->fetch_assoc()) {
                    $announcements[] = $row;
                }
            } else {
                echo "<!-- Debug: No announcements found for class_id: " . htmlspecialchars($class_id) . " -->\n";
            }
            $stmt->close();
        }
    } else {
        echo "<!-- Debug: Invalid class_id (0 or less) received. -->\n";
        error_log("Invalid class_id received for fetching announcements.");
    }
} else {
    echo "<!-- Debug: No class_id provided in GET parameters. -->\n";
    error_log("No class_id provided for fetching announcements.");
}

// The $announcements array is now populated and will be available to included files.
?>
