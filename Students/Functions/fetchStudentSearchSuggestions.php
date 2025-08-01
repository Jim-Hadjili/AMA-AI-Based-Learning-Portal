<?php
session_start();
include_once '../../Connection/conn.php';

header('Content-Type: application/json');
$response = ['success' => false, 'data' => [], 'message' => 'An unknown error occurred.'];

try {
    if (!isset($conn) || $conn->connect_error) {
        throw new Exception("Database connection failed: " . ($conn->connect_error ?? 'Unknown error'));
    }
    if (!isset($_SESSION['st_id'])) {
        throw new Exception('Student not authenticated.');
    }
    $student_id = $_SESSION['st_id'];
    $query = $_GET['query'] ?? '';
    if (empty($query)) {
        $response['success'] = true;
        $response['data'] = [];
        $response['message'] = 'No search query provided.';
        echo json_encode($response);
        exit();
    }
    $search_term = "%" . $conn->real_escape_string($query) . "%";
    $sql = "SELECT
                tc.class_id,
                tc.class_name,
                tc.class_code,
                tc.class_description,
                tc.grade_level,
                tc.strand,
                tc.status,
                (SELECT COUNT(*) FROM class_enrollments_tb ce WHERE ce.class_id = tc.class_id AND ce.status = 'active') AS student_count,
                (SELECT COUNT(*) FROM quizzes_tb q WHERE q.class_id = tc.class_id AND q.status = 'published') AS quiz_count
            FROM
                teacher_classes_tb tc
            INNER JOIN class_enrollments_tb ce ON tc.class_id = ce.class_id
            WHERE
                ce.st_id = ? AND tc.class_name LIKE ?
            GROUP BY tc.class_id
            ORDER BY tc.class_name ASC
            LIMIT 10";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("SQL prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("ss", $student_id, $search_term);
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
    $response['message'] = 'Search successful.';
} catch (Exception $e) {
    $response['message'] = 'Server error: ' . $e->getMessage();
} finally {
    if (isset($stmt) && $stmt) $stmt->close();
    if (isset($conn) && $conn) $conn->close();
}
echo json_encode($response);
?>