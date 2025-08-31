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
        'pendingMessages' => 0,
        'totalAnnouncements' => 0 // <-- Add this line
    ];
    
    // Check if classes array is available and not empty
    if (!empty($classes)) {
        $studentIds = [];
        // Count active classes
        foreach ($classes as $class) {
            if (isset($class['status']) && $class['status'] === 'active') {
                $stats['activeClassesCount']++;
            }

            // Collect student IDs for unique count
            try {
                $tableCheckQuery = "SHOW TABLES LIKE 'class_enrollments_tb'";
                $tableCheckResult = $conn->query($tableCheckQuery);

                if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
                    $enrollmentQuery = "SELECT DISTINCT st_id FROM class_enrollments_tb WHERE class_id = ? AND status = 'active'";
                    $enrollmentStmt = $conn->prepare($enrollmentQuery);
                    $enrollmentStmt->bind_param("i", $class['class_id']);
                    $enrollmentStmt->execute();
                    $enrollmentResult = $enrollmentStmt->get_result();
                    while ($row = $enrollmentResult->fetch_assoc()) {
                        if (!empty($row['st_id'])) {
                            $studentIds[$row['st_id']] = true;
                        }
                    }
                }
            } catch (Exception $e) {
                error_log("Error counting students: " . $e->getMessage());
            }
            
            // Try to count quizzes
            try {
                $tableCheckQuery = "SHOW TABLES LIKE 'quizzes_tb'";
                $tableCheckResult = $conn->query($tableCheckQuery);

                if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
                    $quizQuery = "SELECT COUNT(*) as quiz_count FROM quizzes_tb WHERE class_id = ? AND quiz_type = 'manual'";
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
        // Count unique student IDs
        $stats['totalStudents'] = count($studentIds);
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

    // Count total announcements for all teacher's classes
    try {
        if (!empty($classes)) {
            $classIds = array_column($classes, 'class_id');
            $placeholders = implode(',', array_fill(0, count($classIds), '?'));
            $types = str_repeat('i', count($classIds));
            $query = "SELECT COUNT(*) as announcement_count FROM announcements_tb WHERE class_id IN ($placeholders)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param($types, ...$classIds);
            $stmt->execute();
            $result = $stmt->get_result();
            $stats['totalAnnouncements'] = $result->fetch_assoc()['announcement_count'];
        }
    } catch (Exception $e) {
        error_log("Error counting announcements: " . $e->getMessage());
    }

    // If no active classes are counted but there are classes, set to count of all classes
    if ($stats['activeClassesCount'] === 0 && !empty($classes)) {
        $stats['activeClassesCount'] = count($classes);
    }
    
    return $stats;
}
?>