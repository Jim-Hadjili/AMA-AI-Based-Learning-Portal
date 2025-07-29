<?php
include '../../Functions/studentDashboardFunction.php';

$allAnnouncements = [];
if (!empty($classIds)) {
    $announcementQuery = "SELECT a.announcement_id, a.title, a.class_id, a.created_at, tc.class_name
                          FROM announcements_tb a
                          JOIN teacher_classes_tb tc ON a.class_id = tc.class_id
                          WHERE a.class_id IN ($classIdsStr)
                          ORDER BY a.created_at DESC";
    $announcementResult = $conn->query($announcementQuery);
    while ($announcement = $announcementResult->fetch_assoc()) {
        $allAnnouncements[] = $announcement;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .announcement-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .announcement-card:hover {
            box-shadow: 0 8px 24px 0 rgba(239, 68, 68, 0.10), 0 1.5px 4px 0 rgba(0,0,0,0.04);
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
        <div class="flex items-center justify-between mb-4">
            <a href="../Dashboard/studentDashboard.php"
               class="inline-flex items-center text-red-600 hover:text-red-800 transition-colors duration-200 font-medium bg-white hover:bg-red-50 px-4 py-2 rounded-lg shadow-sm border border-red-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="h-1 bg-red-500"></div>
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fas fa-bullhorn text-2xl text-red-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Announcements
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all announcements from your enrolled classes. Use the search bar to quickly find an announcement.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="announcementSearch" placeholder="Search announcements..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-200 transition" />
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if (count($allAnnouncements)): ?>
                <ul id="announcementList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                        $today = date('Y-m-d');
                        foreach ($allAnnouncements as $announcement): 
                        $isNewToday = (date('Y-m-d', strtotime($announcement['created_at'])) === $today);
                    ?>
                        <li>
                            <a href="../Pages/classDetails.php?class_id=<?php echo $announcement['class_id']; ?>#announcement-<?php echo $announcement['announcement_id']; ?>"
                               class="announcement-card flex items-center gap-4 bg-white hover:bg-gray-100 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-red-100 shadow-sm h-full">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-bullhorn text-red-500 text-2xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-lg font-semibold text-gray-800 group-hover:text-red-700 transition-colors duration-200 truncate flex items-center gap-2">
                                        <?php echo htmlspecialchars($announcement['title']); ?>
                                        <?php if ($isNewToday): ?>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 ml-2">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 truncate">
                                        <?php echo htmlspecialchars($announcement['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600 transition-colors duration-200 ml-auto"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-bullhorn text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No announcements found.</div>
                    <p class="mt-2 text-gray-500 text-sm">It looks like there are no announcements available for your classes yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../Modals/openContentModal.php'  ?>
</body>
</html>

<script>
    // Modal logic (same as other dashboards)
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
    document.getElementById('announcementSearch').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        document.querySelectorAll('#announcementList li').forEach(function(li) {
            var text = li.textContent.toLowerCase();
            li.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>