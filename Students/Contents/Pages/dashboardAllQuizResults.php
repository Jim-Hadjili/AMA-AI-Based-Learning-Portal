<?php
include '../../Functions/studentDashboardFunction.php';

$allQuizResults = [];
if (!empty($classIds)) {
    $studentId = $_SESSION['st_id'] ?? null;
    $quizResultsQuery = "
        SELECT
            qa.quiz_id,
            q.class_id,
            MAX(qa.score) AS score,
            qa.result,
            MAX(qa.end_time) AS end_time,
            MAX(qa.attempt_id) AS attempt_id,
            q.quiz_title,
            tc.class_name,
            (SELECT SUM(qq.question_points) FROM quiz_questions_tb qq WHERE qq.quiz_id = q.quiz_id) AS total_points
        FROM quiz_attempts_tb qa
        JOIN quizzes_tb q ON qa.quiz_id = q.quiz_id
        JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
        WHERE qa.st_id = ? AND q.class_id IN ($classIdsStr) AND qa.result = 'passed'
        GROUP BY qa.quiz_id, q.class_id, qa.result, q.quiz_title, tc.class_name
        ORDER BY attempt_id DESC
    ";
    $stmt = $conn->prepare($quizResultsQuery);
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $allQuizResults[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Quiz Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            border-color: #16a34a;
            box-shadow: 0 0 0 2px #16a34a33;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <a href="../Dashboard/studentDashboard.php"
                class="inline-flex items-center text-green-600 hover:text-green-800 transition-colors duration-200 font-medium bg-white hover:bg-green-50 px-4 py-2 rounded-lg shadow-sm border border-green-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="h-1 bg-green-500"></div>
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">
                        <i class="fas fa-poll text-2xl text-green-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Passed Quiz Results
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all your passed quiz attempts from your enrolled classes. Use the search bar to quickly find a quiz result.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="quizResultSearch" placeholder="Search quiz results..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-200 transition" />
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if (count($allQuizResults)): ?>
                <ul id="quizResultList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                        $today = date('Y-m-d');
                        foreach ($allQuizResults as $attempt): 
                        $isNewToday = (date('Y-m-d', strtotime($attempt['end_time'])) === $today);
                    ?>
                        <li>
                            <a href="../Pages/quizAttempts.php?quiz_id=<?php echo $attempt['quiz_id']; ?>&class_id=<?php echo $attempt['class_id']; ?>"
                               class="quiz-card flex items-center gap-4 bg-white hover:bg-gray-100 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-green-100 shadow-sm h-full">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-poll text-green-500 text-2xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-lg font-semibold text-gray-800 group-hover:text-green-700 transition-colors duration-200 truncate flex items-center gap-2">
                                        <?php echo htmlspecialchars($attempt['quiz_title']); ?>
                                        <?php if ($isNewToday): ?>
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700 ml-2">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 truncate">
                                        <?php
                                            $percentage_score = 0;
                                            $total_points = $attempt['total_points'] ?? 1;
                                            if ($total_points > 0) {
                                                $percentage_score = ($attempt['score'] / $total_points) * 100;
                                            }
                                        ?>
                                        <?php echo htmlspecialchars($attempt['class_name']); ?> &middot;  Score: <span class="font-medium text-gray-700"><?php echo round($percentage_score); ?>%</span>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 transition-colors duration-200 ml-auto"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-poll text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No passed quiz results found.</div>
                    <p class="mt-2 text-gray-500 text-sm">Keep taking quizzes to see your passed results here!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../Modals/openContentModal.php'  ?>
</body>
</html>

<script>
    // Modal logic (same as dashboardAllQuizzes.php)
    document.querySelectorAll(".flex.items-center.gap-4").forEach(function(card) {
        card.addEventListener("click", function(e) {
            if (e.currentTarget.tagName.toLowerCase() !== "a") return;
            e.preventDefault();
            var className = card.querySelector(".text-sm").textContent.split("·")[0].trim();
            var message = "You are about to view content from " + className + " Class" + ".";
            document.getElementById("confirmMessage").textContent = message;
            document.getElementById("confirmModal").classList.remove("hidden");
            var href = card.getAttribute("href");
            document.getElementById("confirmBtn").onclick = function() {
                window.location.href = href;
            };
            document.getElementById("cancelBtn").onclick = function() {
                document.getElementById("confirmModal").classList.add("hidden");
            };
        });
    });

    // Simple search filter
    document.getElementById('quizResultSearch').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        document.querySelectorAll('#quizResultList li').forEach(function(li) {
            var text = li.textContent.toLowerCase();
            li.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
