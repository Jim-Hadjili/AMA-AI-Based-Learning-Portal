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

// Fetch class details with basic counts first
$classDetails = null;
$classQuery = "SELECT tc.*, 
                      (SELECT COUNT(DISTINCT ce.st_id) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count,
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

// Now calculate the correct quiz counts
// 1. Get all non-AI quizzes (original quizzes)
$originalQuizQuery = "SELECT quiz_id FROM quizzes_tb WHERE class_id = ? AND quiz_type != '1'";
$originalQuizStmt = $conn->prepare($originalQuizQuery);
$originalQuizStmt->bind_param("i", $class_id);
$originalQuizStmt->execute();
$originalQuizResult = $originalQuizStmt->get_result();
$originalQuizCount = $originalQuizResult->num_rows;
$classDetails['total_quiz_count'] = $originalQuizCount;

// 2. Count published quizzes (originals + latest AI versions)
$publishedQuizCount = 0;

// First, get all published original quizzes
$publishedOriginalQuery = "SELECT quiz_id FROM quizzes_tb WHERE class_id = ? AND quiz_type != '1' AND status = 'published'";
$publishedOriginalStmt = $conn->prepare($publishedOriginalQuery);
$publishedOriginalStmt->bind_param("i", $class_id);
$publishedOriginalStmt->execute();
$publishedOriginalResult = $publishedOriginalStmt->get_result();
$publishedQuizCount = $publishedOriginalResult->num_rows;

// For each published quiz, check if it has AI-generated versions
// If it does, we only count 1 for each original quiz (whether we use the original or AI version)
$classDetails['published_quiz_count'] = $publishedQuizCount;

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

// Fetch recent quizzes (show AI-generated if exists, else original)
$recentQuizzes = [];
if ($user_position === 'teacher') {
    $quizQuery = "
        SELECT 
            q.quiz_id, 
            q.quiz_title, 
            q.quiz_description, 
            q.status, 
            q.created_at, 
            q.time_limit,
            q.quiz_type,
            (SELECT COUNT(qq.question_id) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_questions,
            (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_score
        FROM quizzes_tb q
        WHERE q.class_id = ?
        ORDER BY q.created_at DESC
        LIMIT 5
    ";
    $quizStmt = $conn->prepare($quizQuery);
    $quizStmt->bind_param("i", $class_id);
    $quizStmt->execute();
    $quizResult = $quizStmt->get_result();
    while ($quiz = $quizResult->fetch_assoc()) {
        $recentQuizzes[] = $quiz;
    }
} else {
    // For students, show only published quizzes, with personalized AI versions only for the student who generated them
    $recentQuizzes = [];
    if ($user_position !== 'teacher') {
        // Get all published, non-AI quizzes for this class
        $quizQuery = "
            SELECT 
                q.quiz_id, 
                q.quiz_title, 
                q.quiz_description, 
                q.status, 
                q.created_at, 
                q.time_limit,
                q.quiz_type,
                q.parent_quiz_id
            FROM quizzes_tb q
            WHERE q.class_id = ? AND q.status = 'published' AND q.quiz_type != '1'
            ORDER BY q.created_at DESC
            LIMIT 4
        ";
        $quizStmt = $conn->prepare($quizQuery);
        $quizStmt->bind_param("i", $class_id);
        $quizStmt->execute();
        $quizResult = $quizStmt->get_result();

        // Fetch quizzes this student has attempted
        $studentAttemptedQuizzesQuery = "
            SELECT DISTINCT quiz_id FROM quiz_attempts_tb 
            WHERE st_id = ? AND status = 'completed'
        ";
        $attemptedStmt = $conn->prepare($studentAttemptedQuizzesQuery);
        $attemptedStmt->bind_param("s", $student_id);
        $attemptedStmt->execute();
        $attemptedResult = $attemptedStmt->get_result();
        $attemptedQuizIds = [];
        while ($row = $attemptedResult->fetch_assoc()) {
            $attemptedQuizIds[] = $row['quiz_id'];
        }

        while ($quiz = $quizResult->fetch_assoc()) {
            $originalQuizId = $quiz['quiz_id'];
            $quizToShow = $quiz;

            // Find if there's a personalized AI version for this student
            $personalized = false;
            
            // First find all AI-generated versions of this quiz (direct children only)
            $aiVersionsQuery = "
                SELECT q.quiz_id FROM quizzes_tb q
                WHERE q.parent_quiz_id = ? AND q.quiz_type = '1'
                ORDER BY q.created_at DESC
            ";
            $aiVersionsStmt = $conn->prepare($aiVersionsQuery);
            $aiVersionsStmt->bind_param("i", $originalQuizId);
            $aiVersionsStmt->execute();
            $aiVersionsResult = $aiVersionsStmt->get_result();
            
            $aiVersionIds = [];
            while ($version = $aiVersionsResult->fetch_assoc()) {
                $aiVersionIds[] = $version['quiz_id'];
            }
            
            // Check the entire generation chain for this quiz
            $checkedIds = [$originalQuizId];
            $quizChainIds = $aiVersionIds;
            
            while (!empty($quizChainIds)) {
                $currentId = array_shift($quizChainIds);
                $checkedIds[] = $currentId;
                
                // Find further children
                $childrenQuery = "
                    SELECT quiz_id FROM quizzes_tb 
                    WHERE parent_quiz_id = ? AND quiz_type = '1'
                ";
                $childrenStmt = $conn->prepare($childrenQuery);
                $childrenStmt->bind_param("i", $currentId);
                $childrenStmt->execute();
                $childrenResult = $childrenStmt->get_result();
                
                while ($child = $childrenResult->fetch_assoc()) {
                    if (!in_array($child['quiz_id'], $checkedIds)) {
                        $quizChainIds[] = $child['quiz_id'];
                        $aiVersionIds[] = $child['quiz_id'];
                    }
                }
            }
            
            // Check if the student has attempted any AI version of this quiz
            $studentAiAttempts = array_intersect($aiVersionIds, $attemptedQuizIds);
            
            if (!empty($studentAiAttempts)) {
                // Student has attempted AI versions, show their latest AI version
                $latestAiQuery = "
                    SELECT q.* FROM quizzes_tb q
                    JOIN quiz_attempts_tb a ON q.quiz_id = a.quiz_id
                    WHERE q.quiz_id IN (" . implode(',', array_map('intval', $studentAiAttempts)) . ")
                    AND a.st_id = ?
                    ORDER BY q.created_at DESC
                    LIMIT 1
                ";
                $latestAiStmt = $conn->prepare($latestAiQuery);
                $latestAiStmt->bind_param("s", $student_id);
                $latestAiStmt->execute();
                $latestAiResult = $latestAiStmt->get_result();
                
                if ($latestAiResult->num_rows > 0) {
                    $quizToShow = $latestAiResult->fetch_assoc();
                    $personalized = true;
                }
            }

            // Add extra info (questions, score, student attempt)
            $quizToShow['total_questions'] = 0;
            $quizToShow['total_score'] = 0;
            $questionsStmt = $conn->prepare("SELECT COUNT(question_id), SUM(question_points) FROM quiz_questions_tb WHERE quiz_id = ?");
            $questionsStmt->bind_param("i", $quizToShow['quiz_id']);
            $questionsStmt->execute();
            $questionsStmt->bind_result($questionCount, $scoreSum);
            $questionsStmt->fetch();
            $quizToShow['total_questions'] = $questionCount ?: 0;
            $quizToShow['total_score'] = $scoreSum ?: 0;
            $questionsStmt->close();

            // Fetch student's latest attempt for this quiz
            $attemptStmt = $conn->prepare(
                "SELECT attempt_id, result, score FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? AND status = 'completed' ORDER BY attempt_id DESC LIMIT 1"
            );
            $attemptStmt->bind_param("is", $quizToShow['quiz_id'], $student_id);
            $attemptStmt->execute();
            $attemptRes = $attemptStmt->get_result();
            $attempt = $attemptRes->fetch_assoc();
            $quizToShow['student_attempt'] = $attempt ?: null;
            $quizToShow['is_personalized'] = $personalized;

            $recentQuizzes[] = $quizToShow;
        }
    }
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
