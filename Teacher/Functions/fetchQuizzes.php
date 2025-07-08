<?php
function fetchQuizzes($conn, $class_id, $user_id) {
    $quizzes = [];
    
    if (isset($class_id)) {
        $stmt = $conn->prepare("
            SELECT 
                q.*,
                COUNT(qq.question_id) as question_count,
                COUNT(DISTINCT qa.st_id) as attempt_count,
                AVG(qa.score) as avg_score
            FROM quizzes_tb q 
            LEFT JOIN quiz_questions_tb qq ON q.quiz_id = qq.quiz_id 
            LEFT JOIN quiz_attempts_tb qa ON q.quiz_id = qa.quiz_id AND qa.status = 'completed'
            WHERE q.class_id = ? AND q.th_id = ?
            GROUP BY q.quiz_id 
            ORDER BY q.created_at DESC
        ");
        $stmt->bind_param("is", $class_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $quizzes = $result->fetch_all(MYSQLI_ASSOC);
    }
    
    return $quizzes;
}
?>