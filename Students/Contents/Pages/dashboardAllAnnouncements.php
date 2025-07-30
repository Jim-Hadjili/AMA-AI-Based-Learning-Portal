<?php
include '../../Functions/studentDashboardFunction.php';

// Get filter/sort from GET (default values)
$classFilter = isset($_GET['class_id_filter']) ? $_GET['class_id_filter'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Fetch all classes for dropdown
$classList = [];
if (!empty($classIds)) {
    $classQuery = "SELECT class_id, class_name FROM teacher_classes_tb WHERE class_id IN ($classIdsStr)";
    $classResult = $conn->query($classQuery);
    while ($row = $classResult->fetch_assoc()) {
        $classList[] = $row;
    }
}

// Fetch announcements
$allAnnouncements = [];
if (!empty($classIds)) {
    $announcementQuery = "SELECT a.announcement_id, a.title, a.class_id, a.created_at, tc.class_name
                          FROM announcements_tb a
                          JOIN teacher_classes_tb tc ON a.class_id = tc.class_id
                          WHERE a.class_id IN ($classIdsStr)";
    if ($classFilter && $classFilter !== 'all') {
        $announcementQuery .= " AND a.class_id = " . intval($classFilter);
    }
    $announcementQuery .= " ORDER BY a.created_at DESC";
    $announcementResult = $conn->query($announcementQuery);
    while ($announcement = $announcementResult->fetch_assoc()) {
        $allAnnouncements[] = $announcement;
    }
}

// Sort
if ($sort && $sort !== 'all') {
    usort($allAnnouncements, function ($a, $b) use ($sort) {
        if ($sort === 'oldest') return strtotime($a['created_at']) - strtotime($b['created_at']);
        if ($sort === 'newest') return strtotime($b['created_at']) - strtotime($a['created_at']);
        if ($sort === 'az') return strcmp(strtolower($a['title']), strtolower($b['title']));
        if ($sort === 'za') return strcmp(strtolower($b['title']), strtolower($a['title']));
        return 0;
    });
}

// Pagination logic
$itemsPerPage = 15;
$totalItems = count($allAnnouncements);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedAnnouncements = array_slice($allAnnouncements, $startIndex, $itemsPerPage);
?>


<!DOCTYPE html>

<html>

<head>
    <title>All Announcements</title>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .announcement-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .announcement-card:hover {
            box-shadow: 0 8px 24px 0 rgba(239, 68, 68, 0.10), 0 1.5px 4px 0 rgba(0, 0, 0, 0.04);
            transform: translateY(-2px) scale(1.01);
            background: #fef2f2;
        }

        .search-bar:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px #ef444433;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <?php include '../Dashboard/dashboardAnnouncementIncludes/dashboardAnnouncementBreadcrumb.php'; ?>

        <!-- Header Section -->
        <?php include '../Dashboard/dashboardAnnouncementIncludes/dashboardAnnouncementHeader.php'; ?>

        <!-- Filter Bar -->
        <?php include '../Dashboard/dashboardAnnouncementIncludes/dashboardAnnouncementSearchFilter.php'; ?>

        <!-- Announcement List -->
        <?php include '../Dashboard/dashboardAnnouncementIncludes/dashboardAnnouncementList.php'; ?>

    </div>

    <?php include '../Modals/openContentModal.php'  ?>

</body>
</html>

<script src="../Dashboard/dashboardAnnouncementIncludes/dashboardAnnouncementScript.js"></script>