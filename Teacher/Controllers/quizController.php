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
    case 'publishQuiz':
        $response = publishQuiz($conn);
        break;
    case 'unpublishQuiz':
        $response = unpublishQuiz($conn);
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
        $allow_retakes = isset($_POST['allow_retakes']) ? intval($_POST['allow_retakes']) : 1;

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
            // Add allow_retakes to the insert and bind
            $insertQuery = "INSERT INTO quizzes_tb (class_id, th_id, quiz_title, quiz_description, time_limit, passing_score, status, allow_retakes) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertQuery);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
            }
            
            $stmt->bind_param("isssissi", 
                $class_id, 
                $teacher_id,
                $quiz_title, 
                $quiz_description, 
                $time_limit, 
                $passing_score, 
                $status,
                $allow_retakes
            );
        } else {
            // Use points_per_question instead of passing_score
            $insertQuery = "INSERT INTO quizzes_tb (class_id, th_id, quiz_title, quiz_description, time_limit, points_per_question, status, allow_retakes) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertQuery);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
            }
            
            $stmt->bind_param("isssissi", 
                $class_id, 
                $teacher_id,
                $quiz_title, 
                $quiz_description, 
                $time_limit, 
                $points_per_question, 
                $status,
                $allow_retakes
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
        // Get the JSON data from the request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data || !isset($data['quiz_id']) || !isset($data['questions'])) {
            return ['success' => false, 'message' => 'Missing required data'];
        }
        
        $quiz_id = intval($data['quiz_id']);
        $questions = $data['questions'];
        $teacher_id = $_SESSION['user_id'];
        
        // Update quiz settings if provided
        if (isset($data['quiz_settings']) && !empty($data['quiz_settings'])) {
            $settings = $data['quiz_settings'];
            
            $updateFields = [];
            $params = [];
            $types = "";
            
            // Add fields that might be updated
            if (isset($settings['quiz_title']) && !empty($settings['quiz_title'])) {
                $updateFields[] = "quiz_title = ?";
                $params[] = $settings['quiz_title'];
                $types .= "s";
            }
            
            if (isset($settings['quiz_description'])) {
                $updateFields[] = "quiz_description = ?";
                $params[] = $settings['quiz_description'];
                $types .= "s";
            }
            
            if (isset($settings['time_limit'])) {
                $updateFields[] = "time_limit = ?";
                $params[] = intval($settings['time_limit']);
                $types .= "i";
            }
            
            if (isset($settings['passing_score'])) {
                $updateFields[] = "passing_score = ?";
                $params[] = intval($settings['passing_score']);
                $types .= "i";
            }
            
            if (isset($settings['status'])) {
                $updateFields[] = "status = ?";
                $params[] = $settings['status'];
                $types .= "s";
            }
            
            if (isset($settings['due_date'])) {
                $updateFields[] = "due_date = ?";
                $params[] = $settings['due_date'];
                $types .= "s";
            }
            
            // Only update if we have fields to update
            if (!empty($updateFields)) {
                $updateFields[] = "updated_at = NOW()";
                
                $updateQuery = "UPDATE quizzes_tb SET " . implode(", ", $updateFields) . " WHERE quiz_id = ? AND th_id = ?";
                $params[] = $quiz_id;
                $params[] = $teacher_id;
                $types .= "is";
                
                $stmt = $conn->prepare($updateQuery);
                
                if (!$stmt) {
                    throw new Exception('Database prepare error: ' . $conn->error);
                }
                
                $stmt->bind_param($types, ...$params);
                $result = $stmt->execute();
                
                if (!$result) {
                    throw new Exception('Failed to update quiz settings: ' . $stmt->error);
                }
            }
        }
        
        // Handle the questions - similar to saveQuestions function
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
            
            // Create a mapping to track new question IDs
            $questionMappings = [];
            
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
                
                // Store mapping for newly created questions
                if (!isset($question['question_id']) || $question['question_id'] === null) {
                    $questionMappings[$question['id']] = $question_id;
                }
                
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

