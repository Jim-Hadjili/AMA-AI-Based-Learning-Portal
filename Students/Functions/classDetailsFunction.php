<?php
session_start();
include_once '../../../Assets/Auth/sessionCheck.php';
include_once '../../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Auth/login.php");
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_position = $_SESSION['user_position'];

// Get class ID from URL parameter
$class_id = $_GET['class_id'] ?? null;

if (!$class_id) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
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

// Fetch class details
$classDetails = null;
$classQuery = "SELECT tc.*, 
                      (SELECT COUNT(DISTINCT ce.st_id) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count,
                      (SELECT COUNT(q.quiz_id) FROM quizzes_tb q WHERE q.class_id = tc.class_id) AS total_quiz_count,
                      (SELECT COUNT(q.quiz_id) FROM quizzes_tb q WHERE q.class_id = tc.class_id AND q.status = 'published') AS published_quiz_count,
                      (SELECT COUNT(lm.material_id) FROM learning_materials_tb lm WHERE lm.class_id = tc.class_id) AS material_count,
                      (SELECT COUNT(a.announcement_id) FROM announcements_tb a WHERE a.class_id = tc.class_id) AS announcement_count
               FROM teacher_classes_tb tc 
               WHERE tc.class_id = ?";

$stmt = $conn->prepare($classQuery);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $classDetails = $result->fetch_assoc();
    $classDetails['class_subject'] = getSubjectFromClassName($classDetails['class_name']);
} else {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Check if user has access to this class
$hasAccess = false;
if ($user_position === 'teacher') {
    // Teachers can access classes they created
    $hasAccess = ($classDetails['th_id'] === $user_id);
} else {
    // Students can access classes they're enrolled in
    $enrollmentCheck = $conn->prepare("SELECT enrollment_id FROM class_enrollments_tb WHERE class_id = ? AND st_id = ? AND status = 'active'");
    $student_id = $_SESSION['st_id'] ?? null;
    if ($student_id) {
        $enrollmentCheck->bind_param("is", $class_id, $student_id);
        $enrollmentCheck->execute();
        $hasAccess = ($enrollmentCheck->get_result()->num_rows > 0);
    }
}

if (!$hasAccess) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Fetch recent quizzes (only published ones for students, all for teachers)
$recentQuizzes = [];
if ($user_position === 'teacher') {
    // Teachers can see all quizzes including drafts
    $quizQuery = "SELECT 
                      q.quiz_id, 
                      q.quiz_title, 
                      q.quiz_description, 
                      q.status, 
                      q.created_at, 
                      q.time_limit,
                      (SELECT COUNT(qq.question_id) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_questions,
                      (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_score
                  FROM quizzes_tb q 
                  WHERE q.class_id = ? 
                  ORDER BY q.created_at DESC 
                  LIMIT 5";
} else {
    // Students can only see published quizzes
    $quizQuery = "SELECT 
                      q.quiz_id, 
                      q.quiz_title, 
                      q.quiz_description, 
                      q.status, 
                      q.created_at, 
                      q.time_limit,
                      (SELECT COUNT(qq.question_id) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_questions,
                      (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_score
                  FROM quizzes_tb q 
                  WHERE q.class_id = ? AND q.status = 'published'
                  ORDER BY q.created_at DESC 
                  LIMIT 4";
}
$quizStmt = $conn->prepare($quizQuery);
$quizStmt->bind_param("i", $class_id);
$quizStmt->execute();
$quizResult = $quizStmt->get_result();
while ($quiz = $quizResult->fetch_assoc()) {
    // For students, fetch their latest attempt for this quiz
    if ($user_position === 'student') {
        $attemptStmt = $conn->prepare(
            "SELECT attempt_id, result, score FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? AND status = 'completed' ORDER BY attempt_id DESC LIMIT 1"
        );
        $attemptStmt->bind_param("is", $quiz['quiz_id'], $student_id);
        $attemptStmt->execute();
        $attemptRes = $attemptStmt->get_result();
        $attempt = $attemptRes->fetch_assoc();
        $quiz['student_attempt'] = $attempt ?: null;
    }
    $recentQuizzes[] = $quiz;
}

// Fetch recent announcements
$recentAnnouncements = [];
$announcementQuery = "SELECT announcement_id, title, content, created_at, is_pinned 
                      FROM announcements_tb 
                      WHERE class_id = ? 
                      ORDER BY is_pinned DESC, created_at DESC 
                      LIMIT 4";
$announcementStmt = $conn->prepare($announcementQuery);
$announcementStmt->bind_param("i", $class_id);
$announcementStmt->execute();
$announcementResult = $announcementStmt->get_result();
while ($announcement = $announcementResult->fetch_assoc()) {
    $recentAnnouncements[] = $announcement;
}

// Fetch recent learning materials
$recentMaterials = [];
$materialQuery = "SELECT material_id, material_title, material_description, file_name, file_type, upload_date 
                  FROM learning_materials_tb 
                  WHERE class_id = ? 
                  ORDER BY upload_date DESC 
                  LIMIT 6";
$materialStmt = $conn->prepare($materialQuery);
$materialStmt->bind_param("i", $class_id);
$materialStmt->execute();
$materialResult = $materialStmt->get_result();
while ($material = $materialResult->fetch_assoc()) {
    $recentMaterials[] = $material;
}

// Fetch enrolled students (for teachers)
$enrolledStudents = [];
if ($user_position === 'teacher') {
    $studentQuery = "SELECT sp.st_userName, sp.st_email, sp.grade_level, sp.strand, ce.enrollment_date 
                     FROM class_enrollments_tb ce 
                     JOIN students_profiles_tb sp ON ce.st_id = sp.st_id 
                     WHERE ce.class_id = ? AND ce.status = 'active' 
                     ORDER BY ce.enrollment_date DESC";
    $studentStmt = $conn->prepare($studentQuery);
    $studentStmt->bind_param("i", $class_id);
    $studentStmt->execute();
    $studentResult = $studentStmt->get_result();
    while ($student = $studentResult->fetch_assoc()) {
        $enrolledStudents[] = $student;
    }
}






?>
