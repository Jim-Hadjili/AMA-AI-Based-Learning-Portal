<?php include "../Functions/teacherFilePreviewFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($material['material_title']); ?> - File Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../Assets/Js/tailwindConfig.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/teacherDashboard.css">

    <!-- PDF.js for PDF preview -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <style>
        .preview-container {
            height: calc(100vh - 180px);
            min-height: 500px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-[sans-serif]">

    <!-- Main Content -->
    <div class="max-w-9xl mx-auto px-4 py-4 sm:px-6 lg:px-8">

        <!-- Header with Navigation -->
        <?php include "./FilePreviewComponents/filePreviewBreadcrumb.php"; ?>

        <!-- File Preview Stats Section -->
        <?php include "./FilePreviewComponents/filePreviewSectionStats.php"; ?>

        <!-- File Information -->
        <?php include "./FilePreviewComponents/fileInfoSection.php"; ?>

    </div>

    <!-- Include the download modal -->
    <?php include_once "./Modals/materialDownloadModal.php"; ?>
    <?php include_once "./Modals/materialDeleteModal.php"; ?>

    <?php include "./FilePreviewComponents/filePreviewScript.php" ?>
</body>

</html>