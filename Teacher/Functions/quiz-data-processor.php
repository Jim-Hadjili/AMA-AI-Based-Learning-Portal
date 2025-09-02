<?php
/**
 * Get quiz details with verification that it belongs to current teacher
 *
 * @param mysqli $conn Database connection
 * @param int $quiz_id Quiz ID
 * @param string $teacher_id Teacher ID
 * @return array Quiz details or redirects if not found
 */
function getQuizDetails($conn, $quiz_id, $teacher_id) {
    $quizQuery = "SELECT q.*, tc.class_name, tc.class_code,
                  (SELECT COUNT(*) FROM quiz_attempts_tb WHERE quiz_id = q.quiz_id) as attempts_count
                  FROM quizzes_tb q 
                  JOIN teacher_classes_tb tc ON q.class_id = tc.class_id 
                  WHERE q.quiz_id = ? AND q.th_id = ?";

    $stmt = $conn->prepare($quizQuery);
    $stmt->bind_param("is", $quiz_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../Dashboard/teachersDashboard.php");
        exit;
    }

    return $result->fetch_assoc();
}

/**
 * Get quiz questions and their options
 *
 * @param mysqli $conn Database connection
 * @param int $quiz_id Quiz ID
 * @return array Array of questions with their options
 */
function getQuizQuestions($conn, $quiz_id) {
    $questionsQuery = "SELECT qq.*, 
                      GROUP_CONCAT(
                          CONCAT(qo.option_id, ':', qo.option_text, ':', qo.is_correct, ':', qo.option_order) 
                          ORDER BY qo.option_order SEPARATOR '|'
                      ) as options,
                      sa.correct_answer, sa.case_sensitive
                      FROM quiz_questions_tb qq 
                      LEFT JOIN question_options_tb qo ON qq.question_id = qo.question_id 
                      LEFT JOIN short_answer_tb sa ON qq.question_id = sa.question_id
                      WHERE qq.quiz_id = ? 
                      GROUP BY qq.question_id 
                      ORDER BY qq.question_order";

    $stmt = $conn->prepare($questionsQuery);
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $questionsResult = $stmt->get_result();
    return $questionsResult->fetch_all(MYSQLI_ASSOC);
}

/**
 * Process questions data for JavaScript
 *
 * @param array $questions Array of questions from database
 * @return array Processed questions for JavaScript
 */
function processQuestionsForJavaScript($questions) {
    $processedQuestions = [];
    foreach ($questions as $question) {
        $processedQuestion = [
            'id' => 'question_' . $question['question_id'],
            'question_id' => $question['question_id'],
            'type' => $question['question_type'],
            'text' => $question['question_text'],
            'points' => $question['question_points'],
            'order' => $question['question_order'],
            'options' => []
        ];
        
        if ($question['question_type'] === 'short-answer') {
            $processedQuestion['correctAnswer'] = $question['correct_answer'] ?? '';
            $processedQuestion['caseSensitive'] = $question['case_sensitive'] == 1;
        } else if (!empty($question['options'])) {
            $optionsData = explode('|', $question['options']);
            foreach ($optionsData as $optionData) {
                $parts = explode(':', $optionData);
                if (count($parts) >= 4) {
                    $processedQuestion['options'][] = [
                        'option_id' => $parts[0],
                        'text' => $parts[1],
                        'isCorrect' => $parts[2] == 1,
                        'order' => $parts[3]
                    ];
                }
            }
        }
        
        $processedQuestions[] = $processedQuestion;
    }
    
    return $processedQuestions;
}