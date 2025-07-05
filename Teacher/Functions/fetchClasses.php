<?php
function getTeacherClasses($conn, $teacher_id) {
    $classes = array();
    
    // SQL query to fetch all classes for this teacher
    $sql = "SELECT * FROM teacher_classes_tb WHERE th_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $teacher_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $classes[] = $row;
        }
    } else {
        // Log the error for debugging
        error_log("Error fetching classes: " . $conn->error);
    }
    
    $stmt->close();
    return $classes;
}
?>