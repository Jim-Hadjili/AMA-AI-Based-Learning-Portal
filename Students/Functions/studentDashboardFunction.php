<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a student
checkUserAccess('student');

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$session_token = $_SESSION['session_token']; // Get the session token

// Get student ID from database and store it in session
$studentId = null;
$query = "SELECT st_id FROM students_profiles_tb WHERE st_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $studentId = $row['st_id'];
    $_SESSION['st_id'] = $studentId; // Store st_id in session
}

// Helper function to determine subject from class name
function getSubjectFromClassName($className) {
    $classNameLower = strtolower($className);
    $subjectKeywords = [
        'english' => 'English',
        'math' => 'Math',
        'science' => 'Science',
        'history' => 'History',
        'arts' => 'Arts',
        'pe' => 'PE',
        'ict' => 'ICT',
        'home economics' => 'Home Economics',
    ];

    foreach ($subjectKeywords as $keyword => $subject) {
        if (strpos($classNameLower, $keyword) !== false) {
            return $subject;
        }
    }
    return 'Default';
}

// Get enrolled classes with student and quiz counts
$enrolledClasses = [];
$enrolledCount = 0;

if ($studentId) {
    // Get classes the student is enrolled in, along with student and quiz counts
    $classQuery = "SELECT
                       tc.*,
                       (SELECT COUNT(DISTINCT ce.st_id) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count,
                       (SELECT COUNT(q.quiz_id) FROM quizzes_tb q WHERE q.class_id = tc.class_id AND q.status = 'published' AND q.quiz_type != '1') AS quiz_count
                   FROM teacher_classes_tb tc
                   INNER JOIN class_enrollments_tb ce_main ON tc.class_id = ce_main.class_id
                   WHERE ce_main.st_id = ? AND tc.status = 'active'
                   ORDER BY tc.created_at DESC";
    $classStmt = $conn->prepare($classQuery);
    $classStmt->bind_param("s", $studentId);
    $classStmt->execute();
    $classResult = $classStmt->get_result();

    while ($class = $classResult->fetch_assoc()) {
        // Add the derived class_subject to the class array
        $class['class_subject'] = getSubjectFromClassName($class['class_name']);
        $enrolledClasses[] = $class;
    }
    $enrolledCount = count($enrolledClasses);
}

// After fetching the enrolled classes, update the quiz counts to include only the latest AI versions
if ($studentId) {
    // Fetch classes first
    $classQuery = "SELECT
                      tc.*,
                      (SELECT COUNT(DISTINCT ce.st_id) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count
                   FROM teacher_classes_tb tc
                   INNER JOIN class_enrollments_tb ce_main ON tc.class_id = ce_main.class_id
                   WHERE ce_main.st_id = ? AND tc.status = 'active'
                   ORDER BY tc.created_at DESC";
    $classStmt = $conn->prepare($classQuery);
    $classStmt->bind_param("s", $studentId);
    $classStmt->execute();
    $classResult = $classStmt->get_result();
    
    while ($class = $classResult->fetch_assoc()) {
        // Add the derived class_subject to the class array
        $class['class_subject'] = getSubjectFromClassName($class['class_name']);
        
        // Now calculate accurate quiz count for this class
        $class_id = $class['class_id'];
        
        // Get all original quizzes for this class
        $baseQuizQuery = "SELECT quiz_id FROM quizzes_tb 
                          WHERE class_id = ? AND status = 'published' AND quiz_type != '1'";
        $baseQuizStmt = $conn->prepare($baseQuizQuery);
        $baseQuizStmt->bind_param("i", $class_id);
        $baseQuizStmt->execute();
        $baseQuizResult = $baseQuizStmt->get_result();
        
        $quizCount = 0;
        while ($baseQuiz = $baseQuizResult->fetch_assoc()) {
            $quizCount++; // Count this original quiz
        }
        
        $class['quiz_count'] = $quizCount;
        $enrolledClasses[] = $class;
    }
    $enrolledCount = count($enrolledClasses);
}

$totalPublishedQuizzes = 0;
$totalMaterials = 0;
$totalAnnouncements = 0;

if ($studentId) {
    // Get all enrolled class IDs
    $classIds = [];
    foreach ($enrolledClasses as $class) {
        $classIds[] = $class['class_id'];
    }

    if (!empty($classIds)) {
        $classIdsStr = implode(',', array_map('intval', $classIds));

        // Total Published Quizzes
        $quizQuery = "SELECT COUNT(*) AS total FROM quizzes_tb WHERE class_id IN ($classIdsStr) AND status = 'published'";
        $quizResult = $conn->query($quizQuery);
        $totalPublishedQuizzes = $quizResult->fetch_assoc()['total'] ?? 0;

        // Total Materials
        $materialQuery = "SELECT COUNT(*) AS total FROM learning_materials_tb WHERE class_id IN ($classIdsStr)";
        $materialResult = $conn->query($materialQuery);
        $totalMaterials = $materialResult->fetch_assoc()['total'] ?? 0;

        // Total Announcements
        $announcementQuery = "SELECT COUNT(*) AS total FROM announcements_tb WHERE class_id IN ($classIdsStr)";
        $announcementResult = $conn->query($announcementQuery);
        $totalAnnouncements = $announcementResult->fetch_assoc()['total'] ?? 0;
    }
}

$recentQuizzes = [];
$recentMaterials = [];
$recentAnnouncements = [];

if (!empty($classIds)) {
    // Recent Quizzes (limit 5)
    $quizQuery = "SELECT q.quiz_id, q.quiz_title, q.class_id, q.created_at, tc.class_name
                  FROM quizzes_tb q
                  JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
                  WHERE q.class_id IN ($classIdsStr) AND q.status = 'published'
                  ORDER BY q.created_at DESC
                  LIMIT 5";
    $quizResult = $conn->query($quizQuery);
    while ($quiz = $quizResult->fetch_assoc()) {
        $recentQuizzes[] = $quiz;
    }

    // Recent Materials (limit 5)
    $materialQuery = "SELECT lm.material_id, lm.material_title, lm.class_id, lm.upload_date, tc.class_name
                      FROM learning_materials_tb lm
                      JOIN teacher_classes_tb tc ON lm.class_id = tc.class_id
                      WHERE lm.class_id IN ($classIdsStr)
                      ORDER BY lm.upload_date DESC
                      LIMIT 5";
    $materialResult = $conn->query($materialQuery);
    while ($material = $materialResult->fetch_assoc()) {
        $recentMaterials[] = $material;
    }

    // Latest Announcements (limit 5)
    $announcementQuery = "SELECT a.announcement_id, a.title, a.class_id, a.created_at, tc.class_name
                          FROM announcements_tb a
                          JOIN teacher_classes_tb tc ON a.class_id = tc.class_id
                          WHERE a.class_id IN ($classIdsStr)
                          ORDER BY a.created_at DESC
                          LIMIT 5";
    $announcementResult = $conn->query($announcementQuery);
    while ($announcement = $announcementResult->fetch_assoc()) {
        $recentAnnouncements[] = $announcement;
    }
}

$passedQuizAttempts = [];
if (!empty($classIds)) {
    $studentId = $_SESSION['st_id'] ?? null;
    $quizAttemptsQuery = "
        SELECT
            qa.quiz_id,
            q.class_id,
            MAX(qa.score) AS score,
            qa.result,
            MAX(qa.end_time) AS end_time,
            MAX(qa.attempt_id) AS attempt_id,
            q.quiz_title,
            tc.class_name,
            (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_points
        FROM quiz_attempts_tb qa
        JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
        JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
        WHERE qa.st_id = ? AND q.class_id IN ($classIdsStr) AND qa.result = 'passed'
        GROUP BY qa.quiz_id, q.class_id, qa.result, q.quiz_title, tc.class_name
        ORDER BY attempt_id DESC
        LIMIT 5
    ";
    $stmt = $conn->prepare($quizAttemptsQuery);
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $passedQuizAttempts[] = $row;
    }
}

// Replace your current Recent Quizzes query with this:
$recentQuizzes = [];
if (!empty($classIds)) {
    // Get base quizzes first
    $baseQuizQuery = "SELECT q.quiz_id, q.quiz_title, q.class_id, q.created_at, tc.class_name, q.quiz_type
                  FROM quizzes_tb q
                  JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
                  WHERE q.class_id IN ($classIdsStr) AND q.status = 'published' AND q.quiz_type != '1'
                  ORDER BY q.created_at DESC
                  LIMIT 10"; // Fetch more than needed to account for duplicates
    $baseQuizResult = $conn->query($baseQuizQuery);
    $baseQuizzes = [];
    while ($quiz = $baseQuizResult->fetch_assoc()) {
        $baseQuizzes[] = $quiz;
    }

    // For each base quiz, find its most recent AI-generated version if it exists
    foreach ($baseQuizzes as $baseQuiz) {
        $latestQuiz = $baseQuiz;
        
        // Traverse AI-generated chain to get the latest version
        $currentQuizId = $baseQuiz['quiz_id'];
        while (true) {
            $aiQuery = "
                SELECT q.*, tc.class_name 
                FROM quizzes_tb q
                JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
                WHERE q.parent_quiz_id = ? AND q.quiz_type = '1' AND q.status = 'published'
                ORDER BY q.created_at DESC LIMIT 1
            ";
            $aiStmt = $conn->prepare($aiQuery);
            $aiStmt->bind_param("i", $currentQuizId);
            $aiStmt->execute();
            $aiResult = $aiStmt->get_result();
            $aiQuiz = $aiResult->fetch_assoc();

            if ($aiQuiz) {
                $latestQuiz = $aiQuiz;
                $currentQuizId = $aiQuiz['quiz_id'];
            } else {
                break;
            }
        }
        
        $recentQuizzes[] = $latestQuiz;
    }
    
    // Sort the final list of quizzes by created_at in descending order (newest first)
    usort($recentQuizzes, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    // Limit to 5 quizzes after sorting
    $recentQuizzes = array_slice($recentQuizzes, 0, 5);
}
?>
