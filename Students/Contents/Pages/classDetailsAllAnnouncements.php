<?php
include "../../Functions/classDetailsFunction.php";

// Redirect if no class_id
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
    $allAnnouncements = array_filter($allAnnouncements, function($a) {
        return $a['is_pinned'];
    });
} elseif ($filterPinned === 'unpinned') {
    $allAnnouncements = array_filter($allAnnouncements, function($a) {
        return !$a['is_pinned'];
    });
}

// Sort
usort($allAnnouncements, function($a, $b) use ($sort) {
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
        <div class="flex items-center justify-between mb-4">
            <a href="classDetails.php?class_id=<?php echo urlencode($class_id); ?>"
                class="inline-flex items-center text-amber-600 hover:text-amber-800 transition-colors duration-200 font-medium bg-white hover:bg-amber-50 px-4 py-2 rounded-lg shadow-sm border border-amber-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Class
            </a>
        </div>
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
           
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">
                        <i class="fas fa-bullhorn text-2xl text-amber-500"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Announcements for <?php echo htmlspecialchars($classDetails['class_name']); ?>
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all announcements for this class. Use the search bar to quickly find an announcement.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search & Filter Bar -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
            <input type="text" id="announcementSearch" placeholder="Search announcements..." class="search-bar w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-200 transition" />

            <form id="filterForm" method="get" class="flex gap-2 flex-wrap">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
                <input type="hidden" name="page" value="1">
                <select name="filterPinned" id="filterPinned" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="" <?php if($filterPinned=='') echo 'selected'; ?>>All</option>
                    <option value="pinned" <?php if($filterPinned=='pinned') echo 'selected'; ?>>Pinned Only</option>
                    <option value="unpinned" <?php if($filterPinned=='unpinned') echo 'selected'; ?>>Unpinned Only</option>
                </select>
                <select name="sort" id="sortAnnouncements" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="" <?php if($sort=='') echo 'selected'; ?>>All</option>
                    <option value="newest" <?php if($sort=='newest') echo 'selected'; ?>>Newest to Oldest</option>
                    <option value="oldest" <?php if($sort=='oldest') echo 'selected'; ?>>Oldest to Newest</option>
                    <option value="az" <?php if($sort=='az') echo 'selected'; ?>>A - Z (Title)</option>
                    <option value="za" <?php if($sort=='za') echo 'selected'; ?>>Z - A (Title)</option>
                </select>
            </form>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if (empty($paginatedAnnouncements)): ?>
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-bullhorn text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No announcements found for this class.</div>
                    <p class="mt-2 text-gray-500 text-sm">It looks like there are no announcements available for this class yet.</p>
                </div>
            <?php else: ?>
                <ul id="announcementList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($paginatedAnnouncements as $announcement): ?>
                        <li data-title="<?php echo htmlspecialchars(strtolower($announcement['title'])); ?>"
                            data-content="<?php echo htmlspecialchars(strtolower($announcement['content'])); ?>"
                            data-date="<?php echo htmlspecialchars($announcement['created_at']); ?>"
                            data-pinned="<?php echo $announcement['is_pinned'] ? 'pinned' : 'unpinned'; ?>">
                            <div class="announcement-card group cursor-pointer relative p-5 border rounded-xl transition-all duration-200
                                <?php echo $announcement['is_pinned'] ? 'border-amber-400 ring-2 ring-amber-200 shadow-lg' : 'border-amber-400 shadow-lg hover:border-amber-600'; ?>"
                                style="background: none;"
                                onclick="showAnnouncementModal(<?php echo htmlspecialchars(json_encode($announcement)); ?>)">
                                <?php if ($announcement['is_pinned']): ?>
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-amber-400 to-orange-400 rounded-l-xl"></div>
                                <?php endif; ?>
                                <div class="flex items-start justify-between <?php echo $announcement['is_pinned'] ? 'pl-3' : ''; ?>">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="font-semibold text-gray-900 truncate group-hover:text-amber-900">
                                                <?php echo htmlspecialchars($announcement['title']); ?>
                                            </h3>
                                            <?php if ($announcement['is_pinned']): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-300 ml-1">
                                                    <i class="fas fa-thumbtack mr-1 text-amber-500"></i> Pinned
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-sm text-gray-800 mt-1 line-clamp-3 break-words mb-3"><?php echo htmlspecialchars(substr($announcement['content'], 0, 150)) . (strlen($announcement['content']) > 150 ? '...' : ''); ?></p>
                                        <div class="flex items-center gap-2 text-xs text-gray-600 bg-white/80 px-2 py-1 rounded-lg w-fit shadow">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span><?php echo date('M j, Y', strtotime($announcement['created_at'])); ?></span>
                                        </div>
                                    </div>
                                    <div class="ml-4 w-10 h-10 rounded-xl bg-white flex items-center justify-center group-hover:bg-amber-100 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </div>
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
                            <span><?php echo $totalItems; ?> total announcements</span>
                        </div>
                        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
                            <!-- Previous Page -->
                            <?php if ($page > 1): ?>
                                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page - 1; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>"
                                   class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors duration-150 ease-in-out">
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
                                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=1&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
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
                                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-amber-100 text-sm font-bold text-amber-700">
                                            <?php echo $i; ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $i; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
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
                                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $totalPages; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors">
                                        <?php echo $totalPages; ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Next Page -->
                            <?php if ($page < $totalPages): ?>
                                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page + 1; ?>&filterPinned=<?php echo urlencode($filterPinned); ?>&sort=<?php echo urlencode($sort); ?>"
                                   class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors duration-150 ease-in-out">
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
    <!-- Announcement Modal -->
    <?php include "../Modals/announcementModal.php" ?>

    <!-- Quiz Details Modal -->
    <?php include "../Modals/quizDetailsModal.php" ?>

    <!-- Announcement Modal (reuse your modal) -->
    <script src="../../Assets/Scripts/classDetailsModals.js"></script>
    <script>
        // Simple search and filter
        function filterAnnouncements() {
            var search = document.getElementById('announcementSearch').value.toLowerCase();
            var pinned = document.getElementById('filterPinned').value;
            var sort = document.getElementById('sortAnnouncements').value;
            var list = document.getElementById('announcementList');
            var items = Array.from(list.querySelectorAll('li'));

            // Filter
            items.forEach(function(li) {
                var title = li.getAttribute('data-title');
                var content = li.getAttribute('data-content');
                var isPinned = li.getAttribute('data-pinned');
                var show = true;
                if (search && !(title.includes(search) || content.includes(search))) show = false;
                if (pinned && isPinned !== pinned) show = false;
                li.style.display = show ? '' : 'none';
            });

            // Sort
            var visibleItems = items.filter(li => li.style.display !== 'none');
            visibleItems.sort(function(a, b) {
                if (sort === 'oldest') {
                    return new Date(a.getAttribute('data-date')) - new Date(b.getAttribute('data-date'));
                } else if (sort === 'newest') {
                    return new Date(b.getAttribute('data-date')) - new Date(a.getAttribute('data-date'));
                } else if (sort === 'az') {
                    return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
                } else if (sort === 'za') {
                    return b.getAttribute('data-title').localeCompare(a.getAttribute('data-title'));
                }
                return 0;
            });
            // Re-append sorted items
            visibleItems.forEach(li => list.appendChild(li));
        }
        document.getElementById('announcementSearch').addEventListener('input', filterAnnouncements);
        document.getElementById('filterPinned').addEventListener('change', filterAnnouncements);
        document.getElementById('sortAnnouncements').addEventListener('change', filterAnnouncements);
    </script>
</body>
</html>

