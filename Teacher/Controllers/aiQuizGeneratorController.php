<?php
session_start();
include_once '../../Connection/conn.php';

// Load configuration for AI API
$config = include_once '../../config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
    exit;
}

$teacher_id = $_SESSION['user_id'];
$class_id = $_POST['class_id'] ?? '';
$title = $_POST['ai_quiz_title'] ?? '';
$topic = $_POST['ai_quiz_topic'] ?? '';
$num_questions = intval($_POST['ai_num_questions'] ?? 5);
$difficulty = $_POST['ai_difficulty'] ?? 'medium';
$instructions = $_POST['ai_quiz_instructions'] ?? '';

if (!$class_id || !$title || !$topic || $num_questions < 1) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Build prompt for AI
$prompt = "Generate exactly $num_questions $difficulty quiz questions for high school students on the topic: '$topic'. 
Title: '$title'. Instructions: '$instructions'. 
Use multiple-choice format. Return ONLY the questions in JSON format: [{\"type\": \"multiple-choice\", \"question\": \"...\", \"options\": [\"...\", \"...\", ...], \"answer\": \"...\"}, ...]";

// Prepare API request
$api_url = $config['openrouter']['api_url'];
$headers = [
    "Authorization: Bearer " . $config['openrouter']['api_key'],
    "Content-Type: application/json"
];
$data = [
    "model" => $config['openrouter']['model'],
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

if (empty($questions)) {
    echo json_encode(['success' => false, 'message' => 'AI did not return valid questions.']);
    exit;
}

// Save quiz to DB
$stmt = $conn->prepare("INSERT INTO quizzes_tb (class_id, th_id, quiz_title, quiz_topic, quiz_description, status, quiz_type, allow_retakes) VALUES (?, ?, ?, ?, ?, 'draft', 'manual', 1)");
$stmt->bind_param("issss", $class_id, $teacher_id, $title, $topic, $instructions);
$stmt->execute();
$quiz_id = $conn->insert_id;
$stmt->close();

// Save questions
foreach ($questions as $i => $q) {
    $type_var = isset($q['type']) ? $q['type'] : 'multiple-choice';
    $text_var = isset($q['question']) ? $q['question'] : '';
    $points_var = 1;
    $order_var = $i + 1;

    $stmt_q = $conn->prepare("INSERT INTO quiz_questions_tb (quiz_id, question_type, question_text, question_points, question_order) VALUES (?, ?, ?, ?, ?)");
    $stmt_q->bind_param("issii", $quiz_id, $type_var, $text_var, $points_var, $order_var);
    $stmt_q->execute();
    $question_id = $stmt_q->insert_id;
    $stmt_q->close();

    // Insert options for multiple-choice
    if ($type_var === 'multiple-choice' && isset($q['options']) && is_array($q['options'])) {
        foreach ($q['options'] as $j => $opt) {
            $option_text_var = $opt;
            $is_correct_var = (strcasecmp($opt, $q['answer']) === 0) ? 1 : 0;
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

echo json_encode(['success' => true, 'quiz_id' => $quiz_id]);
exit;