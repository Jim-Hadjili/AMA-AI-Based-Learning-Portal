<?php
// This script creates the necessary upload directories

// Define the upload directory
$profilePictures = __DIR__ . '/Uploads/ProfilePictures/';

// Create directories if they don't exist
if (!file_exists($profilePictures)) {
    if (mkdir($profilePictures, 0777, true)) {
        echo "Successfully created directory: $profilePictures<br>";
    } else {
        echo "Failed to create directory: $profilePictures<br>";
        echo "Error: " . error_get_last()['message'] . "<br>";
    }
} else {
    echo "Directory already exists: $profilePictures<br>";
}

// Set directory permissions
if (file_exists($profilePictures)) {
    if (chmod($profilePictures, 0777)) {
        echo "Successfully set permissions for: $profilePictures<br>";
    } else {
        echo "Failed to set permissions for: $profilePictures<br>";
    }
}

echo "<p>Done. You can now <a href='/AMA-AI-Based-Learning-Portal/Students/Contents/Dashboard/studentDashboard.php'>return to the dashboard</a>.</p>";
?>