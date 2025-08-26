<?php
include_once '../../../Connection/conn.php';

// Only show if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    echo '<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"><h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3><div class="text-center py-12"><i class="fas fa-clock text-gray-300 text-4xl mb-4"></i><p class="text-gray-500 mb-2">No recent activity to display</p></div></div>';
    return;
}

// Function to generate an SVG avatar with initials
function generateInitialsAvatar($name, $size = 200)
{
    // Get initials (first letter of first and last name)
    $nameParts = explode(' ', $name);
    $initials = '';

    if (count($nameParts) >= 2) {
        // First letter of first name and first letter of last name
        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
    } else {
        // Just use the first letter if there's only one name part
        $initials = strtoupper(substr($name, 0, 1));
    }

    // Generate a consistent color based on the name
    $hash = md5($name);
    $hue = hexdec(substr($hash, 0, 2)) % 360; // 0-359 hue value
    $saturation = 65; // Fixed saturation
    $lightness = 50; // Fixed lightness

    // Convert HSL to RGB for the fill color
    $c = (1 - abs(2 * $lightness / 100 - 1)) * $saturation / 100;
    $x = $c * (1 - abs(fmod($hue / 60, 2) - 1));
    $m = $lightness / 100 - $c / 2;

    if ($hue < 60) {
        $r = $c;
        $g = $x;
        $b = 0;
    } else if ($hue < 120) {
        $r = $x;
        $g = $c;
        $b = 0;
    } else if ($hue < 180) {
        $r = 0;
        $g = $c;
        $b = $x;
    } else if ($hue < 240) {
        $r = 0;
        $g = $x;
        $b = $c;
    } else if ($hue < 300) {
        $r = $x;
        $g = 0;
        $b = $c;
    } else {
        $r = $c;
        $g = 0;
        $b = $x;
    }

    $r = round(($r + $m) * 255);
    $g = round(($g + $m) * 255);
    $b = round(($b + $m) * 255);

    $bgColor = sprintf('#%02x%02x%02x', $r, $g, $b);

    // Create SVG data URL
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $size . ' ' . $size . '">';
    $svg .= '<rect width="100%" height="100%" fill="' . $bgColor . '"/>';
    $svg .= '<text x="50%" y="50%" dy=".1em" fill="white" font-family="Arial, sans-serif" font-size="' . ($size / 2) . '" font-weight="bold" text-anchor="middle" dominant-baseline="middle">' . $initials . '</text>';
    $svg .= '</svg>';

    // Convert to data URL
    return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
}

$teacher_id = $_SESSION['user_id'];

// Get all class IDs for this teacher
$classStmt = $conn->prepare("SELECT class_id, class_name FROM teacher_classes_tb WHERE th_id = ?");
$classStmt->bind_param("s", $teacher_id);
$classStmt->execute();
$classRes = $classStmt->get_result();

$classIds = [];
$classNames = [];
while ($row = $classRes->fetch_assoc()) {
    $classIds[] = $row['class_id'];
    $classNames[$row['class_id']] = $row['class_name'];
}

if (empty($classIds)) {
    return;
}

$classIdsStr = implode(',', array_map('intval', $classIds));

// Recent student enrollments
$enrollSql = "SELECT ce.enrollment_id, ce.enrollment_date AS activity_time, ce.student_name, 
              ce.st_id, ce.grade_level, ce.strand, ce.student_id, ce.class_id, 'enrollment' AS type,
              sp.profile_picture
              FROM class_enrollments_tb ce
              LEFT JOIN students_profiles_tb sp ON ce.st_id = sp.st_id
              WHERE ce.class_id IN ($classIdsStr) 
              ORDER BY ce.enrollment_date DESC LIMIT 10";
$enrollments = $conn->query($enrollSql);

// Recent quiz submissions - Get only ORIGINAL quiz attempts (not AI-generated)
// and only the first attempt per student-quiz combination
// REMOVED passing_score from the query since it doesn't exist in the table
$quizSql = "SELECT qa.end_time AS activity_time, qa.student_name, qa.quiz_id, qa.attempt_id, qa.st_id, qa.score,
            q.class_id, q.quiz_title, 'quiz_submission' AS type, sp.profile_picture
            FROM quiz_attempts_tb qa
            JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
            LEFT JOIN students_profiles_tb sp ON qa.st_id = sp.st_id
            JOIN (
                SELECT MIN(qa.attempt_id) as first_attempt_id
                FROM quiz_attempts_tb qa
                JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
                WHERE q.quiz_type = 'manual'
                GROUP BY qa.st_id, qa.quiz_id
            ) first_attempts ON qa.attempt_id = first_attempts.first_attempt_id
            WHERE q.class_id IN ($classIdsStr) 
            AND qa.status = 'completed'
            AND q.quiz_type = 'manual'
            ORDER BY qa.end_time DESC LIMIT 10";

