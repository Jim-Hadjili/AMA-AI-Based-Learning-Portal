<?php
/**
 * Class Details Controller - Handles data preparation for the class details page
 */

/**
 * Prepare all data needed for the class details page
 * 
 * @param object $conn Database connection
 * @param int $class_id The class ID to fetch
 * @return array|bool Array of data or false if class not found
 */
function prepareClassDetailsData($conn, $class_id) {
    // Get class details
    $classDetails = getClassDetails($conn, $class_id);
    
    // If class not found or doesn't belong to current teacher, return false
    if (!$classDetails) {
        return false;
    }
    
    // Get related data
    $students = getClassStudents($conn, $class_id);
    $quizzes = getClassQuizzes($conn, $class_id);
    $materials = getClassMaterials($conn, $class_id);
    
    // Calculate stats
    $stats = calculateClassStats($students, $quizzes);
    
    // Return all data as an array
    return [
        'classDetails' => $classDetails,
        'students' => $students,
        'quizzes' => $quizzes,
        'materials' => $materials,
        'stats' => $stats
    ];
}

/**
 * Calculate class statistics from raw data
 * 
 * @param array $students Array of student data
 * @param array $quizzes Array of quiz data
 * @return array Statistics array
 */
function calculateClassStats($students, $quizzes) {
    $activeStudentCount = 0;
    $pendingStudentCount = 0;
    $completedQuizCount = 0;
    $activeQuizCount = 0;
    
    // Count students by status
    foreach ($students as $student) {
        if ($student['status'] === 'active') {
            $activeStudentCount++;
        } elseif ($student['status'] === 'pending') {
            $pendingStudentCount++;
        }
    }
    
    // Count quizzes by status
    foreach ($quizzes as $quiz) {
        if ($quiz['status'] === 'published') {
            $activeQuizCount++;
        } elseif ($quiz['status'] === 'completed') {
            $completedQuizCount++;
        }
    }
    
    return [
        'activeStudentCount' => $activeStudentCount,
        'pendingStudentCount' => $pendingStudentCount,
        'completedQuizCount' => $completedQuizCount,
        'activeQuizCount' => $activeQuizCount,
        'totalQuizCount' => count($quizzes),
        'totalStudentCount' => count($students)
    ];
}
?>