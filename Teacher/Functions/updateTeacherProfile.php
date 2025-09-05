<?php
session_start();
include_once '../../Connection/conn.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: ../Dashboard/teachersDashboard.php?error=not_logged_in');
    exit;
}

// Use user_id from session as th_id
$th_id = $user_id;

$name = $_POST['teacher_name'];
$email = $_POST['teacher_email'];
$employee_id = $_POST['employee_id'] ?? '';
$department = $_POST['department'] ?? '';
$subject_expertise = $_POST['subject_expertise'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$current_password = $_POST['current_password'] ?? '';

// Add new fields to update
$updateFields = "th_userName=?, th_Email=?, employee_id=?, department=?, subject_expertise=?";
$params = [$name, $email, $employee_id, $department, $subject_expertise];
$types = "sssss";

$userUpdateFields = "userName=?, userEmail=?";
$userParams = [$name, $email];
$userTypes = "ss";

// If password change is requested
if (!empty($new_password)) {
    // Fetch current hashed password from users_tb
    $stmtCheck = $conn->prepare("SELECT userPassword FROM users_tb WHERE user_id=?");
    $stmtCheck->bind_param("s", $user_id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($currentHashed);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if (!$currentHashed) {
        error_log("No password hash found for user_id: $user_id");
        header('Location: ../Contents/Dashboard/teachersDashboard.php?error=no_password_found');
        exit;
    }

    if (!$current_password || !password_verify($current_password, $currentHashed)) {
        error_log("Password verify failed. Input: $current_password, Hash: $currentHashed");
        header('Location: ../Contents/Dashboard/teachersDashboard.php?error=invalid_current_password');
        exit;
    }

    $hashed = password_hash($new_password, PASSWORD_DEFAULT);

    // Only update password in users_tb
    $userUpdateFields .= ", userPassword=?";
    $userParams[] = $hashed;
    $userTypes .= "s";
}

$params[] = $th_id;
$types .= "s";

$userParams[] = $user_id;
$userTypes .= "s";

// Update teachers_profiles_tb (with new fields)
$stmt = $conn->prepare("UPDATE teachers_profiles_tb SET $updateFields WHERE th_id=?");
$stmt->bind_param($types, ...$params);
$teacherUpdated = $stmt->execute();

// Update users_tb (with password if changed)
$stmt2 = $conn->prepare("UPDATE users_tb SET $userUpdateFields WHERE user_id=?");
$stmt2->bind_param($userTypes, ...$userParams);
$userUpdated = $stmt2->execute();

// Handle profile picture upload
$profilePicName = null;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $fileTmp = $_FILES['profile_picture']['tmp_name'];
    $fileType = mime_content_type($fileTmp);
    $fileSize = $_FILES['profile_picture']['size'];

    if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $profilePicName = $_SESSION['user_id'] . '_' . uniqid() . '.' . $ext;
        $destPath = '../../Uploads/ProfilePictures/' . $profilePicName;
        move_uploaded_file($fileTmp, $destPath);

        // Update profile picture in teachers_profiles_tb
        $updatePicQuery = "UPDATE teachers_profiles_tb SET profile_picture = ? WHERE th_Email = ?";
        $updatePicStmt = $conn->prepare($updatePicQuery);
        $updatePicStmt->bind_param("ss", $profilePicName, $_SESSION['user_email']);
        $updatePicStmt->execute();

        // Update profile picture in users_tb
        $updateUserPicQuery = "UPDATE users_tb SET profile_picture = ? WHERE user_id = ?";
        $updateUserPicStmt = $conn->prepare($updateUserPicQuery);
        $updateUserPicStmt->bind_param("ss", $profilePicName, $_SESSION['user_id']);
        $updateUserPicStmt->execute();

        // Also update session variable
        $_SESSION['profile_picture'] = $profilePicName;
    }
}

if ($teacherUpdated && $userUpdated) {
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    header('Location: ../Contents/Dashboard/teachersDashboard.php?success=profile_updated');
} else {
    header('Location: ../Contents/Dashboard/teachersDashboard.php?error=update_failed');
}
exit;
?>