// Alternative approach if the subquery approach doesn't work with your MySQL version
$altQuizSql = "SELECT qa.end_time AS activity_time, qa.student_name, qa.quiz_id, qa.attempt_id, qa.st_id, qa.score,
            q.class_id, q.quiz_title, 'quiz_submission' AS type, sp.profile_picture
            FROM quiz_attempts_tb qa
            JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
            LEFT JOIN students_profiles_tb sp ON qa.st_id = sp.st_id
            WHERE q.class_id IN ($classIdsStr) 
            AND qa.status = 'completed'
            AND q.quiz_type = 'manual'
            ORDER BY qa.st_id, qa.quiz_id, qa.end_time ASC"; // Grouped and ordered to find first attempts

$quizSubmissions = $conn->query($quizSql);
if (!$quizSubmissions) {
    // Try the alternative approach if the first query fails
    $quizSubmissions = $conn->query($altQuizSql);

    if (!$quizSubmissions) {
        // Log the error for debugging
        error_log("Error in quiz submissions query: " . $conn->error);
        $quizSubmissions = []; // Set empty result to avoid errors
    }
}

// Merge all activities
$activities = [];

// Default profile picture path (fallback if SVG generation fails)
$defaultProfilePic = '../../../Assets/Images/defaultProfile.png';

// Enrollments
if ($enrollments && $enrollments->num_rows > 0) {
    while ($row = $enrollments->fetch_assoc()) {
        if (isset($classNames[$row['class_id']])) {
            // Generate avatar if no profile picture
            if (empty($row['profile_picture'])) {
                $profilePic = generateInitialsAvatar($row['student_name']);
            } else {
                $profilePic = '../../../Uploads/ProfilePictures/' . $row['profile_picture'];
            }

            $activities[] = [
                'time' => $row['activity_time'],
                'type' => $row['type'],
                'class_id' => $row['class_id'],
                'class_name' => $classNames[$row['class_id']],
                'desc' => "<b>{$row['student_name']}</b> enrolled in <b>{$classNames[$row['class_id']]}</b>",
                'student_name' => $row['student_name'],
                'student_id' => $row['st_id'],
                'enrollment_id' => $row['enrollment_id'],
                'grade_level' => $row['grade_level'] ?? 'Not specified',
                'strand' => $row['strand'] ?? 'Not specified',
                'student_number' => $row['student_id'] ?? 'Not specified',
                'profile_picture' => $profilePic,
                'has_custom_profile' => !empty($row['profile_picture'])
            ];
        }
    }
}

