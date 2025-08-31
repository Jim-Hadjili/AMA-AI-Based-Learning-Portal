<?php
session_start();
// Temporarily enable error reporting for debugging. REMOVE IN PRODUCTION!
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../Connection/conn.php'; // Adjust path as necessary

header('Content-Type: application/json');

$response = ['success' => false, 'data' => [], 'message' => 'An unknown error occurred.']; // Default error message

try {
    if (!isset($conn) || $conn->connect_error) {
        throw new Exception("Database connection failed: " . ($conn->connect_error ?? 'Unknown error'));
    }

    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not authenticated. Please log in.');
    }

    $teacher_id = $_SESSION['user_id'];
    $query = $_GET['query'] ?? '';

    if (empty($query)) {
        // If query is empty, return an empty successful data set, not an error
        $response['success'] = true;
        $response['data'] = [];
        $response['message'] = 'No search query provided.';
        echo json_encode($response);
        exit();
    }

    // Sanitize the input query
    $search_term = "%" . $conn->real_escape_string($query) . "%";

    // Prepare the SQL statement to fetch all necessary class details, including counts
    $sql = "SELECT
                tc.class_id,
                tc.class_name,
                tc.class_code,
                tc.class_description,
                tc.grade_level,
                tc.strand,
                tc.status,
                (SELECT COUNT(*) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count,
                (SELECT COUNT(*) FROM quizzes_tb q WHERE q.class_id = tc.class_id AND q.status = 'published' AND q.quiz_type = 'manual') AS quiz_count
            FROM
                teacher_classes_tb tc
            WHERE
                tc.th_id = ? AND tc.class_name LIKE ?
            ORDER BY
                tc.class_name ASC
            LIMIT 10";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("SQL prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("ss", $teacher_id, $search_term);

    if (!$stmt->execute()) {
        throw new Exception("SQL execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $result = $stmt->get_result();
    $classes = [];
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }

    $response['success'] = true;
    $response['data'] = $classes;
    $response['message'] = 'Search successful.'; // Clear message on success

} catch (Exception $e) {
    $response['message'] = 'Server error: ' . $e->getMessage();
    error_log("Search suggestion error: " . $e->getMessage()); // Log detailed error on the server
} finally {
    if (isset($stmt) && $stmt) {
        $stmt->close();
    }
    if (isset($conn) && $conn) {
        $conn->close();
    }
}

echo json_encode($response);
?>
