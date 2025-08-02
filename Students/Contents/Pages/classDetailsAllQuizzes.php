<?php
include "../../Functions/classDetailsFunction.php";

// Class Quizzes Functions

// Redirect if no class_id
if (!$class_id) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Fetch ALL quizzes for this class (respect user role)
if ($user_position === 'teacher') {
    $allQuizQuery = "SELECT 
                        q.quiz_id, 
                        q.quiz_title, 
                        q.quiz_description, 
                        q.status, 
                        q.created_at, 
                        q.time_limit,
                        (SELECT COUNT(qq.question_id) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_questions,
                        (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_score
                    FROM quizzes_tb q 
                    WHERE q.class_id = ? 
                    ORDER BY q.created_at DESC";
    $allQuizStmt = $conn->prepare($allQuizQuery);
    $allQuizStmt->bind_param("i", $class_id);
} else {
    // For students: show only published quizzes, but always use the latest AI-generated version if exists
    $allQuizQuery = "
        SELECT 
            q.quiz_id, 
            q.quiz_title, 
            q.quiz_description, 
            q.status, 
            q.created_at, 
            q.time_limit,
            q.quiz_type,
            q.th_id,
            (SELECT COUNT(qq.question_id) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_questions,
            (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_score
        FROM quizzes_tb q
        WHERE q.class_id = ? AND q.status = 'published' AND q.quiz_type != '1'
        ORDER BY q.created_at DESC
    ";
    $allQuizStmt = $conn->prepare($allQuizQuery);
    $allQuizStmt->bind_param("i", $class_id);
    $allQuizStmt->execute();
    $allQuizResult = $allQuizStmt->get_result();
    $allQuizzes = [];
    while ($quiz = $allQuizResult->fetch_assoc()) {
        $latestQuiz = $quiz;
        $currentQuizId = $quiz['quiz_id'];
        // Traverse AI-generated chain to get the latest version
        while (true) {
            $aiQuery = "
                SELECT * FROM quizzes_tb 
                WHERE parent_quiz_id = ? AND quiz_type = '1'
                ORDER BY created_at DESC LIMIT 1
            ";
            $aiStmt = $conn->prepare($aiQuery);
            $aiStmt->bind_param("i", $currentQuizId);
            $aiStmt->execute();
            $aiResult = $aiStmt->get_result();
            $aiQuiz = $aiResult->fetch_assoc();
            if ($aiQuiz) {
                $latestQuiz = $aiQuiz;
                $currentQuizId = $aiQuiz['quiz_id'];
            } else {
                break;
            }
        }
        // Fetch student's latest attempt for this quiz
        $attemptStmt = $conn->prepare(
            "SELECT attempt_id, result, score FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? AND status = 'completed' ORDER BY attempt_id DESC LIMIT 1"
        );
        $attemptStmt->bind_param("is", $latestQuiz['quiz_id'], $student_id);
        $attemptStmt->execute();
        $attemptRes = $attemptStmt->get_result();
        $attempt = $attemptRes->fetch_assoc();
        $latestQuiz['student_attempt'] = $attempt ?: null;
        $allQuizzes[] = $latestQuiz;
    }
}
// --- FILTER LOGIC ---
$status = isset($_GET['status']) ? $_GET['status'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$timeLimit = isset($_GET['timeLimit']) ? $_GET['timeLimit'] : '';

// Filter by status
if ($status && $status !== 'all') {
    $allQuizzes = array_filter($allQuizzes, function ($q) use ($status) {
        return $q['status'] === $status;
    });
}

// Filter by time limit
if ($timeLimit && $timeLimit !== 'all') {
    $allQuizzes = array_filter($allQuizzes, function ($q) use ($timeLimit) {
        if ($timeLimit === 'timed') return intval($q['time_limit']) > 0;
        if ($timeLimit === 'none') return intval($q['time_limit']) === 0;
        return true;
    });
}

// Sort
usort($allQuizzes, function ($a, $b) use ($sort) {
    if ($sort === '' || $sort === 'all') return 0;
    if ($sort === 'oldest') return strtotime($a['created_at']) - strtotime($b['created_at']);
    if ($sort === 'newest') return strtotime($b['created_at']) - strtotime($a['created_at']);
    if ($sort === 'az') return strcmp(strtolower($a['quiz_title']), strtolower($b['quiz_title']));
    if ($sort === 'za') return strcmp(strtolower($b['quiz_title']), strtolower($a['quiz_title']));
    return 0;
});

// Pagination logic
$itemsPerPage = 15;
$totalItems = count($allQuizzes);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedQuizzes = array_slice($allQuizzes, $startIndex, $itemsPerPage);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Quizzes - <?php echo htmlspecialchars($classDetails['class_name']); ?></title>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <style>
        .quiz-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .quiz-card:hover {
            box-shadow: 0 8px 24px 0 rgba(16, 185, 129, 0.10), 0 1.5px 4px 0 rgba(0, 0, 0, 0.04);
            transform: translateY(-2px) scale(1.01);
            background: #f0fdf4;
        }

        .search-bar:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 2px #10b98133;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <?php include "../Includes/classDetailsIncludes/classDetailsQuizzesIncludes/quizzesBreadcrumb.php" ?>

        <!-- Header Section -->
        <?php include "../Includes/classDetailsIncludes/classDetailsQuizzesIncludes/quizzesHeader.php"; ?>

        <!--Search and Filter Bar -->
        <?php include "../Includes/classDetailsIncludes/classDetailsQuizzesIncludes/quizzesSearchFilter.php" ?>

        <!-- Quizzes List -->
        <?php include "../Includes/classDetailsIncludes/classDetailsQuizzesIncludes/quizzesList.php"; ?>

    </div>

    <?php include "../Modals/quizDetailsModal.php" ?>

    <script src="../Includes/classDetailsIncludes/classDetailsQuizzesIncludes/quizzesScript.js"></script>

</body>
</html>

<script>
    // JavaScript for Quiz Details Modal
function showQuizDetailsModal(quiz) {
  // Get class_id from URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const classId = urlParams.get("class_id");

  // Check if student_attempt exists and is passed
  if (quiz.student_attempt && quiz.student_attempt.result === "passed") {
    // Show the "already passed" modal
    document.getElementById("quizPassedModal").classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
    // Optionally, show score/result info
    document.getElementById("quizPassedScore").textContent =
      quiz.student_attempt.score || "0";
    document.getElementById("quizPassedViewResultBtn").onclick = function () {
      // Redirect to attempts list for this quiz with class_id
      window.location.href = `quizAttempts.php?quiz_id=${quiz.quiz_id}&class_id=${classId}`;
    };
    return;
  }

  document.getElementById("modalQuizTitle").textContent = quiz.quiz_title;
  document.getElementById("modalQuizDescription").textContent =
    quiz.quiz_description || "No description provided.";
  document.getElementById("modalQuizQuestions").textContent =
    quiz.total_questions || "0";
  document.getElementById(
    "modalQuizTimeLimit"
  ).textContent = `${quiz.time_limit} minutes`;
  document.getElementById("modalQuizTotalScore").textContent =
    quiz.total_score || "0";
  document.getElementById("modalQuizStatus").textContent =
    quiz.status.charAt(0).toUpperCase() + quiz.status.slice(1);

  // Set the quiz ID and class ID for the "Take Quiz" button
  document.getElementById("takeQuizBtn").dataset.quizId = quiz.quiz_id;
  document.getElementById("takeQuizBtn").dataset.classId = classId;

  document.getElementById("quizDetailsModal").classList.remove("hidden");
  document.body.classList.add("overflow-hidden");
}

function closeQuizDetailsModal() {
  document.getElementById("quizDetailsModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}

function closeQuizPassedModal() {
  document.getElementById("quizPassedModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}

document
  .getElementById("closeQuizDetailsModal")
  .addEventListener("click", closeQuizDetailsModal);
document
  .getElementById("cancelQuizBtn")
  .addEventListener("click", closeQuizDetailsModal);

// Add event listener for closing quiz passed modal if it exists
const closeQuizPassedModalBtn = document.getElementById("closeQuizPassedModal");
if (closeQuizPassedModalBtn) {
  closeQuizPassedModalBtn.addEventListener("click", closeQuizPassedModal);
}

document
  .getElementById("quizDetailsModal")
  .addEventListener("click", function (e) {
    if (e.target === this) {
      closeQuizDetailsModal();
    }
  });

// Add event listener for quiz passed modal if it exists
const quizPassedModal = document.getElementById("quizPassedModal");
if (quizPassedModal) {
  quizPassedModal.addEventListener("click", function (e) {
    if (e.target === this) {
      closeQuizPassedModal();
    }
  });
}

document.getElementById("takeQuizBtn").addEventListener("click", function () {
  const quizId = this.dataset.quizId;
  const classId = this.dataset.classId;
  if (quizId && classId) {
    // Redirect to the quiz taking page with class_id
    window.location.href = `quizPage.php?quiz_id=${quizId}&class_id=${classId}`;
  }
});
</script>