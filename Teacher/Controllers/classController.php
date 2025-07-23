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
        // Ensure necessary tables exist
        ensureClassTablesExist($conn);
        
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
        $query = "SELECT 
                    st_id,
                    
                    student_name,
                    student_email,
                    grade_level,
                    strand,
                    student_id,
                    status,
                    enrollment_date
                  FROM class_enrollments_tb
                  WHERE class_id = ?
                  ORDER BY enrollment_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
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

/**
 * Ensure that necessary tables for class functionality exist
 * 
 * @param object $conn Database connection
 */
function ensureClassTablesExist($conn) {
    // Check and create teacher_classes_tb if it doesn't exist
    $tableCheckQuery = "SHOW TABLES LIKE 'teacher_classes_tb'";
    $tableCheckResult = $conn->query($tableCheckQuery);
    
    if ($tableCheckResult && $tableCheckResult->num_rows === 0) {
        $createTableQuery = "CREATE TABLE teacher_classes_tb (
            class_id INT AUTO_INCREMENT PRIMARY KEY,
            th_id VARCHAR(50) NOT NULL,
            class_name VARCHAR(255) NOT NULL,
            class_description TEXT,
            class_code VARCHAR(10) UNIQUE,
            grade_level VARCHAR(50),
            strand VARCHAR(50),
            status ENUM('active', 'archived', 'deleted') DEFAULT 'active',
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $conn->query($createTableQuery);
    }
    
    // Check and create class_enrollments_tb if it doesn't exist
    $tableCheckQuery = "SHOW TABLES LIKE 'class_enrollments_tb'";
    $tableCheckResult = $conn->query($tableCheckQuery);
    
    if ($tableCheckResult && $tableCheckResult->num_rows === 0) {
        $createTableQuery = "CREATE TABLE class_enrollments_tb (
            enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
            class_id INT NOT NULL,
            st_id VARCHAR(50) NOT NULL,
            enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
            FOREIGN KEY (class_id) REFERENCES teacher_classes_tb(class_id) ON DELETE CASCADE
        )";
        
        $conn->query($createTableQuery);
    }
}
?>