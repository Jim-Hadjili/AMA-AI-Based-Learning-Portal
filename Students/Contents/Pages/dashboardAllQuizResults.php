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

// Fetch all classes for dropdown
$classList = [];
if (!empty($classIds)) {
    $classQuery = "SELECT class_id, class_name FROM teacher_classes_tb WHERE class_id IN ($classIdsStr)";
    $classResult = $conn->query($classQuery);
    while ($row = $classResult->fetch_assoc()) {
        $classList[] = $row;
    }
}

// Get filter/sort from GET (default values)
$classFilter = isset($_GET['class_id_filter']) ? $_GET['class_id_filter'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Filter by class
if ($classFilter && $classFilter !== 'all') {
    $allQuizResults = array_filter($allQuizResults, function ($q) use ($classFilter) {
        return $q['class_id'] == $classFilter;
    });
}

// Sort
if ($sort && $sort !== 'all') {
    usort($allQuizResults, function ($a, $b) use ($sort) {
        if ($sort === 'oldest') return strtotime($a['end_time']) - strtotime($b['end_time']);
        if ($sort === 'newest') return strtotime($b['end_time']) - strtotime($a['end_time']);
        if ($sort === 'az') return strcmp(strtolower($a['quiz_title']), strtolower($b['quiz_title']));
        if ($sort === 'za') return strcmp(strtolower($b['quiz_title']), strtolower($a['quiz_title']));
        if ($sort === 'class_az') return strcmp(strtolower($a['class_name']), strtolower($b['class_name']));
        if ($sort === 'class_za') return strcmp(strtolower($b['class_name']), strtolower($a['class_name']));
        return 0;
    });
}

// Pagination logic (must be after filtering and sorting)
$itemsPerPage = 15;
$totalItems = count($allQuizResults);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedQuizResults = array_slice($allQuizResults, $startIndex, $itemsPerPage);
?>


<!DOCTYPE html>
<html>

<head>
    <title>All Quiz Results</title>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
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

        <!-- Breadcrumb Navigation -->
        <?php include '../Dashboard/dashboardQuizResultIncludes/dashboardQuizResultBreadcrumb.php'; ?>

        <!-- Header Section -->
        <?php include '../Dashboard/dashboardQuizResultIncludes/dashboardQuizResultHeader.php'; ?>

        <!-- Filter Bar -->
        <?php include '../Dashboard/dashboardQuizResultIncludes/dashboardQuizResultSearchFilter.php'; ?>

        <!-- Quiz Results List -->
        <?php include '../Dashboard/dashboardQuizResultIncludes/dashboardQuizResultList.php'; ?>

    </div>

    <?php include '../Modals/openContentModal.php'  ?>

</body>

</html>

<script src="../Dashboard/dashboardQuizResultIncludes/dashboardQuizResultScript.js"></script>