<?php
include "../../Functions/classDetailsFunction.php";

// Class Materials Functions
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
    $allMaterials = array_filter($allMaterials, function ($m) use ($fileType) {
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
usort($allMaterials, function ($a, $b) use ($sort) {
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

        .pagination a,
        .pagination span {
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

        <!-- Breadcrumb Navigation -->
        <?php include "../Includes/classDetailsIncludes/classDetailsMaterialsIncludes/materialBreadcrumb.php" ?>

        <!-- Header Section -->
        <?php include "../Includes/classDetailsIncludes/classDetailsMaterialsIncludes/materialHeader.php"; ?>

        <!--Search and Filter Bar -->
        <?php include "../Includes/classDetailsIncludes/classDetailsMaterialsIncludes/materialSearchFilter.php"; ?>

        <!-- Materials List -->
        <?php include "../Includes/classDetailsIncludes/classDetailsMaterialsIncludes/materialList.php" ?>

    </div>

    <!-- Search and filter -->
    <script src="../Includes/classDetailsIncludes/classDetailsMaterialsIncludes/materialScript.js"></script>

</body>
</html>