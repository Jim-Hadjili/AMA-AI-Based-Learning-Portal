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
$new_password = $_POST['new_password'] ?? '';
$current_password = $_POST['current_password'] ?? '';

$updateFields = "th_userName=?, th_Email=?";
$params = [$name, $email];
$types = "ss";

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

// Update teachers_profiles_tb (no password update)
$stmt = $conn->prepare("UPDATE teachers_profiles_tb SET $updateFields WHERE th_id=?");
$stmt->bind_param($types, ...$params);
$teacherUpdated = $stmt->execute();

// Update users_tb (with password if changed)
$stmt2 = $conn->prepare("UPDATE users_tb SET $userUpdateFields WHERE user_id=?");
$stmt2->bind_param($userTypes, ...$userParams);
$userUpdated = $stmt2->execute();

if ($teacherUpdated && $userUpdated) {
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    header('Location: ../Contents/Dashboard/teachersDashboard.php?success=profile_updated');
} else {
    header('Location: ../Contents/Dashboard/teachersDashboard.php?error=update_failed');
}
exit;
?>