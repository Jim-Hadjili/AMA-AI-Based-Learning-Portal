<?php
include_once '../../../Connection/conn.php';

// Only show if teacher is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'teacher') {
    return;
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
    $students = [];
    $uniqueStudents = [];
    $totalClassesCount = 0;
    $totalQuizzesCreated = 0;
    $totalStudentsEnrolled = 0;
    $totalCompletionRate = 0;
    return;
}

$classIdsStr = implode(',', array_map('intval', $classIds));

// Get total number of classes taught by this teacher
$totalClassesCount = count($classIds);

// Get total quizzes created by this teacher - ONLY PUBLISHED MANUAL/ORIGINAL QUIZZES (not AI-generated)
$quizCountQuery = "SELECT COUNT(*) as total_quizzes FROM quizzes_tb 
                  WHERE class_id IN ($classIdsStr) 
                  AND quiz_type = 'manual' 
                  AND status = 'published'
                  AND (parent_quiz_id IS NULL OR parent_quiz_id = 0)";
$quizCountResult = $conn->query($quizCountQuery);
$totalQuizzesCreated = $quizCountResult ? $quizCountResult->fetch_assoc()['total_quizzes'] : 0;

// Get student enrollments across all classes
$enrollmentQuery = "
    SELECT ce.st_id, ce.student_name, ce.class_id, ce.enrollment_date,
           u.userEmail as email, sp.profile_picture
    FROM class_enrollments_tb ce
    JOIN users_tb u ON ce.st_id = u.user_id
    LEFT JOIN students_profiles_tb sp ON ce.st_id = sp.st_id
    WHERE ce.class_id IN ($classIdsStr)
";
$enrollmentResult = $conn->query($enrollmentQuery);

// Get quiz attempts by student - ONLY FOR ORIGINAL TEACHER-MADE QUIZZES
$quizAttemptsQuery = "
    SELECT qa.st_id, qa.student_name, qa.quiz_id, qa.attempt_id, qa.score, qa.status, qa.end_time,
           q.quiz_title, q.quiz_type, q.class_id,
           u.userEmail as email, sp.profile_picture
    FROM quiz_attempts_tb qa
    JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
    JOIN users_tb u ON qa.st_id = u.user_id
    LEFT JOIN students_profiles_tb sp ON qa.st_id = sp.st_id
    WHERE q.class_id IN ($classIdsStr)
    AND qa.status = 'completed'
    AND (q.parent_quiz_id IS NULL OR q.parent_quiz_id = 0)
    ORDER BY qa.end_time DESC
";

$quizAttemptsResult = $conn->query($quizAttemptsQuery);

// Get count of available original quizzes per class (excluding AI-generated)
$availableQuizzesPerClass = [];
$quizzesPerClassQuery = "
    SELECT class_id, COUNT(*) as quiz_count 
    FROM quizzes_tb 
    WHERE class_id IN ($classIdsStr) 
    AND quiz_type = 'manual'
    AND (parent_quiz_id IS NULL OR parent_quiz_id = 0)
    GROUP BY class_id
";
$quizzesPerClassResult = $conn->query($quizzesPerClassQuery);
if ($quizzesPerClassResult) {
    while ($row = $quizzesPerClassResult->fetch_assoc()) {
        $availableQuizzesPerClass[$row['class_id']] = $row['quiz_count'];
    }
}

// Initialize student enrollment data
$studentEnrollments = [];
$uniqueStudentIds = [];

if ($enrollmentResult && $enrollmentResult->num_rows > 0) {
    while ($row = $enrollmentResult->fetch_assoc()) {
        $studentId = $row['st_id'];
        $uniqueStudentIds[$studentId] = true;
        
        if (!isset($studentEnrollments[$studentId])) {
            $studentEnrollments[$studentId] = [
                'name' => $row['student_name'],
                'email' => $row['email'],
                'profile_picture' => $row['profile_picture'],
                'classes' => [],
                'total_classes' => 0,
                'first_enrollment' => $row['enrollment_date']
            ];
        }
        
        // Add class to student's enrollment list
        $studentEnrollments[$studentId]['classes'][] = [
            'class_id' => $row['class_id'],
            'class_name' => $classNames[$row['class_id']] ?? 'Unknown Class',
            'enrollment_date' => $row['enrollment_date']
        ];
        
        // Update first enrollment date if this one is earlier
        if (strtotime($row['enrollment_date']) < strtotime($studentEnrollments[$studentId]['first_enrollment'])) {
            $studentEnrollments[$studentId]['first_enrollment'] = $row['enrollment_date'];
        }
        
        // Count total classes
        $studentEnrollments[$studentId]['total_classes'] = count($studentEnrollments[$studentId]['classes']);
    }
}

