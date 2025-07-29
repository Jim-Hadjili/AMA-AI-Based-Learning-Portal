<?php
include "../../Functions/classDetailsFunction.php";

// Redirect if no class_id
if (!$class_id) {
    header("Location: ../Dashboard/studentDashboard.php");
    exit;
}

// Fetch ALL materials for this class
$allMaterialQuery = "SELECT material_id, material_title, material_description, file_name, file_type, upload_date 
                     FROM learning_materials_tb 
                     WHERE class_id = ? 
                     ORDER BY upload_date DESC";
$allMaterialStmt = $conn->prepare($allMaterialQuery);
$allMaterialStmt->bind_param("i", $class_id);
$allMaterialStmt->execute();
$allMaterialResult = $allMaterialStmt->get_result();
$allMaterials = [];
while ($material = $allMaterialResult->fetch_assoc()) {
    $allMaterials[] = $material;
}

// --- FILTER LOGIC ---
$fileType = isset($_GET['fileType']) ? $_GET['fileType'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Filter by file type
if ($fileType && $fileType !== 'all') {
    $allMaterials = array_filter($allMaterials, function($m) use ($fileType) {
        $ext = strtolower(pathinfo($m['file_name'], PATHINFO_EXTENSION));
        if ($fileType === 'pdf') return $ext === 'pdf';
        if ($fileType === 'word') return in_array($ext, ['doc', 'docx']);
        if ($fileType === 'ppt') return in_array($ext, ['ppt', 'pptx']);
        if ($fileType === 'excel') return in_array($ext, ['xls', 'xlsx']);
        if ($fileType === 'image') return in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
        if ($fileType === 'video') return in_array($ext, ['mp4', 'mov', 'avi']);
        if ($fileType === 'audio') return in_array($ext, ['mp3', 'wav']);
        return false;
    });
}

// Sort
usort($allMaterials, function($a, $b) use ($sort) {
    if ($sort === '' || $sort === 'all') return 0;
    if ($sort === 'oldest') return strtotime($a['upload_date']) - strtotime($b['upload_date']);
    if ($sort === 'newest') return strtotime($b['upload_date']) - strtotime($a['upload_date']);
    if ($sort === 'az') return strcmp(strtolower($a['material_title']), strtolower($b['material_title']));
    if ($sort === 'za') return strcmp(strtolower($b['material_title']), strtolower($a['material_title']));
    return 0;
});

// Pagination logic
$itemsPerPage = 15;
$totalItems = count($allMaterials);
$totalPages = ceil($totalItems / $itemsPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$startIndex = ($page - 1) * $itemsPerPage;
$paginatedMaterials = array_slice($allMaterials, $startIndex, $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Materials - <?php echo htmlspecialchars($classDetails['class_name']); ?></title>
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <style>
        .material-card {
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .material-card:hover {
            box-shadow: 0 8px 24px 0 rgba(139, 92, 246, 0.10), 0 1.5px 4px 0 rgba(0, 0, 0, 0.04);
            transform: translateY(-2px) scale(1.01);
            background: #f5f3ff;
        }
        .search-bar:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 2px #8b5cf633;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 6px;
            border: 1px solid #ede9fe;
            background: #f5f3ff;
            color: #7c3aed;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .pagination a:hover {
            background: #ede9fe;
            color: #5b21b6;
        }
        .pagination .active {
            background: #7c3aed;
            color: #fff;
            border-color: #7c3aed;
            cursor: default;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">
    <div class="max-w-8xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <a href="classDetails.php?class_id=<?php echo urlencode($class_id); ?>"
                class="inline-flex items-center text-violet-600 hover:text-violet-800 transition-colors duration-200 font-medium bg-white hover:bg-violet-50 px-4 py-2 rounded-lg shadow-sm border border-violet-100">
                <i class="fas fa-arrow-left mr-2"></i> Back to Class
            </a>
        </div>
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">
            <div class="h-1 bg-violet-500"></div>
            <div class="p-8">
                <div class="flex items-center gap-5">
                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-violet-100 flex items-center justify-center">
                        <i class="fas fa-book text-2xl text-violet-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-3xl font-semibold text-gray-900 mb-2 leading-tight">
                            All Materials for <?php echo htmlspecialchars($classDetails['class_name']); ?>
                        </h1>
                        <p class="text-gray-600 text-base leading-relaxed">
                            Browse all learning materials for this class. Use the search bar to quickly find a file.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter Bar -->
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
            <input type="text" id="materialSearch" placeholder="Search materials..." class="search-bar w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-200 transition" />

            <form id="filterForm" method="get" class="flex gap-2 flex-wrap">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id); ?>">
                <input type="hidden" name="page" value="1">
                <select name="fileType" id="fileType" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" <?php if($fileType==''||$fileType=='all') echo 'selected'; ?>>All Types</option>
                    <option value="pdf" <?php if($fileType=='pdf') echo 'selected'; ?>>PDF</option>
                    <option value="word" <?php if($fileType=='word') echo 'selected'; ?>>Word</option>
                    <option value="ppt" <?php if($fileType=='ppt') echo 'selected'; ?>>PowerPoint</option>
                    <option value="excel" <?php if($fileType=='excel') echo 'selected'; ?>>Excel</option>
                    <option value="image" <?php if($fileType=='image') echo 'selected'; ?>>Image</option>
                    <option value="video" <?php if($fileType=='video') echo 'selected'; ?>>Video</option>
                    <option value="audio" <?php if($fileType=='audio') echo 'selected'; ?>>Audio</option>
                </select>
                <select name="sort" id="sortMaterials" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-200" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" <?php if($sort==''||$sort=='all') echo 'selected'; ?>>All</option>
                    <option value="newest" <?php if($sort=='newest') echo 'selected'; ?>>Newest to Oldest</option>
                    <option value="oldest" <?php if($sort=='oldest') echo 'selected'; ?>>Oldest to Newest</option>
                    <option value="az" <?php if($sort=='az') echo 'selected'; ?>>A - Z (Title)</option>
                    <option value="za" <?php if($sort=='za') echo 'selected'; ?>>Z - A (Title)</option>
                </select>
            </form>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8">
            <?php if (empty($paginatedMaterials)): ?>
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-book text-5xl mb-4 text-gray-400"></i>
                    <div class="text-lg font-medium">No materials found for this class.</div>
                    <p class="mt-2 text-gray-500 text-sm">It looks like there are no learning materials available for this class yet.</p>
                </div>
            <?php else: ?>
                <ul id="materialList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($paginatedMaterials as $material): ?>
                        <li>
                            <a href="materialPreview.php?material_id=<?php echo $material['material_id']; ?>"
                                class="material-card flex flex-col h-full bg-white hover:bg-violet-50 rounded-xl p-5 transition-all duration-200 ease-in-out group border border-violet-400 shadow-sm cursor-pointer">
                                <div class="flex items-center gap-3 mb-2">
                                    <?php
                                    $fileTypeIcons = [
                                        'pdf' => 'fa-file-pdf text-red-500',
                                        'doc' => 'fa-file-word text-blue-500',
                                        'docx' => 'fa-file-word text-blue-500',
                                        'ppt' => 'fa-file-powerpoint text-orange-500',
                                        'pptx' => 'fa-file-powerpoint text-orange-500',
                                        'xls' => 'fa-file-excel text-green-500',
                                        'xlsx' => 'fa-file-excel text-green-500',
                                        'image' => 'fa-file-image text-purple-500',
                                        'jpg' => 'fa-file-image text-purple-500',
                                        'jpeg' => 'fa-file-image text-purple-500',
                                        'png' => 'fa-file-image text-purple-500',
                                        'gif' => 'fa-file-image text-purple-500',
                                        'video' => 'fa-file-video text-pink-500',
                                        'mp4' => 'fa-file-video text-pink-500',
                                        'mov' => 'fa-file-video text-pink-500',
                                        'avi' => 'fa-file-video text-pink-500',
                                        'audio' => 'fa-file-audio text-cyan-500',
                                        'mp3' => 'fa-file-audio text-cyan-500',
                                        'wav' => 'fa-file-audio text-cyan-500',
                                    ];
                                    $ext = strtolower(pathinfo($material['file_name'], PATHINFO_EXTENSION));
                                    $iconClass = isset($fileTypeIcons[$ext]) ? $fileTypeIcons[$ext] : 'fa-file text-gray-400';
                                    ?>
                                    <i class="fas <?php echo $iconClass; ?> text-2xl"></i>
                                    <span class="text-xs text-gray-400"><?php echo date('M d, Y', strtotime($material['upload_date'])); ?></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-lg font-semibold text-gray-800 group-hover:text-violet-700 transition-colors duration-200 truncate">
                                        <?php echo htmlspecialchars($material['material_title']); ?>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 truncate">
                                        <?php echo htmlspecialchars($material['file_name']); ?>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-2 line-clamp-2">
                                        <?php echo htmlspecialchars(substr($material['material_description'], 0, 80)) . (strlen($material['material_description']) > 80 ? '...' : ''); ?>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-3">
                                    <span class="px-3 py-1 rounded-full font-medium bg-violet-100 text-violet-700 border border-violet-200 text-xs">
                                        <?php echo strtoupper($ext); ?>
                                    </span>
                                </div>
                            </a>
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
                            <span><?php echo $totalItems; ?> total materials</span>
                        </div>
                        <nav class="inline-flex rounded-xl shadow-sm overflow-hidden" aria-label="Pagination">
                            <!-- Previous Page -->
                            <?php if ($page > 1): ?>
                                <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $page - 1; ?>"
                                   class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors duration-150 ease-in-out">
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
                                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=1" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors">
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
                                        <span class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-violet-100 text-sm font-bold text-violet-700">
                                            <?php echo $i; ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors">
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
                                    <a href="?class_id=<?php echo urlencode($class_id); ?>&page=<?php echo $totalPages; ?>" class="relative inline-flex items-center px-4 py-2.5 border-r border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors">
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
                                   class="relative inline-flex items-center px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-violet-50 hover:text-violet-700 transition-colors duration-150 ease-in-out">
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
    <script>
        // Simple search filter
        document.getElementById('materialSearch').addEventListener('input', function() {
            var filter = this.value.toLowerCase();
            document.querySelectorAll('#materialList li').forEach(function(li) {
                var text = li.textContent.toLowerCase();
                li.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>