<?php
session_start();
include_once '../../../Connection/conn.php';

// Check login
if (!isset($_SESSION['user_id']) || $_SESSION['user_position'] !== 'student') {
    header("Location: ../../Auth/login.php");
    exit;
}

$quiz_id = $_GET['quiz_id'] ?? null;
$student_id = $_SESSION['st_id'] ?? null;

if (!$quiz_id || !$student_id) {
    echo "Invalid request.";
    exit;
}

// Fetch quiz info
$quizStmt = $conn->prepare("SELECT quiz_title FROM quizzes_tb WHERE quiz_id = ?");
$quizStmt->bind_param("i", $quiz_id);
$quizStmt->execute();
$quizRes = $quizStmt->get_result();
$quiz = $quizRes->fetch_assoc();

// Fetch attempts
$stmt = $conn->prepare("SELECT attempt_id, start_time, end_time, score, result, status FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? ORDER BY attempt_id DESC");
$stmt->bind_param("is", $quiz_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();
$attempts = [];
while ($row = $result->fetch_assoc()) {
    $attempts[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Attempts - <?php echo htmlspecialchars($quiz['quiz_title'] ?? 'Quiz'); ?></title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6 text-gray-900">Quiz Attempts: <?php echo htmlspecialchars($quiz['quiz_title']); ?></h1>
        <?php if (empty($attempts)): ?>
            <div class="bg-white p-6 rounded-xl shadow text-center text-gray-500">No attempts yet.</div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($attempts as $i => $attempt): ?>
                    <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between hover:bg-blue-50 cursor-pointer transition"
                        onclick="window.location.href='quizResult.php?attempt_id=<?php echo $attempt['attempt_id']; ?>'">
                        <div>
                            <div class="font-semibold text-gray-800">Attempt #<?php echo count($attempts) - $i; ?></div>
                            <div class="text-sm text-gray-500">
                                <?php echo date('M d, Y h:i A', strtotime($attempt['start_time'])); ?>
                            </div>
                        </div>
                        <div>
                            <span class="text-lg font-bold text-blue-700"><?php echo $attempt['score'] ?? 0; ?></span>
                            <span class="ml-2 text-sm <?php echo $attempt['result'] === 'passed' ? 'text-emerald-600' : 'text-red-500'; ?>">
                                <?php echo ucfirst($attempt['result'] ?? $attempt['status']); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <a href="classDetails.php?class_id=<?php echo $_GET['class_id'] ?? ''; ?>" class="inline-block mt-8 text-blue-600 hover:underline">&larr; Back to Class</a>
    </div>
</body>
</html>