<?php
include '../../Functions/studentDashboardFunction.php';

$allMaterials = [];
if (!empty($classIds)) {
    $materialQuery = "SELECT lm.material_id, lm.material_title, lm.class_id, lm.upload_date, tc.class_name
                      FROM learning_materials_tb lm
                      JOIN teacher_classes_tb tc ON lm.class_id = tc.class_id
                      WHERE lm.class_id IN ($classIdsStr)
                      ORDER BY lm.upload_date DESC";
    $materialResult = $conn->query($materialQuery);
    while ($material = $materialResult->fetch_assoc()) {
        $allMaterials[] = $material;
    }
}

// Pagination logic
$itemsPerPage = 15;
$totalItems = count($allMaterials);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedMaterials = array_slice($allMaterials, $startIndex, $itemsPerPage);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Materials</title>
        <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .material-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .material-card:hover {
            box-shadow: 0 8px 24px 0 rgba(253, 224, 71, 0.10), 0 1.5px 4px 0 rgba(0, 0, 0, 0.04);
            transform: translateY(-2px) scale(1.01);
            background: #fefce8;
        }
        .search-bar:focus {
            border-color: #eab308;
            box-shadow: 0 0 0 2px #fde04733;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">
    <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <a href="../Dashboard/studentDashboard.php"
               class="inline-flex items-center text-yellow-600 hover:text-yellow-800 transition-colors duration-200 font-medium bg-white hover:bg-yellow-50 px-4 py-2 rounded-lg shadow-sm border border-yellow-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="h-1 bg-yellow-400"></div>
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-file-alt text-2xl text-yellow-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Materials
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all learning materials from your enrolled classes. Use the search bar to quickly find a material.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="materialSearch" placeholder="Search materials..." class="search-bar w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-200 transition" />
        </div>

        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if ($totalItems): ?>
                <ul id="materialList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                        $today = date('Y-m-d');
                        foreach ($paginatedMaterials as $material): 
                        $isNewToday = (date('Y-m-d', strtotime($material['upload_date'])) === $today);
                    ?>
                        <li>
                            <a href="../Pages/classDetails.php?class_id=<?php echo $material['class_id']; ?>#material-<?php echo $material['material_id']; ?>"
                               class="material-card flex items-center gap-4 bg-white hover:bg-gray-100 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-yellow-100 shadow-sm h-full">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-file-alt text-yellow-500 text-2xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-lg font-semibold text-gray-800 group-hover:text-yellow-700 transition-colors duration-200 truncate flex items-center gap-2">
                                        <?php echo htmlspecialchars($material['material_title']); ?>
                                        <?php if ($isNewToday): ?>
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700 ml-2">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 truncate">
                                        <?php echo htmlspecialchars($material['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($material['upload_date'])); ?>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600 transition-colors duration-200 ml-auto"></i>
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
                        <span><?php echo $totalItems; ?> total materials</span>
                    </div>
                    <!-- Pagination Controls -->
                    <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
                        <!-- Previous Page -->
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>"
                               class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors duration-150 ease-in-out">
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
                                <a href="?page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
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
                                    <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-yellow-100 text-sm font-bold text-yellow-700">
                                        <?php echo $i; ?>
                                    </span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
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
                                <a href="?page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors">
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
                               class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition-colors duration-150 ease-in-out">
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
                    <i class="fas fa-file-alt text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No materials found.</div>
                    <p class="mt-2 text-gray-500 text-sm">It looks like there are no learning materials available for your classes yet.</p>
                </div>
            <?php endif; ?>
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
    document.getElementById('materialSearch').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        document.querySelectorAll('#materialList li').forEach(function(li) {
            var text = li.textContent.toLowerCase();
            li.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>