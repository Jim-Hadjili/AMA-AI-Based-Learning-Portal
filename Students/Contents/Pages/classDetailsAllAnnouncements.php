<?php
include "../../Functions/classDetailsFunction.php";

// classDetailsAllAnnouncementsFunction

if (!$class_id) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Fetch ALL announcements for this class
$allAnnouncementQuery = "SELECT announcement_id, title, content, created_at, is_pinned 
                         FROM announcements_tb 
                         WHERE class_id = ? 
                         ORDER BY is_pinned DESC, created_at DESC";
$allAnnouncementStmt = $conn->prepare($allAnnouncementQuery);
$allAnnouncementStmt->bind_param("i", $class_id);
$allAnnouncementStmt->execute();
$allAnnouncementResult = $allAnnouncementStmt->get_result();
$allAnnouncements = [];
while ($announcement = $allAnnouncementResult->fetch_assoc()) {
    $allAnnouncements[] = $announcement;
}

// Get filter/sort from GET (default values)
$filterPinned = isset($_GET['filterPinned']) ? $_GET['filterPinned'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : ''; // Change 'newest' to ''

// Filter by pinned
if ($filterPinned === 'pinned') {
    $allAnnouncements = array_filter($allAnnouncements, function ($a) {
        return $a['is_pinned'];
    });
} elseif ($filterPinned === 'unpinned') {
    $allAnnouncements = array_filter($allAnnouncements, function ($a) {
        return !$a['is_pinned'];
    });
}

// Sort
usort($allAnnouncements, function ($a, $b) use ($sort) {
    if ($sort === '' || $sort === null) {
        return 0; // No sorting, keep current order
    }
    if ($sort === 'oldest') {
        return strtotime($a['created_at']) - strtotime($b['created_at']);
    } elseif ($sort === 'newest') {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    } elseif ($sort === 'az') {
        return strcmp(strtolower($a['title']), strtolower($b['title']));
    } elseif ($sort === 'za') {
        return strcmp(strtolower($b['title']), strtolower($a['title']));
    }
    return 0;
});

// Pagination logic
$itemsPerPage = 15;
$totalItems = count($allAnnouncements);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedAnnouncements = array_slice($allAnnouncements, $startIndex, $itemsPerPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Announcements - <?php echo htmlspecialchars($classDetails['class_name']); ?></title>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <style>
        .announcement-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .announcement-card:hover {
            box-shadow: 0 8px 24px 0 rgba(251, 191, 36, 0.10), 0 1.5px 4px 0 rgba(0, 0, 0, 0.04);
            transform: translateY(-2px) scale(1.01);
            background: #fff7ed;
        }

        .search-bar:focus {
            border-color: #f59e42;
            box-shadow: 0 0 0 2px #f59e4233;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <div class="max-w-8xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <?php include "../Includes/classDetailsIncludes/classDetailsAnnouncementIncludes/announcementBreadcrumb.php" ?>

        <!-- Header Section -->
        <?php include "../Includes/classDetailsIncludes/classDetailsAnnouncementIncludes/announcementHeader.php" ?>

        <!-- Search & Filter Bar -->
        <?php include "../Includes/classDetailsIncludes/classDetailsAnnouncementIncludes/announcementSearchFilter.php" ?>

        <?php include "../Includes/classDetailsIncludes/classDetailsAnnouncementIncludes/announcementList.php" ?>

    </div>
    <!-- Announcement Modal -->
    <?php include "../Modals/announcementModal.php" ?>

    <!-- Quiz Details Modal -->
    <?php include "../Modals/quizDetailsModal.php" ?>

    <!-- Announcement Modal (reuse your modal) -->
    <script src="../../Assets/Scripts/classDetailsModals.js"></script>

    <!-- Search and filter -->
    <script src="../Includes/classDetailsIncludes/classDetailsAnnouncementIncludes/announcementScript.js"></script>

</body>
</html>