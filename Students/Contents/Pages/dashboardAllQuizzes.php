<?php
include '../../Functions/studentDashboardFunction.php';

$allQuizzes = [];
if (!empty($classIds)) {
    // Get all original published quizzes for this student's classes
    $baseQuizQuery = "SELECT q.quiz_id, q.quiz_title, q.class_id, q.created_at, tc.class_name, q.quiz_type, q.parent_quiz_id
                  FROM quizzes_tb q
                  JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
                  WHERE q.class_id IN ($classIdsStr) AND q.status = 'published' AND q.quiz_type != '1'
                  ORDER BY q.created_at DESC";
    $baseQuizResult = $conn->query($baseQuizQuery);
    $baseQuizzes = [];
    while ($quiz = $baseQuizResult->fetch_assoc()) {
        $baseQuizzes[] = $quiz;
    }
    
    // Fetch quizzes this student has attempted
    $studentAttemptedQuizzesQuery = "
        SELECT DISTINCT quiz_id FROM quiz_attempts_tb 
        WHERE st_id = ? AND status = 'completed'
    ";
    $attemptedStmt = $conn->prepare($studentAttemptedQuizzesQuery);
    $attemptedStmt->bind_param("s", $studentId);
    $attemptedStmt->execute();
    $attemptedResult = $attemptedStmt->get_result();
    $attemptedQuizIds = [];
    while ($row = $attemptedResult->fetch_assoc()) {
        $attemptedQuizIds[] = $row['quiz_id'];
    }

    // Process each original quiz
    foreach ($baseQuizzes as $baseQuiz) {
        $originalQuizId = $baseQuiz['quiz_id'];
        $quizToShow = $baseQuiz;
        
        // Find all AI-generated versions of this quiz (direct children only)
        $aiVersionsQuery = "
            SELECT q.quiz_id FROM quizzes_tb q
            WHERE q.parent_quiz_id = ? AND q.quiz_type = '1' AND q.status = 'published'
            ORDER BY q.created_at DESC
        ";
        $aiVersionsStmt = $conn->prepare($aiVersionsQuery);
        $aiVersionsStmt->bind_param("i", $originalQuizId);
        $aiVersionsStmt->execute();
        $aiVersionsResult = $aiVersionsStmt->get_result();
        
        $aiVersionIds = [];
        while ($version = $aiVersionsResult->fetch_assoc()) {
            $aiVersionIds[] = $version['quiz_id'];
        }
        
        // Check the entire generation chain for this quiz
        $checkedIds = [$originalQuizId];
        $quizChainIds = $aiVersionIds;
        
        while (!empty($quizChainIds)) {
            $currentId = array_shift($quizChainIds);
            $checkedIds[] = $currentId;
            
            // Find further children
            $childrenQuery = "
                SELECT quiz_id FROM quizzes_tb 
                WHERE parent_quiz_id = ? AND quiz_type = '1' AND status = 'published'
            ";
            $childrenStmt = $conn->prepare($childrenQuery);
            $childrenStmt->bind_param("i", $currentId);
            $childrenStmt->execute();
            $childrenResult = $childrenStmt->get_result();
            
            while ($child = $childrenResult->fetch_assoc()) {
                if (!in_array($child['quiz_id'], $checkedIds)) {
                    $quizChainIds[] = $child['quiz_id'];
                    $aiVersionIds[] = $child['quiz_id'];
                }
            }
        }
        
        // Check if the student has attempted any AI version of this quiz
        $studentAiAttempts = array_intersect($aiVersionIds, $attemptedQuizIds);
        
        if (!empty($studentAiAttempts)) {
            // Student has attempted AI versions, show their latest AI version
            $latestAiQuery = "
                SELECT q.*, tc.class_name FROM quizzes_tb q
                JOIN teacher_classes_tb tc ON q.class_id = tc.class_id
                JOIN quiz_attempts_tb a ON q.quiz_id = a.quiz_id
                WHERE q.quiz_id IN (" . implode(',', array_map('intval', $studentAiAttempts)) . ")
                AND a.st_id = ?
                ORDER BY q.created_at DESC
                LIMIT 1
            ";
            $latestAiStmt = $conn->prepare($latestAiQuery);
            $latestAiStmt->bind_param("s", $studentId);
            $latestAiStmt->execute();
            $latestAiResult = $latestAiStmt->get_result();
            
            if ($latestAiResult->num_rows > 0) {
                $quizToShow = $latestAiResult->fetch_assoc();
            }
        }
        
        $allQuizzes[] = $quizToShow;
    }
}

// Get filter/sort from GET (default values)
$classFilter = isset($_GET['class_id_filter']) ? $_GET['class_id_filter'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Filter by class
if ($classFilter && $classFilter !== 'all') {
    $allQuizzes = array_filter($allQuizzes, function ($q) use ($classFilter) {
        return $q['class_id'] == $classFilter;
    });
}

// Sort
if ($sort && $sort !== 'all') {
    usort($allQuizzes, function ($a, $b) use ($sort) {
        if ($sort === 'oldest') return strtotime($a['created_at']) - strtotime($b['created_at']);
        if ($sort === 'newest') return strtotime($b['created_at']) - strtotime($a['created_at']);
        if ($sort === 'az') return strcmp(strtolower($a['quiz_title']), strtolower($b['quiz_title']));
        if ($sort === 'za') return strcmp(strtolower($b['quiz_title']), strtolower($a['quiz_title']));
        if ($sort === 'class_az') return strcmp(strtolower($a['class_name']), strtolower($b['class_name']));
        if ($sort === 'class_za') return strcmp(strtolower($b['class_name']), strtolower($a['class_name']));
        return 0;
    });
} else {
    // Default sort by newest first
    usort($allQuizzes, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
}

// Pagination logic (must be after filtering and sorting)
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


        <!-- Breadcrumb Navigation -->
        <?php include "../Dashboard/dashboardQuizzesIncludes/dashboardQuizzesBreadcrumb.php" ?>


        <!-- Header Section -->
        <?php include "../Dashboard/dashboardQuizzesIncludes/dashboardQuizzesHeader.php" ?>

        <!-- Search Bar -->
        <?php include "../Dashboard/dashboardQuizzesIncludes/dashboardQuizzesSearchFilter.php" ?>

        <!-- Quizzes List -->
        <?php include "../Dashboard/dashboardQuizzesIncludes/dashboardQuizzesList.php" ?>

    </div>

    <?php include '../Modals/openContentModal.php'  ?>

</body>

</html>

<script src="../Dashboard/dashboardQuizzesIncludes/dashboardQuizzesScript.js"></script>