/**
 * Delete a quiz
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function deleteQuiz($conn) {
    try {
        // Check if quiz_id is provided
        if (!isset($_POST['quiz_id'])) {
            return ['success' => false, 'message' => 'Missing quiz ID'];
        }
        
        $quizId = intval($_POST['quiz_id']);
        $teacherId = $_SESSION['user_id'];
        
        // First, verify that the quiz belongs to the logged-in teacher
        $stmt = $conn->prepare("SELECT quiz_id FROM quizzes_tb WHERE quiz_id = ? AND th_id = ?");
        $stmt->bind_param("is", $quizId, $teacherId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'Quiz not found or you do not have permission to delete it'];
        }
        
        // Begin transaction to ensure clean deletion
        $conn->begin_transaction();
        
        try {
            // Delete associated question options first (due to foreign key constraints)
            $deleteOptionsQuery = "DELETE qo FROM question_options_tb qo 
                                 JOIN quiz_questions_tb qq ON qo.question_id = qq.question_id 
                                 WHERE qq.quiz_id = ?";
            $stmt = $conn->prepare($deleteOptionsQuery);
            $stmt->bind_param("i", $quizId);
            $stmt->execute();
            
            // Delete any short answers if they exist
            $shortAnswerTableExists = $conn->query("SHOW TABLES LIKE 'short_answer_tb'")->num_rows > 0;
            if ($shortAnswerTableExists) {
                $deleteShortAnswersQuery = "DELETE sa FROM short_answer_tb sa 
                                          JOIN quiz_questions_tb qq ON sa.question_id = qq.question_id 
                                          WHERE qq.quiz_id = ?";
                $stmt = $conn->prepare($deleteShortAnswersQuery);
                $stmt->bind_param("i", $quizId);
                $stmt->execute();
            }
            
            // Delete questions
            $deleteQuestionsQuery = "DELETE FROM quiz_questions_tb WHERE quiz_id = ?";
            $stmt = $conn->prepare($deleteQuestionsQuery);
            $stmt->bind_param("i", $quizId);
            $stmt->execute();
            
            // Delete any quiz attempts if they exist
            $attemptsTableExists = $conn->query("SHOW TABLES LIKE 'quiz_attempts_tb'")->num_rows > 0;
            if ($attemptsTableExists) {
                $deleteAttemptsQuery = "DELETE FROM quiz_attempts_tb WHERE quiz_id = ?";
                $stmt = $conn->prepare($deleteAttemptsQuery);
                $stmt->bind_param("i", $quizId);
                $stmt->execute();
            }
            
            // Finally delete the quiz itself
            $deleteQuizQuery = "DELETE FROM quizzes_tb WHERE quiz_id = ?";
            $stmt = $conn->prepare($deleteQuizQuery);
            $stmt->bind_param("i", $quizId);
            $stmt->execute();
            
            // Commit the transaction
            $conn->commit();
            
            return [
                'success' => true, 
                'message' => 'Quiz deleted successfully'
            ];
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            throw $e;
        }
    } catch (Exception $e) {
        error_log("Error deleting quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while deleting the quiz: ' . $e->getMessage()];
    }
}

/**
 * Publish a quiz
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function publishQuiz($conn) {
    try {
        if (!isset($_POST['quiz_id']) || empty($_POST['quiz_id'])) {
            return ['success' => false, 'message' => 'Quiz ID is required'];
        }

        $quiz_id = intval($_POST['quiz_id']);
        $teacher_id = $_SESSION['user_id'];
        
        // Verify the quiz belongs to this teacher
        $checkSql = "SELECT q.quiz_id FROM quizzes_tb q 
                    JOIN teacher_classes_tb c ON q.class_id = c.class_id 
                    WHERE q.quiz_id = ? AND q.th_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("is", $quiz_id, $teacher_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'You do not have permission to modify this quiz'];
        }
        
        // Update quiz status to published - FIXED TABLE NAME HERE
        $updateSql = "UPDATE quizzes_tb SET status = 'published', updated_at = NOW() WHERE quiz_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $quiz_id);
        
        if ($updateStmt->execute()) {
            return ['success' => true, 'message' => 'Quiz published successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to publish quiz: ' . $conn->error];
        }
    } catch (Exception $e) {
        error_log("Error publishing quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while publishing the quiz: ' . $e->getMessage()];
    }
}

/**
 * Unpublish a quiz
 * 
 * @param object $conn Database connection
 * @return array Response array with success status and message
 */
function unpublishQuiz($conn) {
    try {
        if (!isset($_POST['quiz_id']) || empty($_POST['quiz_id'])) {
            return ['success' => false, 'message' => 'Quiz ID is required'];
        }

        $quiz_id = intval($_POST['quiz_id']);
        $teacher_id = $_SESSION['user_id'];
        
        // Verify the quiz belongs to this teacher
        $checkSql = "SELECT q.quiz_id FROM quizzes_tb q 
                    JOIN teacher_classes_tb c ON q.class_id = c.class_id 
                    WHERE q.quiz_id = ? AND q.th_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("is", $quiz_id, $teacher_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'You do not have permission to modify this quiz'];
        }
        
        // Update quiz status to draft - FIXED TABLE NAME HERE
        $updateSql = "UPDATE quizzes_tb SET status = 'draft', updated_at = NOW() WHERE quiz_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $quiz_id);
        
        if ($updateStmt->execute()) {
            return ['success' => true, 'message' => 'Quiz unpublished successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to unpublish quiz: ' . $conn->error];
        }
    } catch (Exception $e) {
        error_log("Error unpublishing quiz: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred while unpublishing the quiz: ' . $e->getMessage()];
    }
}
?>