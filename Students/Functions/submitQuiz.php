<?php
session_start();
include_once '../../Assets/Auth/sessionCheck.php';
include_once '../../Connection/conn.php';

// Prevent back button access
preventBackButton();

// Check if user is logged in and is a student
checkUserAccess('student');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../Pages/Student/Dashboard/studentDashboard.php?error=invalid_request");
    exit;
}

$user_id = $_SESSION['user_id'];
$student_id = $_SESSION['st_id'] ?? null;
$quiz_id = $_POST['quiz_id'] ?? null;
$submitted_answers = $_POST['answer'] ?? [];

if (!$student_id || !$quiz_id) {
    header("Location: ../../Pages/Student/Dashboard/studentDashboard.php?error=missing_info");
    exit;
}

$conn->begin_transaction();

try {
    // 1. Find or create a quiz attempt
    $attempt_id = null;
    $check_attempt_sql = "SELECT attempt_id FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? AND status = 'in-progress'";
    $stmt_check_attempt = $conn->prepare($check_attempt_sql);
    $stmt_check_attempt->bind_param("is", $quiz_id, $student_id);
    $stmt_check_attempt->execute();
    $result_check_attempt = $stmt_check_attempt->get_result();

    // Fetch student info from session or DB
    $student_name = $_SESSION['st_userName'] ?? '';
    $student_email = $_SESSION['st_email'] ?? '';
    $grade_level = $_SESSION['grade_level'] ?? '';
    $strand = $_SESSION['strand'] ?? '';
    $student_school_id = $_SESSION['student_id'] ?? ''; // Add this line

    // If not in session, fetch from DB
    if (!$student_name || !$student_email || !$student_school_id) {
        $profile_sql = "SELECT st_userName, st_email, grade_level, strand, student_id FROM students_profiles_tb WHERE st_id = ?";
        $stmt_profile = $conn->prepare($profile_sql);
        $stmt_profile->bind_param("s", $student_id);
        $stmt_profile->execute();
        $result_profile = $stmt_profile->get_result();
        if ($row = $result_profile->fetch_assoc()) {
            $student_name = $row['st_userName'];
            $student_email = $row['st_email'];
            $grade_level = $row['grade_level'];
            $strand = $row['strand'];
            $student_school_id = $row['student_id']; // Add this line
        }
    }

    // Fetch quiz info
    $quiz_info_sql = "SELECT th_id, quiz_title, parent_quiz_id, quiz_type FROM quizzes_tb WHERE quiz_id = ?";
    $stmt_quiz_info = $conn->prepare($quiz_info_sql);
    $stmt_quiz_info->bind_param("i", $quiz_id);
    $stmt_quiz_info->execute();
    $result_quiz_info = $stmt_quiz_info->get_result();
    $quiz_info = $result_quiz_info->fetch_assoc();

    $th_id = $quiz_info['th_id'] ?? '';
    $quiz_title = $quiz_info['quiz_title'] ?? '';
    $parent_quiz_id = $quiz_info['parent_quiz_id'] ?? null;
    $quiz_type = $quiz_info['quiz_type'] ?? 'manual';

    if ($result_check_attempt->num_rows > 0) {
        $attempt_id = $result_check_attempt->fetch_assoc()['attempt_id'];
        // Update existing attempt to completed and set student & quiz info
        $update_attempt_sql = "UPDATE quiz_attempts_tb SET end_time = NOW(), status = 'completed', student_name = ?, student_email = ?, grade_level = ?, strand = ?, student_id = ?, th_id = ?, quiz_title = ?, parent_quiz_id = ?, quiz_type = ? WHERE attempt_id = ?";
        $stmt_update_attempt = $conn->prepare($update_attempt_sql);
        $stmt_update_attempt->bind_param("sssssssssi", $student_name, $student_email, $grade_level, $strand, $student_school_id, $th_id, $quiz_title, $parent_quiz_id, $quiz_type, $attempt_id);
        $stmt_update_attempt->execute();
    } else {
        // Create a new attempt with student & quiz info
        $start_time = date('Y-m-d H:i:s');
        $status = 'completed';
        $insert_attempt_sql = "INSERT INTO quiz_attempts_tb (quiz_id, st_id, start_time, status, student_name, student_email, grade_level, strand, student_id, th_id, quiz_title, parent_quiz_id, quiz_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_attempt = $conn->prepare($insert_attempt_sql);
        $stmt_insert_attempt->bind_param(
            "issssssssssss",
            $quiz_id,
            $student_id,
            $start_time,
            $status,
            $student_name,
            $student_email,
            $grade_level,
            $strand,
            $student_school_id,
            $th_id,
            $quiz_title,
            $parent_quiz_id,
            $quiz_type
        );
        $stmt_insert_attempt->execute();
        $attempt_id = $conn->insert_id;
    }

    if (!$attempt_id) {
        throw new Exception("Failed to create or retrieve quiz attempt.");
    }

    $total_score_awarded = 0;
    $correct_answers_count = 0;

    // 2. Fetch all questions and their correct answers for the quiz
    $questions_data = [];
    $questions_query = "SELECT qq.question_id, qq.question_type, qq.question_points, qq.question_text
                        FROM quiz_questions_tb qq
                        WHERE qq.quiz_id = ?";
    $stmt_questions = $conn->prepare($questions_query);
    $stmt_questions->bind_param("i", $quiz_id);
    $stmt_questions->execute();
    $result_questions = $stmt_questions->get_result();

    while ($question = $result_questions->fetch_assoc()) {
        $question_id = $question['question_id'];
        $question_type = $question['question_type'];
        $question_points = $question['question_points'];
        $correct_answer_data = null;

        if ($question_type === 'multiple-choice' || $question_type === 'checkbox' || $question_type === 'true-false') {
            $options_query = "SELECT option_id, is_correct FROM question_options_tb WHERE question_id = ? AND is_correct = 1";
            $stmt_options = $conn->prepare($options_query);
            $stmt_options->bind_param("i", $question_id);
            $stmt_options->execute();
            $result_options = $stmt_options->get_result();
            $correct_option_ids = [];
            while ($option = $result_options->fetch_assoc()) {
                $correct_option_ids[] = $option['option_id'];
            }
            $correct_answer_data = $correct_option_ids;
        } elseif ($question_type === 'short-answer') {
            $short_answer_query = "SELECT correct_answer, case_sensitive FROM short_answer_tb WHERE question_id = ?";
            $stmt_short_answer = $conn->prepare($short_answer_query);
            $stmt_short_answer->bind_param("i", $question_id);
            $stmt_short_answer->execute();
            $result_short_answer = $stmt_short_answer->get_result();
            $correct_answer_data = $result_short_answer->fetch_assoc();
        }
        $questions_data[$question_id] = [
            'type' => $question_type,
            'points' => $question_points,
            'correct_answer_data' => $correct_answer_data,
            'text' => $question['question_text'] // Store question text for potential future use
        ];
    }

    // 3. Evaluate submitted answers and save them
    foreach ($submitted_answers as $question_id => $student_answer) {
        $question_info = $questions_data[$question_id] ?? null;

        if (!$question_info) {
            continue; // Skip if question info not found (e.g., invalid question_id)
        }

        $is_correct = 0;
        $points_awarded = 0;
        $selected_options_str = null;
        $text_answer_str = null;

        switch ($question_info['type']) {
            case 'multiple-choice':
            case 'true-false':
                $selected_options_str = htmlspecialchars($student_answer);
                $correct_option_id = $question_info['correct_answer_data'][0] ?? null; // Assuming one correct option
                if ($correct_option_id !== null && (string)$student_answer === (string)$correct_option_id) {
                    $is_correct = 1;
                    $points_awarded = $question_info['points'];
                }
                break;
            case 'checkbox':
                // Ensure student_answer is an array
                $student_selected_options = is_array($student_answer) ? array_map('htmlspecialchars', $student_answer) : [];
                $correct_option_ids = $question_info['correct_answer_data'];

                // Sort both arrays for accurate comparison
                sort($student_selected_options);
                sort($correct_option_ids);

                $selected_options_str = implode(',', $student_selected_options);

                if (count($student_selected_options) === count($correct_option_ids) && $student_selected_options == $correct_option_ids) {
                    $is_correct = 1;
                    $points_awarded = $question_info['points'];
                }
                break;
            case 'short-answer':
                $text_answer_str = htmlspecialchars(trim($student_answer));
                $correct_answer_info = $question_info['correct_answer_data'];
                $correct_text = trim($correct_answer_info['correct_answer']);
                $case_sensitive = $correct_answer_info['case_sensitive'];

                if ($case_sensitive) {
                    if ($text_answer_str === $correct_text) {
                        $is_correct = 1;
                        $points_awarded = $question_info['points'];
                    }
                } else {
                    if (strtolower($text_answer_str) === strtolower($correct_text)) {
                        $is_correct = 1;
                        $points_awarded = $question_info['points'];
                    }
                }
                break;
        }

        if ($is_correct) {
            $correct_answers_count++;
        }
        $total_score_awarded += $points_awarded;

        // Insert/Update student_answers_tb
        // First, check if an answer for this question and attempt already exists (e.g., if user refreshed or navigated back)
        $check_answer_sql = "SELECT answer_id FROM student_answers_tb WHERE attempt_id = ? AND question_id = ?";
        $stmt_check_answer = $conn->prepare($check_answer_sql);
        $stmt_check_answer->bind_param("ii", $attempt_id, $question_id);
        $stmt_check_answer->execute();
        $result_check_answer = $stmt_check_answer->get_result();

        if ($result_check_answer->num_rows > 0) {
            // Update existing answer
            $update_answer_sql = "UPDATE student_answers_tb SET selected_options = ?, text_answer = ?, is_correct = ?, points_awarded = ?, answered_at = NOW() WHERE attempt_id = ? AND question_id = ?";
            $stmt_save_answer = $conn->prepare($update_answer_sql);
            $stmt_save_answer->bind_param("ssiisi", $selected_options_str, $text_answer_str, $is_correct, $points_awarded, $attempt_id, $question_id);
        } else {
            // Insert new answer
            $insert_answer_sql = "INSERT INTO student_answers_tb (attempt_id, question_id, selected_options, text_answer, is_correct, points_awarded, answered_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt_save_answer = $conn->prepare($insert_answer_sql);
            $stmt_save_answer->bind_param("iissii", $attempt_id, $question_id, $selected_options_str, $text_answer_str, $is_correct, $points_awarded);
        }
        $stmt_save_answer->execute();
    }

    // 4. Update the total score in quiz_attempts_tb and set pass/fail result
    // Fetch total possible score for the quiz
    $total_possible_score = 0;
    foreach ($questions_data as $q) {
        $total_possible_score += $q['points'];
    }

    // Set passing threshold (e.g., 60%)
    $passing_percentage = 0.6;
    $passed = ($total_possible_score > 0 && ($total_score_awarded / $total_possible_score) >= $passing_percentage) ? 'passed' : 'failed';

    $update_total_score_sql = "UPDATE quiz_attempts_tb SET score = ?, result = ? WHERE attempt_id = ?";
    $stmt_update_total_score = $conn->prepare($update_total_score_sql);
    $stmt_update_total_score->bind_param("dsi", $total_score_awarded, $passed, $attempt_id);
    $stmt_update_total_score->execute();

    $conn->commit();
    header("Location: ../../Students/Contents/Pages/quizResult.php?attempt_id=" . $attempt_id);
    exit;

} catch (Exception $e) {
    $conn->rollback();
    error_log("Quiz submission error: " . $e->getMessage());
    header("Location: ../../Pages/Student/Dashboard/studentDashboard.php?error=submission_failed");
    exit;
} finally {
    $conn->close();
}
?>
