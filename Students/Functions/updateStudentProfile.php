<?php
session_start();
include_once '../../Connection/conn.php';

$st_id = $_SESSION['st_id'] ?? null;
if (!$st_id) {
    header('Location: ../Dashboard/studentDashboard.php?error=not_logged_in');
    exit;
}

$name = $_POST['st_userName'];
$email = $_POST['st_email'];
$grade_level = $_POST['grade_level'];
$strand = $_POST['strand'];
$new_password = $_POST['new_password'] ?? '';
$current_password = $_POST['current_password'] ?? '';

$updateFields = "st_userName=?, st_email=?, grade_level=?, strand=?";
$params = [$name, $email, $grade_level, $strand];
$types = "ssss";

$userUpdateFields = "userName=?, userEmail=?";
$userParams = [$name, $email];
$userTypes = "ss";

// Handle profile picture upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
    // Define the upload directory with proper path
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Get file info
    $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
    
    // Validate file extension
    if (in_array($file_ext, $allowed_exts)) {
        // Generate unique filename
        $new_filename = uniqid($st_id . '_') . '.' . $file_ext;
        $upload_path = $upload_dir . $new_filename;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
            // Delete old profile picture if exists
            if (!empty($_SESSION['profile_picture']) && file_exists($upload_dir . $_SESSION['profile_picture'])) {
                unlink($upload_dir . $_SESSION['profile_picture']);
            }
            
            // Add to update query
            $updateFields .= ", profile_picture=?";
            $params[] = $new_filename;
            $types .= "s";
            
            // Update session
            $_SESSION['profile_picture'] = $new_filename;
        } else {
            // Log upload error for debugging
            error_log("Failed to move uploaded file to $upload_path");
        }
    } else {
        // Log invalid file type
        error_log("Invalid file type: $file_ext");
    }
}

// Password handling
if (!empty($new_password)) {
    // Fetch current hashed password from DB
    $stmtCheck = $conn->prepare("SELECT st_studentdPassword FROM students_profiles_tb WHERE st_id=?");
    $stmtCheck->bind_param("s", $st_id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($currentHashed);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if (!$current_password || !password_verify($current_password, $currentHashed)) {
        header('Location: ../Contents/Dashboard/studentDashboard.php?error=invalid_current_password');
        exit;
    }

    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $updateFields .= ", st_studentdPassword=?";
    $params[] = $hashed;
    $types .= "s";

    $userUpdateFields .= ", userPassword=?";
    $userParams[] = $hashed;
    $userTypes .= "s";
}

$params[] = $st_id;
$types .= "s";

$userParams[] = $st_id;
$userTypes .= "s";

// Update students_profiles_tb
$stmt = $conn->prepare("UPDATE students_profiles_tb SET $updateFields WHERE st_id=?");
$stmt->bind_param($types, ...$params);
$studentUpdated = $stmt->execute();

// Update users_tb
$stmt2 = $conn->prepare("UPDATE users_tb SET $userUpdateFields WHERE user_id=?");
$stmt2->bind_param($userTypes, ...$userParams);
$userUpdated = $stmt2->execute();

if ($studentUpdated && $userUpdated) {
    // Update session variables so changes reflect immediately
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['grade_level'] = $grade_level;
    $_SESSION['strand'] = $strand;
    
    // Set a timestamp for the profile update to help with cache busting
    $_SESSION['profile_updated_at'] = time();
    
    // Redirect with success message and a cache-busting parameter
    header('Location: ../Contents/Dashboard/studentDashboard.php?success=profile_updated&t=' . time());
} else {
    header('Location: ../Contents/Dashboard/studentDashboard.php?error=update_failed');
}
exit;
?>