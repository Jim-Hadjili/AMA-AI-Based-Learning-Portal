<?php
session_start();
include_once '../../Connection/conn.php';
include_once '../Functions/quizHelpers.php'; // Include the helper functions

// Check if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "Invalid request. Quiz ID is required.";
    exit;
}

// Fetch quiz info (minimal query just to verify teacher owns this quiz)
$quizStmt = $conn->prepare("
    SELECT q.quiz_id, q.class_id, q.quiz_title
    FROM quizzes_tb q
    WHERE q.quiz_id = ? AND q.th_id = ?
");
$quizStmt->bind_param("is", $quiz_id, $teacher_id);
$quizStmt->execute();
$quizResult = $quizStmt->get_result();

if ($quizResult->num_rows === 0) {
    echo "Quiz not found or you don't have permission to view it.";
    exit;
}

$quiz = $quizResult->fetch_assoc();
$class_id = $quiz['class_id'];

// Fetch class info for breadcrumb
$classStmt = $conn->prepare("SELECT class_name FROM teacher_classes_tb WHERE class_id = ?");
$classStmt->bind_param("i", $class_id);
$classStmt->execute();
$classRes = $classStmt->get_result();
$classInfo = $classRes->fetch_assoc();

// Add class_name to $quiz for breadcrumb
$quiz['class_name'] = $classInfo['class_name'];

// Get all related quiz IDs (original + AI regenerated versions)
function getAllRelatedQuizIds($conn, $quiz_id) {
    $ids = [$quiz_id];
    $queue = [$quiz_id];
    
    while (!empty($queue)) {
        $current = array_shift($queue);
        $stmt = $conn->prepare("SELECT quiz_id FROM quizzes_tb WHERE parent_quiz_id = ?");
        $stmt->bind_param("i", $current);
        $stmt->execute();
        $res = $stmt->get_result();
        
        while ($row = $res->fetch_assoc()) {
            $ids[] = $row['quiz_id'];
            $queue[] = $row['quiz_id'];
        }
    }
    
    return $ids;
}

// Find the original quiz (root of the chain)
function getRootQuizId($conn, $quiz_id) {
    $current = $quiz_id;
    
    while (true) {
        $stmt = $conn->prepare("SELECT parent_quiz_id FROM quizzes_tb WHERE quiz_id = ?");
        $stmt->bind_param("i", $current);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($row = $res->fetch_assoc()) {
            if ($row['parent_quiz_id']) {
                $current = $row['parent_quiz_id'];
            } else {
                break;
            }
        } else {
            break;
        }
    }
    
    return $current;
}

// Always start from the original quiz
$root_quiz_id = getRootQuizId($conn, $quiz_id);
$allQuizIds = getAllRelatedQuizIds($conn, $root_quiz_id);
$quizIdsStr = implode(',', array_map('intval', $allQuizIds));

// Fetch all attempts for all related quizzes
$stmt = $conn->prepare("
    SELECT a.*, 
           q.quiz_title, 
           q.quiz_type,
           (SELECT COUNT(*) FROM quiz_questions_tb WHERE quiz_id = a.quiz_id) as total_questions,
           CASE 
               WHEN q.parent_quiz_id IS NULL THEN 'Original'
               ELSE 'AI Generated' 
           END as version_type
    FROM quiz_attempts_tb a
    JOIN quizzes_tb q ON a.quiz_id = q.quiz_id
    WHERE a.quiz_id IN ($quizIdsStr) AND a.status = 'completed'
    ORDER BY a.student_name, a.end_time DESC
");
$stmt->execute();
$result = $stmt->get_result();
$attempts = [];

while ($row = $result->fetch_assoc()) {
    $attempts[] = $row;
}

// Gather additional student information from class_enrollments_tb
$studentInfo = [];
foreach ($attempts as $attempt) {
    $studentId = $attempt['st_id'];
    
    // Only fetch info if we haven't already
    if (!isset($studentInfo[$studentId])) {
        $studentStmt = $conn->prepare("
            SELECT ce.*, 
                   CASE 
                       WHEN ce.grade_level = 'grade_11' THEN 'Grade 11'
                       WHEN ce.grade_level = 'grade_12' THEN 'Grade 12'
                       ELSE ce.grade_level
                   END AS formatted_grade,
                   sp.profile_picture
            FROM class_enrollments_tb ce 
            LEFT JOIN students_profiles_tb sp ON ce.st_id = sp.st_id
            WHERE ce.st_id = ? AND ce.class_id = ?
            LIMIT 1
        ");
        $studentStmt->bind_param("si", $studentId, $class_id);
        $studentStmt->execute();
        $studentRes = $studentStmt->get_result();
        
        if ($studentRes->num_rows > 0) {
            $studentInfo[$studentId] = $studentRes->fetch_assoc();
        } else {
            // If not found in this class, try to find in any class
            $anyClassStmt = $conn->prepare("
                SELECT ce.*, 
                       CASE 
                           WHEN ce.grade_level = 'grade_11' THEN 'Grade 11'
                           WHEN ce.grade_level = 'grade_12' THEN 'Grade 12'
                           ELSE ce.grade_level
                       END AS formatted_grade,
                       sp.profile_picture
                FROM class_enrollments_tb ce 
                LEFT JOIN students_profiles_tb sp ON ce.st_id = sp.st_id
                WHERE ce.st_id = ? 
                LIMIT 1
            ");
            $anyClassStmt->bind_param("s", $studentId);
            $anyClassStmt->execute();
            $anyClassRes = $anyClassStmt->get_result();
            
            if ($anyClassRes->num_rows > 0) {
                $studentInfo[$studentId] = $anyClassRes->fetch_assoc();
            } else {
                // Fallback if no enrollment record exists
                $studentInfo[$studentId] = [
                    'student_id' => 'Unknown',
                    'grade_level' => 'Unknown',
                    'formatted_grade' => 'Unknown',
                    'strand' => 'Unknown',
                    'profile_picture' => null
                ];
            }
        }
    }
}

// Calculate summary statistics
$totalAttempts = count($attempts);
$totalStudents = count(array_unique(array_column($attempts, 'st_id')));
$scoreSum = array_sum(array_column($attempts, 'score'));
$passingAttempts = count(array_filter($attempts, function($a) { return $a['result'] === 'passed'; }));

$avgScore = $totalAttempts > 0 ? round($scoreSum / $totalAttempts, 1) : 0;
$passRate = $totalAttempts > 0 ? round(($passingAttempts / $totalAttempts) * 100) : 0;

// Group students for chart display - simplified to focus on student data
$studentScores = [];
$uniqueStudents = [];

// Group by student to get their best scores and most recent attempt
foreach ($attempts as $attempt) {
    $studentId = $attempt['st_id'];
    $scorePercent = ($attempt['total_questions'] > 0) ? 
        round(($attempt['score'] / $attempt['total_questions']) * 100) : 0;
    
    if (!isset($studentScores[$studentId]) || $scorePercent > $studentScores[$studentId]['percent']) {
        $studentScores[$studentId] = [
            'name' => $attempt['student_name'],
            'score' => $attempt['score'],
            'total' => $attempt['total_questions'],
            'percent' => $scorePercent,
            'email' => $attempt['student_email'],
            'attempt_id' => $attempt['attempt_id'],
            'result' => $attempt['result'],
            'latest_attempt' => $attempt['end_time']
        ];
    }
    
    // Collect unique students with their most recent attempt
    if (!isset($uniqueStudents[$studentId])) {
        $uniqueStudents[$studentId] = [
            'student_id' => $studentId,
            'name' => $attempt['student_name'],
            'email' => $attempt['student_email'],
            'attempts' => 0, // Will count total attempts below
            'best_score' => 0,
            'best_percent' => 0,
            'latest_attempt_id' => $attempt['attempt_id'],
            'latest_attempt_date' => $attempt['end_time'],
            'latest_result' => $attempt['result']
        ];
    }
    
    // Update best score if this attempt is better
    if ($scorePercent > $uniqueStudents[$studentId]['best_percent']) {
        $uniqueStudents[$studentId]['best_score'] = $attempt['score'];
        $uniqueStudents[$studentId]['best_percent'] = $scorePercent;
    }
    
    // Update latest attempt if this one is more recent
    if (strtotime($attempt['end_time']) > strtotime($uniqueStudents[$studentId]['latest_attempt_date'])) {
        $uniqueStudents[$studentId]['latest_attempt_id'] = $attempt['attempt_id'];
        $uniqueStudents[$studentId]['latest_attempt_date'] = $attempt['end_time'];
        $uniqueStudents[$studentId]['latest_result'] = $attempt['result'];
    }
    
    // Count total attempts for this student
    $uniqueStudents[$studentId]['attempts']++;
}

// Format data for the chart
$chartLabels = array_map(function($s) { return $s['name']; }, array_values($studentScores));
$chartData = array_map(function($s) { return $s['percent']; }, array_values($studentScores));

$chartLabelsJson = json_encode($chartLabels);
$chartDataJson = json_encode($chartData);
?>