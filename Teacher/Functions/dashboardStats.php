<?php
/**
 * Get dashboard statistics for teacher
 * 
 * @param object $conn Database connection
 * @param array $classes Teacher's classes array
 * @param string $teacher_id Teacher's ID
 * @return array Array containing all dashboard statistics
 */
function getTeacherDashboardStats($conn, $classes, $teacher_id) {
    $stats = [
        'totalStudents' => 0,
        'activeClassesCount' => 0,
        'totalQuizzes' => 0,
        'pendingMessages' => 0
    ];
    
    // Check if classes array is available and not empty
    if (!empty($classes)) {
        // Count active classes
        foreach ($classes as $class) {
            if (isset($class['status']) && $class['status'] === 'active') {
                $stats['activeClassesCount']++;
            }
            
            // Try to count students per class
            try {
                $tableCheckQuery = "SHOW TABLES LIKE 'class_enrollments_tb'";
                $tableCheckResult = $conn->query($tableCheckQuery);
                
                if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
                    $enrollmentQuery = "SELECT COUNT(DISTINCT st_id) as student_count FROM class_enrollments_tb WHERE class_id = ? AND status = 'active'";
                    $enrollmentStmt = $conn->prepare($enrollmentQuery);
                    $enrollmentStmt->bind_param("i", $class['class_id']);
                    $enrollmentStmt->execute();
                    $enrollmentResult = $enrollmentStmt->get_result();
                    $stats['totalStudents'] += $enrollmentResult->fetch_assoc()['student_count'];
                }
            } catch (Exception $e) {
                // Log error silently
                error_log("Error counting students: " . $e->getMessage());
            }
            
            // Try to count quizzes
            try {
                $tableCheckQuery = "SHOW TABLES LIKE 'quizzes_tb'";
                $tableCheckResult = $conn->query($tableCheckQuery);
                
                if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
                    $quizQuery = "SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ?";
                    $quizStmt = $conn->prepare($quizQuery);
                    $quizStmt->bind_param("i", $class['class_id']);
                    $quizStmt->execute();
                    $quizResult = $quizStmt->get_result();
                    $stats['totalQuizzes'] += $quizResult->fetch_assoc()['quiz_count'];
                }
            } catch (Exception $e) {
                // Log error silently
                error_log("Error counting quizzes: " . $e->getMessage());
            }
        }
    }

    // Try to count messages
    try {
        $tableCheckQuery = "SHOW TABLES LIKE 'messages_tb'";
        $tableCheckResult = $conn->query($tableCheckQuery);
        
        if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
            $messageQuery = "SELECT COUNT(*) as message_count FROM messages_tb WHERE receiver_id = ? AND is_read = 0";
            $messageStmt = $conn->prepare($messageQuery);
            $messageStmt->bind_param("s", $teacher_id);
            $messageStmt->execute();
            $messageResult = $messageStmt->get_result();
            $stats['pendingMessages'] = $messageResult->fetch_assoc()['message_count'];
        }
    } catch (Exception $e) {
        // Log error silently
        error_log("Error counting messages: " . $e->getMessage());
    }

    // If no active classes are counted but there are classes, set to count of all classes
    if ($stats['activeClassesCount'] === 0 && !empty($classes)) {
        $stats['activeClassesCount'] = count($classes);
    }
    
    return $stats;
}
?>