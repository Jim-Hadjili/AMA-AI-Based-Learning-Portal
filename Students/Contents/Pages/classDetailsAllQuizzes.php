<?php
include "../../Functions/classDetailsFunction.php";

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
} else {
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
                    WHERE q.class_id = ? AND q.status = 'published'
                    ORDER BY q.created_at DESC";
}
$allQuizStmt = $conn->prepare($allQuizQuery);
$allQuizStmt->bind_param("i", $class_id);
$allQuizStmt->execute();
$allQuizResult = $allQuizStmt->get_result();
$allQuizzes = [];
while ($quiz = $allQuizResult->fetch_assoc()) {
    // For students, fetch their latest attempt for this quiz
    if ($user_position === 'student') {
        $attemptStmt = $conn->prepare(
            "SELECT attempt_id, result, score FROM quiz_attempts_tb WHERE quiz_id = ? AND st_id = ? AND status = 'completed' ORDER BY attempt_id DESC LIMIT 1"
        );
        $attemptStmt->bind_param("is", $quiz['quiz_id'], $student_id);
        $attemptStmt->execute();
        $attemptRes = $attemptStmt->get_result();
        $attempt = $attemptRes->fetch_assoc();
        $quiz['student_attempt'] = $attempt ?: null;
    }
    $allQuizzes[] = $quiz;
}

