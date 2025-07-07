<?php
session_start();
include_once __DIR__ . '/../../Connection/conn.php';
include_once __DIR__ . '/../../Assets/Auth/sessionCheck.php';

// Check if user is logged in and is a teacher
checkUserAccess('teacher');

// Handle different actions based on request
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Response array
$response = ['success' => false, 'message' => 'Invalid action'];

switch ($action) {
    case 'updateQuiz':
        $response = updateQuiz($conn);
        break;
    default:
        // Invalid action, response is already set
        break;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;

/**
 * Update an existing quiz with settings and questions
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function updateQuiz($conn) {
    try {
        // Get the JSON data from the request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data || !isset($data['quiz_id']) || !isset($data['quiz_settings']) || !isset($data['questions'])) {
            return ['success' => false, 'message' => 'Missing required data'];
        }
        
        $quiz_id = intval($data['quiz_id']);
        $quiz_settings = $data['quiz_settings'];
        $questions = $data['questions'];
        $teacher_id = $_SESSION['user_id'];
        
        // Verify that the quiz belongs to the current teacher
        $checkQuery = "SELECT q.quiz_id 
                      FROM quizzes_tb q 
                      JOIN teacher_classes_tb c ON q.class_id = c.class_id 
                      WHERE q.quiz_id = ? AND q.th_id = ?";
        
        $stmt = $conn->prepare($checkQuery);
        if (!$stmt) {
            return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
        }
        
        $stmt->bind_param("is", $quiz_id, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'You do not have permission to edit this quiz'];
        }
        
        // Begin transaction
        $conn->begin_transaction();
        
        try {
            // Update quiz settings
            $updateQuizQuery = "UPDATE quizzes_tb SET 
                               quiz_title = ?, 
                               quiz_description = ?, 
                               time_limit = ?, 
                               shuffle_questions = ?, 
                               allow_retakes = ?, 
                               status = ?, 
                               updated_at = NOW() 
                               WHERE quiz_id = ?";
            
            $stmt = $conn->prepare($updateQuizQuery);
            if (!$stmt) {
                throw new Exception('Database prepare error: ' . $conn->error);
            }
            
            $shuffle_questions = isset($quiz_settings['shuffle_questions']) ? 1 : 0;
            $allow_retakes = isset($quiz_settings['allow_retakes']) ? 1 : 0;
            
            $stmt->bind_param("ssiiiisi", 
                $quiz_settings['quiz_title'],
                $quiz_settings['quiz_description'],
                $quiz_settings['time_limit'],
                $shuffle_questions,
                $allow_retakes,
                $quiz_settings['status'],
                $quiz_id
            );
            
            $stmt->execute();
            
            // Get existing question IDs to determine which to delete
            $existingQuestionsQuery = "SELECT question_id FROM quiz_questions_tb WHERE quiz_id = ?";
            $stmt = $conn->prepare($existingQuestionsQuery);
            if (!$stmt) {
                throw new Exception('Database prepare error: ' . $conn->error);
            }
            
            $stmt->bind_param("i", $quiz_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $existingQuestionIds = [];
            while ($row = $result->fetch_assoc()) {
                $existingQuestionIds[] = $row['question_id'];
            }
            
            $updatedQuestionIds = [];
            $questionMappings = [];
            
            // Process each question
            foreach ($questions as $index => $question) {
                $questionText = $question['text'];
                $questionType = $question['type'];
                $points = isset($question['points']) ? $question['points'] : 1;
                $order = $index + 1;
                
                if (isset($question['question_id']) && $question['question_id']) {
                    // Update existing question
                    $question_id = $question['question_id'];
                    $updatedQuestionIds[] = $question_id;
                    
                    $updateQuestionQuery = "UPDATE quiz_questions_tb SET 
                                          question_text = ?, 
                                          question_type = ?, 
                                          question_points = ?, 
                                          question_order = ?, 
                                          updated_at = NOW() 
                                          WHERE question_id = ?";
                    
                    $stmt = $conn->prepare($updateQuestionQuery);
                    if (!$stmt) {
                        throw new Exception('Database prepare error: ' . $conn->error);
                    }
                    
                    $stmt->bind_param("ssiii", $questionText, $questionType, $points, $order, $question_id);
                    $stmt->execute();
                    
                    // Delete existing options for this question
                    $deleteOptionsQuery = "DELETE FROM question_options_tb WHERE question_id = ?";
                    $stmt = $conn->prepare($deleteOptionsQuery);
                    if (!$stmt) {
                        throw new Exception('Database prepare error: ' . $conn->error);
                    }
                    $stmt->bind_param("i", $question_id);
                    $stmt->execute();
                    
                    // Delete existing short answer for this question
                    $deleteShortAnswerQuery = "DELETE FROM short_answer_tb WHERE question_id = ?";
                    $stmt = $conn->prepare($deleteShortAnswerQuery);
                    if (!$stmt) {
                        throw new Exception('Database prepare error: ' . $conn->error);
                    }
                    $stmt->bind_param("i", $question_id);
                    $stmt->execute();
                    
                } else {
                    // Insert new question
                    $insertQuestionQuery = "INSERT INTO quiz_questions_tb 
                                          (quiz_id, question_text, question_type, question_points, question_order) 
                                          VALUES (?, ?, ?, ?, ?)";
                    
                    $stmt = $conn->prepare($insertQuestionQuery);
                    if (!$stmt) {
                        throw new Exception('Database prepare error: ' . $conn->error);
                    }
                    
                    $stmt->bind_param("issii", $quiz_id, $questionText, $questionType, $points, $order);
                    $stmt->execute();
                    
                    $question_id = $stmt->insert_id;
                    $updatedQuestionIds[] = $question_id;
                    $questionMappings[$question['id']] = $question_id;
                }
                
                // Handle question options/answers based on type
                switch ($questionType) {
                    case 'multiple-choice':
                    case 'checkbox':
                    case 'true-false':
                        // Insert options
                        if (isset($question['options']) && is_array($question['options'])) {
                            foreach ($question['options'] as $optionIndex => $option) {
                                $optionText = $option['text'];
                                $isCorrect = $option['isCorrect'] ? 1 : 0;
                                $optionOrder = $optionIndex + 1;
                                
                                $insertOptionQuery = "INSERT INTO question_options_tb 
                                                    (question_id, option_text, is_correct, option_order) 
                                                    VALUES (?, ?, ?, ?)";
                                
                                $stmt = $conn->prepare($insertOptionQuery);
                                if (!$stmt) {
                                    throw new Exception('Database prepare error: ' . $conn->error);
                                }
                                
                                $stmt->bind_param("isii", $question_id, $optionText, $isCorrect, $optionOrder);
                                $stmt->execute();
                            }
                        }
                        break;
                        
                    case 'short-answer':
                        // Insert short answer
                        $correctAnswer = $question['correctAnswer'];
                        $caseSensitive = isset($question['caseSensitive']) && $question['caseSensitive'] ? 1 : 0;
                        
                        $insertShortAnswerQuery = "INSERT INTO short_answer_tb 
                                                 (question_id, correct_answer, case_sensitive) 
                                                 VALUES (?, ?, ?)";
                        
                        $stmt = $conn->prepare($insertShortAnswerQuery);
                        if (!$stmt) {
                            throw new Exception('Database prepare error: ' . $conn->error);
                        }
                        
                        $stmt->bind_param("isi", $question_id, $correctAnswer, $caseSensitive);
                        $stmt->execute();
                        break;
                }
            }
            
            // Delete questions that are no longer in the updated list
            $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
            if (!empty($questionsToDelete)) {
                $placeholders = str_repeat('?,', count($questionsToDelete) - 1) . '?';
                $deleteQuestionsQuery = "DELETE FROM quiz_questions_tb WHERE question_id IN ($placeholders)";
                
                $stmt = $conn->prepare($deleteQuestionsQuery);
                if (!$stmt) {
                    throw new Exception('Database prepare error: ' . $conn->error);
                }
                
                $types = str_repeat('i', count($questionsToDelete));
                $stmt->bind_param($types, ...$questionsToDelete);
                $stmt->execute();
            }
            
            // Commit transaction
            $conn->commit();
            
            return [
                'success' => true, 
                'message' => 'Quiz updated successfully',
                'quiz_id' => $quiz_id,
                'question_mappings' => $questionMappings
            ];
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            throw $e;
        }
        
    } catch (Exception $e) {
        error_log("Error updating quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while updating the quiz: ' . $e->getMessage()];
    }
}
?>