// Total number of unique students enrolled
$totalStudentsEnrolled = count($uniqueStudentIds);

// Initialize variables
$students = [];
$uniqueStudents = [];
$totalAttempts = 0;
$totalPassed = 0;
$totalScoreSum = 0;
$totalScoreCount = 0;
$totalQuizzesCompleted = 0;
$classCompletionRates = [];

// Initialize completion rates per class
foreach ($classIds as $classId) {
    $classCompletionRates[$classId] = [
        'total_students' => 0,
        'total_quizzes' => $availableQuizzesPerClass[$classId] ?? 0,
        'completed_attempts' => 0
    ];
}

// Get the quiz attempt counts and last attempt dates per student
$studentQuizStats = [];

if ($quizAttemptsResult && $quizAttemptsResult->num_rows > 0) {
    while ($row = $quizAttemptsResult->fetch_assoc()) {
        $totalAttempts++;
        $totalQuizzesCompleted++;
        
        $studentId = $row['st_id'];
        $quizId = $row['quiz_id'];
        $classId = $row['class_id'];
        $score = $row['score'];
        
        // Track quiz attempt data by student
        if (!isset($studentQuizStats[$studentId])) {
            $studentQuizStats[$studentId] = [
                'attempt_count' => 0,
                'last_attempt_date' => null,
                'unique_quizzes' => []
            ];
        }
        $studentQuizStats[$studentId]['attempt_count']++;
        $studentQuizStats[$studentId]['unique_quizzes'][$quizId] = true;
        
        
        // Update class completion rates
        if (isset($classCompletionRates[$classId])) {
            $classCompletionRates[$classId]['completed_attempts']++;
        }
        
        // Assume all quizzes have a max score of 100
        $maxScore = 100;
        $scorePercent = round(($score / $maxScore) * 100);
        $passed = $scorePercent >= 65; // Passing score is 65%
        
        // Add to total for average calculation
        $totalScoreSum += $scorePercent;
        $totalScoreCount++;
        
        if ($passed) {
            $totalPassed++;
        }
        
        // Get enrollment data
        $enrolledClasses = isset($studentEnrollments[$studentId]) ? $studentEnrollments[$studentId]['total_classes'] : 0;
        $firstEnrollment = isset($studentEnrollments[$studentId]) ? $studentEnrollments[$studentId]['first_enrollment'] : null;
        
        // Calculate days since first enrollment
        $daysSinceEnrollment = $firstEnrollment ? round((time() - strtotime($firstEnrollment)) / (60 * 60 * 24)) : 0;
        
        // Track unique students and their performance
        if (!isset($uniqueStudents[$studentId])) {
            $uniqueStudents[$studentId] = [
                'name' => $row['student_name'],
                'email' => $row['email'],
                'profile_picture' => $row['profile_picture'],
                'attempts' => 0,
                'enrolled_classes' => $enrolledClasses,
                'best_score' => 0,
                'best_percent' => 0,
                'avg_percent' => 0,
                'total_score' => 0,
                'days_enrolled' => $daysSinceEnrollment,
                'activity_level' => 'Low', // Will calculate this later
                'engagement_score' => 0,   // Will calculate this later
                'latest_result' => 'failed',
                'latest_time' => null
            ];
        }
        
        // Update student stats
        $uniqueStudents[$studentId]['attempts']++;
        $uniqueStudents[$studentId]['total_score'] += $scorePercent;
        
        // Calculate average score
        $uniqueStudents[$studentId]['avg_percent'] = round(
            $uniqueStudents[$studentId]['total_score'] / $uniqueStudents[$studentId]['attempts']
        );
        
        // Update best score if this attempt is better
        if ($scorePercent > $uniqueStudents[$studentId]['best_percent']) {
            $uniqueStudents[$studentId]['best_score'] = $score;
            $uniqueStudents[$studentId]['best_percent'] = $scorePercent;
        }
        
        
        // Add to full attempts array
        $students[] = [
            'student_id' => $studentId,
            'student_name' => $row['student_name'],
            'email' => $row['email'],
            'profile_picture' => $row['profile_picture'],
            'quiz_id' => $quizId,
            'quiz_title' => $row['quiz_title'],
            'score' => $score,
            'max_score' => $maxScore,
            'score_percent' => $scorePercent,
            'passed' => $passed,
            'attempt_time' => $row['end_time'],
            'class_id' => $row['class_id'],
            'class_name' => $classNames[$row['class_id']] ?? 'Unknown Class'
        ];
    }
}

