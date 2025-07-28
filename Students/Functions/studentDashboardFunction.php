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
                       (SELECT COUNT(q.quiz_id) FROM quizzes_tb q WHERE q.class_id = tc.class_id AND q.status = 'published') AS quiz_count
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
?>
