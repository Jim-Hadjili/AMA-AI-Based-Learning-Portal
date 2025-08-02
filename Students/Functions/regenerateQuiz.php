<?php
session_start();
include_once '../../Connection/conn.php';

$quiz_id = $_GET['quiz_id'] ?? null;
$student_id = $_SESSION['st_id'] ?? null;

if (!$quiz_id || !$student_id) {
    header("Location: ../Dashboard/studentDashboard.php?error=missing_info");
    exit;
}

// Fetch quiz topic/objectives
$stmt = $conn->prepare("SELECT quiz_title, quiz_topic, quiz_description FROM quizzes_tb WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();

$topic = $quiz['quiz_topic'] ?: $quiz['quiz_title'];
$description = $quiz['quiz_description'];

// Prepare prompt for AI
$prompt = "Generate 10 quiz questions for high school students on the topic: '$topic'. Each question should match the difficulty and style of: $description. Use a mix of multiple-choice and short-answer formats. Do not repeat questions from previous attempts. Return questions in JSON format: [{\"type\": \"multiple-choice\", \"question\": \"...\", \"options\": [\"...\", \"...\", ...], \"answer\": \"...\"}, ...]";

// Call Hugging Face API
$api_url = "https://openrouter.ai/api/v1/chat/completions";
$headers = [
    "Authorization: Bearer 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",
    "Content-Type: application/json"
];
$data = [
    "model" => "mistralai/mistral-7b-instruct",
    "messages" => [
        ["role" => "user", "content" => $prompt]
    ]
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
$ai_content = $result['choices'][0]['message']['content'] ?? '';
preg_match('/\[\s*{.*}\s*\]/s', $ai_content, $matches);
$json_str = $matches[0] ?? '';
$questions = json_decode($json_str, true);

file_put_contents('ai_quiz_debug.txt', $ai_content); // Save raw AI output for inspection

// Check if questions were generated
if (empty($questions)) {
    error_log("AI quiz generation failed. Raw response: " . $ai_content);
    header("Location: ../Dashboard/studentDashboard.php?error=ai_generation_failed");
    exit;
}

// Save new quiz to DB (as a generated quiz)
$new_quiz_title = $quiz['quiz_title'] . " (Regenerated)";
$insert_quiz = $conn->prepare("INSERT INTO quizzes_tb (class_id, th_id, quiz_title, quiz_description, quiz_topic, status, allow_retakes, parent_quiz_id) SELECT class_id, th_id, ?, ?, quiz_topic, 'published', allow_retakes, ? FROM quizzes_tb WHERE quiz_id = ?");
$insert_quiz->bind_param("ssii", $new_quiz_title, $description, $quiz_id, $quiz_id);
$insert_quiz->execute();
$new_quiz_id = $conn->insert_id;

// Save questions
foreach ($questions as $i => $q) {
    // Assign values to variables before binding
    $quiz_id_var = $new_quiz_id;
    $type_var = isset($q['type']) ? $q['type'] : '';
    $text_var = isset($q['question']) ? $q['question'] : '';
    $points_var = 1;
    $order_var = $i + 1;

    // Insert question
    $stmt_q = $conn->prepare("INSERT INTO quiz_questions_tb (quiz_id, question_type, question_text, question_points, question_order) VALUES (?, ?, ?, ?, ?)");
    $stmt_q->bind_param("issii", $quiz_id_var, $type_var, $text_var, $points_var, $order_var);
    $stmt_q->execute();
    $question_id = $conn->insert_id;
    $stmt_q->close();

    // Insert options for multiple-choice
    if ($type_var === 'multiple-choice' && isset($q['options']) && is_array($q['options'])) {
        foreach ($q['options'] as $j => $opt) {
            $option_text_var = $opt;
            $is_correct_var = (strcasecmp($opt, $q['answer']) === 0) ? 1 : 0; // Case-insensitive match
            $option_order_var = $j + 1;

            $stmt_opt = $conn->prepare("INSERT INTO question_options_tb (question_id, option_text, is_correct, option_order) VALUES (?, ?, ?, ?)");
            $stmt_opt->bind_param("isii", $question_id, $option_text_var, $is_correct_var, $option_order_var);
            $stmt_opt->execute();
            $stmt_opt->close();
        }
    }

    // Insert short-answer
    if ($type_var === 'short-answer' && isset($q['answer'])) {
        $correct_answer_var = $q['answer'];
        $stmt_sa = $conn->prepare("INSERT INTO short_answer_tb (question_id, correct_answer) VALUES (?, ?)");
        $stmt_sa->bind_param("is", $question_id, $correct_answer_var);
        $stmt_sa->execute();
        $stmt_sa->close();
    }
}

// Link generated quiz
$stmt_gen = $conn->prepare("INSERT INTO generated_quizzes_tb (quiz_id, original_quiz_id) VALUES (?, ?)");
$stmt_gen->bind_param("ii", $new_quiz_id, $quiz_id);
$stmt_gen->execute();

$conn->close();

// Redirect to new quiz
header("Location: ../Contents/Pages/quizPage.php?quiz_id=" . $new_quiz_id);
exit;
?>
