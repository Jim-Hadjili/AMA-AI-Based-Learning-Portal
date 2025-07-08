<?php
/**
 * Loads quiz data and questions for preview
 * 
 * @param object $conn Database connection
 * @param int $quiz_id Quiz ID to load
 * @param string $teacher_id Teacher ID for verification
 * @return array|false Quiz data or false if not found
 */
function loadQuizData($conn, $quiz_id, $teacher_id) {
    // Fetch quiz data
    $quizSql = "SELECT q.*, c.class_name, c.class_id 
               FROM quizzes_tb q
               JOIN teacher_classes_tb c ON q.class_id = c.class_id
               WHERE q.quiz_id = ? AND c.th_id = ?";
    $quizStmt = $conn->prepare($quizSql);
    $quizStmt->bind_param("is", $quiz_id, $teacher_id);
    $quizStmt->execute();
    $quizResult = $quizStmt->get_result();

    // If quiz not found or doesn't belong to this teacher, return false
    if ($quizResult->num_rows === 0) {
        return false;
    }

    $quiz = $quizResult->fetch_assoc();

    // Fetch quiz questions
    $questionsSql = "SELECT qq.*, 
                    (SELECT COUNT(*) FROM question_options_tb qo WHERE qo.question_id = qq.question_id) AS option_count
                    FROM quiz_questions_tb qq 
                    WHERE qq.quiz_id = ? 
                    ORDER BY qq.question_order";
    $questionsStmt = $conn->prepare($questionsSql);
    $questionsStmt->bind_param("i", $quiz_id);
    $questionsStmt->execute();
    $questionsResult = $questionsStmt->get_result();
    $questions = [];

    while ($question = $questionsResult->fetch_assoc()) {
        // Fetch options for each question if it's multiple choice or checkboxes
        if ($question['question_type'] === 'multiple_choice' || $question['question_type'] === 'checkbox') {
            $optionsSql = "SELECT * FROM question_options_tb WHERE question_id = ? ORDER BY option_order";
            $optionsStmt = $conn->prepare($optionsSql);
            $optionsStmt->bind_param("i", $question['question_id']);
            $optionsStmt->execute();
            $optionsResult = $optionsStmt->get_result();
            $options = [];
            
            while ($option = $optionsResult->fetch_assoc()) {
                $options[] = $option;
            }
            
            $question['options'] = $options;
        }
        
        $questions[] = $question;
    }

    // Calculate total points
    $totalPoints = 0;
    foreach ($questions as $question) {
        $totalPoints += $question['question_points'];
    }

    return [
        'quiz' => $quiz,
        'questions' => $questions,
        'totalPoints' => $totalPoints
    ];
}