<?php
session_start();

// Fix the paths using __DIR__ to make paths absolute
include_once __DIR__ . '/../../Connection/conn.php';
include_once __DIR__ . '/../../Assets/Auth/sessionCheck.php';

// Check if user is logged in and is a teacher
if (!function_exists('checkUserAccess')) {
    // Fallback function if sessionCheck.php didn't load correctly
    function checkUserAccess($role) {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $role) {
            // Return an error response instead of redirecting since this is an AJAX endpoint
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            exit;
        }
    }
}

// Check user access
checkUserAccess('teacher');

// Handle different actions based on request
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Response array
$response = ['success' => false, 'message' => 'Invalid action'];

switch ($action) {
    case 'createQuiz':
        $response = createQuiz($conn);
        break;
    case 'saveQuestions':
        $response = saveQuestions($conn);
        break;
    case 'updateQuiz':
        $response = updateQuiz($conn);
        break;
    case 'deleteQuiz':
        $response = deleteQuiz($conn);
        break;
    // Other actions can be added here
    default:
        // Invalid action, response is already set
        break;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;

/**
 * Create a new quiz
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function createQuiz($conn) {
    try {
        // Log the incoming data for debugging
        error_log("Create Quiz Request: " . json_encode($_POST));

        // Validate required fields
        if (!isset($_POST['class_id']) || !isset($_POST['quiz_title']) || empty($_POST['quiz_title'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }

        // Get form data
        $class_id = intval($_POST['class_id']);
        $quiz_title = trim($_POST['quiz_title']);
        $quiz_description = isset($_POST['quiz_description']) ? trim($_POST['quiz_description']) : '';
        $time_limit = isset($_POST['time_limit']) ? intval($_POST['time_limit']) : 30;
        $passing_score = isset($_POST['passing_score']) ? intval($_POST['passing_score']) : 70;
        $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : null;
        $status = isset($_POST['status']) ? trim($_POST['status']) : 'draft';
        $teacher_id = $_SESSION['user_id'];
        
        // Points per question (default to 1)
        $points_per_question = 1;

        // Check if the class exists and belongs to the current teacher
        $checkQuery = "SELECT class_id FROM teacher_classes_tb WHERE class_id = ? AND th_id = ?";
        $stmt = $conn->prepare($checkQuery);
        
        if (!$stmt) {
            return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
        }
        
        $stmt->bind_param("is", $class_id, $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'You do not have permission to add quizzes to this class'];
        }

        // Get the table structure to see if passing_score column exists
        $tableStructureQuery = "DESCRIBE quizzes_tb";
        $tableStructureResult = $conn->query($tableStructureQuery);
        
        $hasPassingScore = false;
        if ($tableStructureResult) {
            while ($row = $tableStructureResult->fetch_assoc()) {
                if ($row['Field'] === 'passing_score') {
                    $hasPassingScore = true;
                    break;
                }
            }
        }

        // Prepare the INSERT statement based on the table structure
        if ($hasPassingScore) {
            $insertQuery = "INSERT INTO quizzes_tb (class_id, th_id, quiz_title, quiz_description, time_limit, passing_score, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertQuery);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
            }
            
            $stmt->bind_param("isssiss", 
                $class_id, 
                $teacher_id,
                $quiz_title, 
                $quiz_description, 
                $time_limit, 
                $passing_score, 
                $status
            );
        } else {
            // Use points_per_question instead of passing_score
            $insertQuery = "INSERT INTO quizzes_tb (class_id, th_id, quiz_title, quiz_description, time_limit, points_per_question, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertQuery);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
            }
            
            $stmt->bind_param("isssiss", 
                $class_id, 
                $teacher_id,
                $quiz_title, 
                $quiz_description, 
                $time_limit, 
                $points_per_question, 
                $status
            );
        }
        
        $result = $stmt->execute();
        
        if ($result) {
            $quiz_id = $stmt->insert_id;
            return [
                'success' => true, 
                'message' => 'Quiz created successfully',
                'quiz_id' => $quiz_id,
                'quiz_title' => $quiz_title
            ];
        } else {
            return ['success' => false, 'message' => 'Failed to create quiz: ' . $stmt->error];
        }
    } catch (Exception $e) {
        error_log("Error creating quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while creating the quiz: ' . $e->getMessage()];
    }
}

/**
 * Save quiz questions
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function saveQuestions($conn) {
    try {
        // Get the JSON data from the request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data || !isset($data['quiz_id']) || !isset($data['questions']) || empty($data['questions'])) {
            return ['success' => false, 'message' => 'Missing required data'];
        }
        
        $quiz_id = intval($data['quiz_id']);
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
            // Delete existing questions for this quiz
            $deleteQuery = "DELETE FROM quiz_questions_tb WHERE quiz_id = ?";
            
            $stmt = $conn->prepare($deleteQuery);
            
            if (!$stmt) {
                throw new Exception('Database prepare error: ' . $conn->error);
            }
            
            $stmt->bind_param("i", $quiz_id);
            $stmt->execute();
            
            // Insert new questions
            foreach ($questions as $index => $question) {
                $questionText = $question['text'];
                $questionType = $question['type'];
                $points = isset($question['points']) ? $question['points'] : 1;
                $order = $index + 1;
                
                // Check if the table has question_points or just points
                $checkColumnQuery = "SHOW COLUMNS FROM quiz_questions_tb LIKE 'question_points'";
                $checkColumnResult = $conn->query($checkColumnQuery);
                
                if ($checkColumnResult && $checkColumnResult->num_rows > 0) {
                    // Use question_points field
                    $insertQuestionQuery = "INSERT INTO quiz_questions_tb 
                                          (quiz_id, question_text, question_type, question_points, question_order) 
                                          VALUES (?, ?, ?, ?, ?)";
                } else {
                    // Fallback to default structure
                    $insertQuestionQuery = "INSERT INTO quiz_questions_tb 
                                          (quiz_id, question_text, question_type, question_order) 
                                          VALUES (?, ?, ?, ?)";
                }
                
                $stmt = $conn->prepare($insertQuestionQuery);
                
                if (!$stmt) {
                    throw new Exception('Database prepare error: ' . $conn->error);
                }
                
                if ($checkColumnResult && $checkColumnResult->num_rows > 0) {
                    $stmt->bind_param("issii", $quiz_id, $questionText, $questionType, $points, $order);
                } else {
                    $stmt->bind_param("issi", $quiz_id, $questionText, $questionType, $order);
                }
                
                $stmt->execute();
                
                $question_id = $stmt->insert_id;
                
                // Handle different question types
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
                        // Check if short_answer_tb table exists
                        $tableCheckQuery = "SHOW TABLES LIKE 'short_answer_tb'";
                        $tableCheckResult = $conn->query($tableCheckQuery);
                        
                        if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
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
                        } else {
                            // If table doesn't exist, store answer in options table as fallback
                            $correctAnswer = $question['correctAnswer'];
                            
                            $insertOptionQuery = "INSERT INTO question_options_tb 
                                                (question_id, option_text, is_correct, option_order) 
                                                VALUES (?, ?, 1, 1)";
                            
                            $stmt = $conn->prepare($insertOptionQuery);
                            
                            if (!$stmt) {
                                throw new Exception('Database prepare error: ' . $conn->error);
                            }
                            
                            $stmt->bind_param("is", $question_id, $correctAnswer);
                            $stmt->execute();
                        }
                        break;
                }
            }
            
            // Update the quiz status
            $updateQuery = "UPDATE quizzes_tb SET status = 'published', updated_at = NOW() WHERE quiz_id = ?";
            $stmt = $conn->prepare($updateQuery);
            
            if (!$stmt) {
                throw new Exception('Database prepare error: ' . $conn->error);
            }
            
            $stmt->bind_param("i", $quiz_id);
            $stmt->execute();
            
            // Commit transaction
            $conn->commit();
            
            return [
                'success' => true, 
                'message' => 'Quiz questions saved successfully',
                'quiz_id' => $quiz_id
            ];
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            throw $e;
        }
        
    } catch (Exception $e) {
        error_log("Error saving quiz questions: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while saving the questions: ' . $e->getMessage()];
    }
}

/**
 * Update an existing quiz
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function updateQuiz($conn) {
    try {
        // Implementation for updating quiz
        return ['success' => false, 'message' => 'Update quiz function not yet implemented'];
    } catch (Exception $e) {
        error_log("Error updating quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while updating the quiz: ' . $e->getMessage()];
    }
}

/**
 * Delete a quiz
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function deleteQuiz($conn) {
    try {
        // Implementation for deleting quiz
        return ['success' => false, 'message' => 'Delete quiz function not yet implemented'];
    } catch (Exception $e) {
        error_log("Error deleting quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while deleting the quiz: ' . $e->getMessage()];
    }
}
?>