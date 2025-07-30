<?php
include '../../Functions/studentDashboardFunction.php';

// Fetch all classes for dropdown
$classList = [];
if (!empty($classIds)) {
    $classQuery = "SELECT class_id, class_name FROM teacher_classes_tb WHERE class_id IN ($classIdsStr)";
    $classResult = $conn->query($classQuery);
    while ($row = $classResult->fetch_assoc()) {
        $classList[] = $row;
    }
}

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

// Get filter/sort from GET (default values)
$classFilter = isset($_GET['class_id_filter']) ? $_GET['class_id_filter'] : '';
$fileType = isset($_GET['fileType']) ? $_GET['fileType'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Filter by class
if ($classFilter && $classFilter !== 'all') {
    $allMaterials = array_filter($allMaterials, function ($m) use ($classFilter) {
        return $m['class_id'] == $classFilter;
    });
}

// Sort
if ($sort && $sort !== 'all') {
    usort($allMaterials, function ($a, $b) use ($sort) {
        if ($sort === 'oldest') return strtotime($a['upload_date']) - strtotime($b['upload_date']);
        if ($sort === 'newest') return strtotime($b['upload_date']) - strtotime($a['upload_date']);
        if ($sort === 'az') return strcmp(strtolower($a['material_title']), strtolower($b['material_title']));
        if ($sort === 'za') return strcmp(strtolower($b['material_title']), strtolower($a['material_title']));
        return 0;
    });
}

// Pagination logic (must be after filtering and sorting)
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

        <!-- Breadcrumb Navigation -->
        <?php include '../Dashboard/dashboardMaterialIncludes/dashboardMaterialBreadcrumb.php'; ?>

        <!-- Header Section -->
        <?php include '../Dashboard/dashboardMaterialIncludes/dashboardMaterialHeader.php'; ?>

        <!-- Filter Bar -->
        <?php include '../Dashboard/dashboardMaterialIncludes/dashboardMaterialSearchFilter.php'; ?>

        <!-- Material List -->
        <?php include '../Dashboard/dashboardMaterialIncludes/dashboardMaterialList.php'; ?>

    </div>

    <?php include '../Modals/openContentModal.php'  ?>

</body>

</html>

<script src="../Dashboard/dashboardMaterialIncludes/dashboardMaterialScript.js"></script>