// Quiz submissions - track the first attempt per student-quiz combination
if ($quizSubmissions && $quizSubmissions instanceof mysqli_result && $quizSubmissions->num_rows > 0) {
    // For the alternative approach, track which student-quiz combos we've seen
    $processedStudentQuizzes = [];

    while ($row = $quizSubmissions->fetch_assoc()) {
        // Create a unique key for this student-quiz combination
        $studentQuizKey = $row['st_id'] . '-' . $row['quiz_id'];

        // If using the alternative approach, skip if we've already seen this student-quiz combo
        if (isset($processedStudentQuizzes[$studentQuizKey])) {
            continue;
        }

        // Mark this student-quiz combo as processed
        $processedStudentQuizzes[$studentQuizKey] = true;

        // Get quiz title and verify it's not AI-generated
        $quizTitle = $row['quiz_title'] ?? '';
        $originalQuizId = $row['quiz_id']; // Store the original quiz ID

        if (empty($quizTitle)) {
            $quizStmt = $conn->prepare("SELECT quiz_title, quiz_type FROM quizzes_tb WHERE quiz_id = ?");
            $quizStmt->bind_param("i", $row['quiz_id']);
            $quizStmt->execute();
            $quizRes = $quizStmt->get_result();
            if ($quizRow = $quizRes->fetch_assoc()) {
                // Skip AI-generated quizzes
                if (isset($quizRow['quiz_type']) && $quizRow['quiz_type'] != 'manual') {
                    continue;
                }
                $quizTitle = $quizRow['quiz_title'];
            }
        }

        // Get total attempts for this student and quiz (including AI-generated attempts)
        $totalAttemptsStmt = $conn->prepare("
            SELECT COUNT(*) as total_attempts 
            FROM quiz_attempts_tb qa
            JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
            WHERE qa.st_id = ? AND (
                qa.quiz_id = ? OR 
                q.parent_quiz_id = ? OR 
                q.quiz_id IN (SELECT quiz_id FROM quizzes_tb WHERE parent_quiz_id = ?)
            )
        ");
        $totalAttemptsStmt->bind_param("siii", $row['st_id'], $row['quiz_id'], $row['quiz_id'], $row['quiz_id']);
        $totalAttemptsStmt->execute();
        $totalAttemptsRes = $totalAttemptsStmt->get_result();
        $totalAttemptsRow = $totalAttemptsRes->fetch_assoc();
        $totalAttempts = $totalAttemptsRow['total_attempts'] ?? 1;

        // Get the most recent AI-generated attempt for this student and related quizzes
        $latestAttemptStmt = $conn->prepare("
            SELECT qa.*, q.quiz_title, q.quiz_type
            FROM quiz_attempts_tb qa
            JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
            WHERE qa.st_id = ? AND (
                qa.quiz_id = ? OR 
                q.parent_quiz_id = ? OR 
                q.quiz_id IN (SELECT quiz_id FROM quizzes_tb WHERE parent_quiz_id = ?)
            )
            AND qa.status = 'completed'
            ORDER BY 
                CASE WHEN q.quiz_type != 'manual' THEN 0 ELSE 1 END, -- Prioritize AI-generated quizzes
                qa.end_time DESC
            LIMIT 1
        ");
        $latestAttemptStmt->bind_param("siii", $row['st_id'], $row['quiz_id'], $row['quiz_id'], $row['quiz_id']);
        $latestAttemptStmt->execute();
        $latestAttemptRes = $latestAttemptStmt->get_result();

        // Default to the original attempt if no AI-generated attempt is found
        $latestAttemptId = $row['attempt_id'];
        $latestScore = $row['score'] ?? 0;
        $latestQuizId = $row['quiz_id'];
        $latestQuizTitle = $quizTitle;
        $latestQuizType = 'manual';
        $latestEndTime = $row['activity_time'];

        if ($latestAttemptRow = $latestAttemptRes->fetch_assoc()) {
            $latestAttemptId = $latestAttemptRow['attempt_id'];
            $latestScore = $latestAttemptRow['score'] ?? 0;
            $latestQuizId = $latestAttemptRow['quiz_id'];
            $latestQuizTitle = $latestAttemptRow['quiz_title'];
            $latestQuizType = $latestAttemptRow['quiz_type'];
            $latestEndTime = $latestAttemptRow['end_time'];
        }

        // Generate avatar if no profile picture
        if (empty($row['profile_picture'])) {
            $profilePic = generateInitialsAvatar($row['student_name']);
        } else {
            $profilePic = '../../../Uploads/ProfilePictures/' . $row['profile_picture'];
        }

        if (isset($classNames[$row['class_id']])) {
            $activities[] = [
                'time' => $row['activity_time'],  // Original first attempt time for the feed
                'type' => $row['type'],
                'class_id' => $row['class_id'],
                'class_name' => $classNames[$row['class_id']],
                'desc' => "<b>{$row['student_name']}</b> attempted quiz <b>{$quizTitle}</b> in <b>{$classNames[$row['class_id']]}</b>",
                'student_name' => $row['student_name'],
                'student_id' => $row['st_id'],
                'quiz_id' => $row['quiz_id'],  // Original quiz ID
                'quiz_title' => $quizTitle,    // Original quiz title
                'attempt_id' => $row['attempt_id'],  // Original attempt ID
                'total_attempts' => $totalAttempts,
                'profile_picture' => $profilePic,
                'has_custom_profile' => !empty($row['profile_picture']),
                // Latest attempt info (may be AI-generated)
                'latest_attempt_id' => $latestAttemptId,
                'latest_score' => $latestScore,
                'latest_quiz_id' => $latestQuizId,
                'latest_quiz_title' => $latestQuizTitle,
                'latest_quiz_type' => $latestQuizType,
                'latest_time' => $latestEndTime,
                'original_quiz_id' => $originalQuizId,
                'original_quiz_title' => $quizTitle
            ];
        }
    }
}

// Sort all activities by time DESC (newest first)
usort($activities, function ($a, $b) {
    return strtotime($b['time']) - strtotime($a['time']);
});

// Limit to most recent 15
$activities = array_slice($activities, 0, 15);
