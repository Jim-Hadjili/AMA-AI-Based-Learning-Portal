<?php
/**
 * Class Controller - Handles all class-related operations
 */

/**
 * Get details for a specific class
 * 
 * @param object $conn Database connection
 * @param int $class_id The class ID to fetch
 * @return array|bool Class data array or false if not found
 */
function getClassDetails($conn, $class_id) {
    try {
        // Check if the class exists and belongs to the current teacher
        $query = "SELECT * FROM teacher_classes_tb WHERE class_id = ? AND th_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $class_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $classDetails = $result->fetch_assoc();
            
            // Make sure date_created exists, use current date if not
            if (!isset($classDetails['date_created'])) {
                $classDetails['date_created'] = date('Y-m-d H:i:s');
            }
            
            return $classDetails;
        }
        
        return false;
    } catch (Exception $e) {
        error_log("Error fetching class details: " . $e->getMessage());
        return false;
    }
}

/**
 * Get enrolled students for a class
 * 
 * @param object $conn Database connection
 * @param int $class_id The class ID
 * @return array Array of student data
 */
function getClassStudents($conn, $class_id) {
    $students = [];
    
    try {
        // Check if the table exists
        $tableCheckQuery = "SHOW TABLES LIKE 'class_enrollments_tb'";
        $tableCheckResult = $conn->query($tableCheckQuery);
        
        if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
            $query = "SELECT e.*, s.st_name, s.st_email, s.st_profile_img 
                     FROM class_enrollments_tb e 
                     JOIN students_profiles_tb s ON e.st_id = s.st_id 
                     WHERE e.class_id = ? 
                     ORDER BY e.enrollment_date DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
    } catch (Exception $e) {
        error_log("Error fetching class students: " . $e->getMessage());
    }
    
    return $students;
}

/**
 * Get quizzes for a class
 * 
 * @param object $conn Database connection
 * @param int $class_id The class ID
 * @return array Array of quiz data
 */
function getClassQuizzes($conn, $class_id) {
    $quizzes = [];
    
    try {
        // Check if the table exists
        $tableCheckQuery = "SHOW TABLES LIKE 'quizzes_tb'";
        $tableCheckResult = $conn->query($tableCheckQuery);
        
        if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
            $query = "SELECT * FROM quizzes_tb WHERE class_id = ? ORDER BY date_created DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $quizzes[] = $row;
            }
        }
    } catch (Exception $e) {
        error_log("Error fetching class quizzes: " . $e->getMessage());
    }
    
    return $quizzes;
}

/**
 * Get learning materials for a class
 * 
 * @param object $conn Database connection
 * @param int $class_id The class ID
 * @return array Array of learning material data
 */
function getClassMaterials($conn, $class_id) {
    $materials = [];
    
    try {
        // Check if the table exists
        $tableCheckQuery = "SHOW TABLES LIKE 'learning_materials_tb'";
        $tableCheckResult = $conn->query($tableCheckQuery);
        
        if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
            $query = "SELECT * FROM learning_materials_tb WHERE class_id = ? ORDER BY upload_date DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $materials[] = $row;
            }
        }
    } catch (Exception $e) {
        error_log("Error fetching class materials: " . $e->getMessage());
    }
    
    return $materials;
}
?>