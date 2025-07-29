<?php
include '../../Functions/studentDashboardFunction.php';

$allQuizzes = [];
if (!empty($classIds)) {
    $quizQuery = "SELECT q.quiz_id, q.quiz_title, q.class_id, q.created_at, tc.class_name
                  FROM quizzes_tb q
                  JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
                  WHERE q.class_id IN ($classIdsStr) AND q.status = 'published'
                  ORDER BY q.created_at DESC";
    $quizResult = $conn->query($quizQuery);
    while ($quiz = $quizResult->fetch_assoc()) {
        $allQuizzes[] = $quiz;
    }
}

// Pagination logic
$itemsPerPage = 15;
$totalItems = count($allQuizzes);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedQuizzes = array_slice($allQuizzes, $startIndex, $itemsPerPage);
?>
<!DOCTYPE html>
<html>

<head>
    <title>All Quizzes</title>
        <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .quiz-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .quiz-card:hover {
            box-shadow: 0 8px 24px 0 rgba(59, 130, 246, 0.10), 0 1.5px 4px 0 rgba(0, 0, 0, 0.04);
            transform: translateY(-2px) scale(1.01);
            background: #f1f5f9;
        }

        .search-bar:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px #2563eb33;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <!-- End Header Section -->

    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">


        <div class="flex items-center justify-between mb-4">
            <a href="../Dashboard/studentDashboard.php"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200 font-medium bg-white hover:bg-blue-50 px-4 py-2 rounded-lg shadow-sm border border-blue-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="h-1 bg-blue-500"></div>
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-2xl text-blue-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Quizzes
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all published quizzes from your enrolled classes. Use the search bar to quickly find a quiz.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="quizSearch" placeholder="Search quizzes..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition" />
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if ($totalItems): ?>
                <ul id="quizList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                        $today = date('Y-m-d');
                        foreach ($paginatedQuizzes as $quiz): 
                        $isNewToday = (date('Y-m-d', strtotime($quiz['created_at'])) === $today);
                    ?>
                        <li>
                            <a href="../Pages/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>#quiz-<?php echo $quiz['quiz_id']; ?>"
                                class="quiz-card flex items-center gap-4 bg-white hover:bg-gray-100 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-blue-100 shadow-sm h-full">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clipboard-list text-blue-500 text-2xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-lg font-semibold text-gray-800 group-hover:text-blue-700 transition-colors duration-200 truncate flex items-center gap-2">
                                        <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                        <?php if ($isNewToday): ?>
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 ml-2">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 truncate">
                                        <?php echo htmlspecialchars($quiz['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($quiz['created_at'])); ?>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors duration-200 ml-auto"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
        </div>

        <!-- Pagination Controls -->
                <?php if ($totalPages > 1): ?>
                <div class="mt-6 flex flex-col items-center">
                    <!-- Page Stats -->
                    <div class="text-sm text-gray-600 mb-3">
                        <span>Showing page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
                        <span class="mx-2">•</span>
                        <span><?php echo $totalItems; ?> total quizzes</span>
                    </div>
                    <!-- Pagination Controls -->
                    <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
                        <!-- Previous Page -->
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>"
                               class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150 ease-in-out">
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
                                <a href="?page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
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
                                    <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-blue-100 text-sm font-bold text-blue-700">
                                        <?php echo $i; ?>
                                    </span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
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
                                <a href="?page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
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
                            <a href="?page=<?php echo $page + 1; ?>"
                               class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150 ease-in-out">
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
            <?php else: ?>
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-clipboard-list text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No quizzes found.</div>
                    <p class="mt-2 text-gray-500 text-sm">It looks like there are no published quizzes available for your classes yet.</p>
                </div>
            <?php endif; ?>
    </div>
    <?php include '../Modals/openContentModal.php'  ?>
</body>

</html>

<script>
    // Modal logic (unchanged)
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
    document.getElementById('quizSearch').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        document.querySelectorAll('#quizList li').forEach(function(li) {
            var text = li.textContent.toLowerCase();
            li.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>