// --- FILTER LOGIC ---
$status = isset($_GET['status']) ? $_GET['status'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$timeLimit = isset($_GET['timeLimit']) ? $_GET['timeLimit'] : '';

// Filter by status
if ($status && $status !== 'all') {
    $allQuizzes = array_filter($allQuizzes, function($q) use ($status) {
        return $q['status'] === $status;
    });
}

// Filter by time limit
if ($timeLimit && $timeLimit !== 'all') {
    $allQuizzes = array_filter($allQuizzes, function($q) use ($timeLimit) {
        if ($timeLimit === 'timed') return intval($q['time_limit']) > 0;
        if ($timeLimit === 'none') return intval($q['time_limit']) === 0;
        return true;
    });
}

// Sort
usort($allQuizzes, function($a, $b) use ($sort) {
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
    <div class="max-w-8xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <a href="classDetails.php?class_id=<?php echo urlencode($class_id); ?>"
                class="inline-flex items-center text-emerald-600 hover:text-emerald-800 transition-colors duration-200 font-medium bg-white hover:bg-emerald-50 px-4 py-2 rounded-lg shadow-sm border border-emerald-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Class
            </a>
        </div>
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="h-1 bg-emerald-500"></div>
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-2xl text-emerald-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Quizzes for <?php echo htmlspecialchars($classDetails['class_name']); ?>
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all quizzes for this class. Use the search bar to quickly find a quiz.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter Bar -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
            <form id="filterForm" method="get" class="flex gap-2 flex-wrap w-full">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
                <input type="hidden" name="page" value="1">
                <select name="status" id="quizStatus" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" <?php if($status==''||$status=='all') echo 'selected'; ?>>All Status</option>
                    <option value="published" <?php if($status=='published') echo 'selected'; ?>>Published</option>
                    <option value="draft" <?php if($status=='draft') echo 'selected'; ?>>Draft</option>
                </select>
                <select name="timeLimit" id="quizTimeLimit" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" <?php if($timeLimit==''||$timeLimit=='all') echo 'selected'; ?>>All Time Limits</option>
                    <option value="timed" <?php if($timeLimit=='timed') echo 'selected'; ?>>Timed Only</option>
                    <option value="none" <?php if($timeLimit=='none') echo 'selected'; ?>>No Time Limit</option>
                </select>
                <select name="sort" id="sortQuizzes" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" <?php if($sort==''||$sort=='all') echo 'selected'; ?>>All</option>
                    <option value="newest" <?php if($sort=='newest') echo 'selected'; ?>>Newest to Oldest</option>
                    <option value="oldest" <?php if($sort=='oldest') echo 'selected'; ?>>Oldest to Newest</option>
                    <option value="az" <?php if($sort=='az') echo 'selected'; ?>>A - Z (Title)</option>
                    <option value="za" <?php if($sort=='za') echo 'selected'; ?>>Z - A (Title)</option>
                </select>
            </form>
        </div>
        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="quizSearch" placeholder="Search quizzes..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-200 transition" />
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if (empty($paginatedQuizzes)): ?>
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-clipboard-list text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No quizzes found for this class.</div>
                    <p class="mt-2 text-gray-500 text-sm">It looks like there are no quizzes available for this class yet.</p>
                </div>
            <?php else: ?>
                <ul id="quizList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($paginatedQuizzes as $quiz): ?>
                        <li>
                            <div class="quiz-card flex flex-col h-full bg-white hover:bg-emerald-50 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-emerald-400 shadow-sm cursor-pointer"
                                onclick="showQuizDetailsModal(<?php echo htmlspecialchars(json_encode($quiz)); ?>)"
                                data-student-attempt='<?php echo htmlspecialchars(json_encode($quiz['student_attempt'] ?? null)); ?>'>
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-clipboard-list text-emerald-500 text-xl"></i>
                                    <span class="text-xs text-gray-400"><?php echo date('M d, Y', strtotime($quiz['created_at'])); ?></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-lg font-semibold text-gray-800 group-hover:text-emerald-700 transition-colors duration-200 truncate">
                                        <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 truncate">
                                        <?php echo htmlspecialchars(substr($quiz['quiz_description'] ?? 'No description', 0, 100)) . (strlen($quiz['quiz_description'] ?? '') > 100 ? '...' : ''); ?>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 text-xs mt-3">
                                    <div class="flex items-center gap-1 text-gray-600 bg-white px-2 py-1 rounded-lg">
                                        <i class="fas fa-clock text-emerald-400"></i>
                                        <span><?php echo $quiz['time_limit']; ?> min</span>
                                    </div>
                                    <span class="px-3 py-1 rounded-full font-medium <?php echo $quiz['status'] === 'published' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200'; ?>">
                                        <?php echo ucfirst($quiz['status']); ?>
                                    </span>
                                    <span class="px-3 py-1 rounded-full font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        <?php echo $quiz['total_questions'] ?? 0; ?> Questions
                                    </span>
                                    <span class="px-3 py-1 rounded-full font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        <?php echo $quiz['total_score'] ?? 0; ?> Points
                                    </span>
                                </div>
                                <?php if ($user_position === 'student' && !empty($quiz['student_attempt'])): ?>
                                    <div class="mt-3 text-xs text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">
                                        Last Attempt: <?php echo htmlspecialchars($quiz['student_attempt']['result']); ?> (<?php echo $quiz['student_attempt']['score']; ?> pts)
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
        </div>

        <!-- Pagination Controls -->
                <?php if ($totalPages > 1): ?>
                    <div class="mt-6 flex flex-col items-center">
                        <div class="text-sm text-gray-600 mb-3">
                            <span>Showing page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
                            <span class="mx-2">•</span>
                            <span><?php echo $totalItems; ?> total quizzes</span>
                        </div>
                        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
                            <!-- Previous Page -->
                            <?php if ($page > 1): ?>
                                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page - 1; ?>"
                                   class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-150 ease-in-out">
                                    <i class="fas fa-chevron-left mr-2 text-xs"></i>
                                    <span>Previous</span>
                                </a>
                            <?php else: ?>
                                <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed">
                                    <i class="fas fa-chevron-left mr-2 text-xs"></i>
                                    <span>Previous</span>
                                </span>
                            <?php endif; ?>

                            <!-- Page Numbers - Desktop View -->
                            <div class="hidden md:flex">
                                <?php
                                $startPage = max(1, min($page - 2, $totalPages - 4));
                                $endPage = min($totalPages, max(5, $page + 2));
                                if ($startPage > 1): ?>
                                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                        1
                                    </a>
                                    <?php if ($startPage > 2): ?>
                                        <span class="relative inline-flex items-center px-3 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-500">
                                            <span class="text-gray-400">•••</span>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-emerald-100 text-sm font-bold text-emerald-700">
                                            <?php echo $i; ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($endPage < $totalPages): ?>
                                    <?php if ($endPage < $totalPages - 1): ?>
                                        <span class="relative inline-flex items-center px-3 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-500">
                                            <span class="text-gray-400">•••</span>
                                        </span>
                                    <?php endif; ?>
                                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                        <?php echo $totalPages; ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Compact Mobile View -->
                            <div class="md:hidden flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm">
                                <span class="font-medium text-gray-700">Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
                            </div>

                            <!-- Next Page -->
                            <?php if ($page < $totalPages): ?>
                                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page + 1; ?>"
                                   class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors duration-150 ease-in-out">
                                    <span>Next</span>
                                    <i class="fas fa-chevron-right ml-2 text-xs"></i>
                                </a>
                            <?php else: ?>
                                <span class="relative inline-flex items-center px-4 py-2.5 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed">
                                    <span>Next</span>
                                    <i class="fas fa-chevron-right ml-2 text-xs"></i>
                                </span>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
    </div>
    <?php include "../Modals/quizDetailsModal.php" ?>
    <script src="../../Assets/Scripts/classDetailsModals.js"></script>
    <script>
        // Simple search filter
        document.getElementById('quizSearch').addEventListener('input', function() {
            var filter = this.value.toLowerCase();
            document.querySelectorAll('#quizList li').forEach(function(li) {
                var text = li.textContent.toLowerCase();
                li.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>