// Ensure all enrolled students are displayed, even if they have no quiz attempts
foreach ($studentEnrollments as $studentId => $enrollment) {
    if (!isset($uniqueStudents[$studentId])) {
        $uniqueStudents[$studentId] = [
            'name' => $enrollment['name'],
            'email' => $enrollment['email'],
            'profile_picture' => $enrollment['profile_picture'],
            'attempts' => 0,
            'enrolled_classes' => $enrollment['total_classes'],
            'best_score' => 0,
            'best_percent' => 0,
            'avg_percent' => 0,
            'total_score' => 0,
            'days_enrolled' => isset($enrollment['first_enrollment']) ? round((time() - strtotime($enrollment['first_enrollment'])) / (60 * 60 * 24)) : 0,
            'activity_level' => 'Low',
            'engagement_score' => 0,
            'latest_result' => null,
            'latest_time' => null
        ];
    }
}

// Calculate engagement score and activity level for each student without using login data
foreach ($uniqueStudents as $studentId => &$student) {
    // Calculate percentage of available quizzes attempted
    $uniqueQuizCount = isset($studentQuizStats[$studentId]) ? count($studentQuizStats[$studentId]['unique_quizzes']) : 0;
    $quizCompletionRate = $totalQuizzesCreated > 0 ? ($uniqueQuizCount / $totalQuizzesCreated * 100) : 0;
    
    // Calculate recency of activity (days since last attempt)
    $lastAttemptDate = isset($studentQuizStats[$studentId]) ? $studentQuizStats[$studentId]['last_attempt_date'] : null;
    $daysSinceLastAttempt = $lastAttemptDate ? round((time() - strtotime($lastAttemptDate)) / (60 * 60 * 24)) : 30;
    
    // Calculate attempt frequency (attempts per day enrolled)
    $attemptFrequency = $student['days_enrolled'] > 0 ? 
        ($student['attempts'] / $student['days_enrolled']) : 0;
    
    // Scale these metrics to a 0-100 range
    $quizCompletionScore = min($quizCompletionRate, 100);
    $recencyScore = max(0, 100 - min($daysSinceLastAttempt * 3.33, 100)); // 30 days old = 0 points
    $frequencyScore = min($attemptFrequency * 50, 100); // 2 attempts per day = 100 points
    $classEnrollmentScore = min(($student['enrolled_classes'] / $totalClassesCount * 100), 100);
    
    // Weighted engagement score calculation
    $student['engagement_score'] = round(
        ($quizCompletionScore * 0.35) +   // 35% weight on quiz completion
        ($student['avg_percent'] * 0.25) + // 25% weight on average score
        ($recencyScore * 0.15) +          // 15% weight on recency
        ($frequencyScore * 0.15) +        // 15% weight on frequency
        ($classEnrollmentScore * 0.10)    // 10% weight on class enrollment
    );
    
    // Determine activity level based on engagement score
    if ($student['engagement_score'] >= 75) {
        $student['activity_level'] = 'High';
    } elseif ($student['engagement_score'] >= 40) {
        $student['activity_level'] = 'Medium';
    } else {
        $student['activity_level'] = 'Low';
    }
}
unset($student); // Break the reference

// Calculate overall completion rate across all classes
$totalPossibleCompletions = $totalStudentsEnrolled * $totalQuizzesCreated;
$totalCompletionRate = $totalPossibleCompletions > 0 ? 
    round(($totalQuizzesCompleted / $totalPossibleCompletions) * 100) : 0;

// Calculate pass rate and average score
$passRate = $totalAttempts > 0 ? round(($totalPassed / $totalAttempts) * 100) : 0;
$avgScore = $totalScoreCount > 0 ? round($totalScoreSum / $totalScoreCount) : 0;

// Sort unique students by engagement score (descending)
uasort($uniqueStudents, function($a, $b) {
    return $b['engagement_score'] - $a['engagement_score'];
});

?>