<?php include "../../Functions/materialDetailsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">

    <title><?php echo htmlspecialchars($materialDetails['material_title']); ?> - AMA Learning Platform</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <!-- PDF.js for PDF preview -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>

    <style>
        .preview-container {
            height: calc(100vh - 180px);
            /* Adjust height as needed */
            min-height: 500px;
        }
    </style>

</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6">

            <!-- subject-specific styles -->
            <?php include "../Includes/materialPreviewIncludes/materialSubjectSpecificStyles.php"; ?>

            <!-- Breadcrumb -->
            <?php include "../Includes/materialPreviewIncludes/materialBreadcrumb.php" ?>

            <!-- Material Header -->
            <?php include "../Includes/materialPreviewIncludes/materialHeader.php" ?>

            <!-- Material Info Cards -->
            <?php include "../Includes/materialPreviewIncludes/materialCardInfo.php" ?>

            <!-- Side by side: Material Details & File Preview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div>
                    <?php include "../Includes/materialPreviewIncludes/materialDetailsSection.php" ?>
                </div>
                <div>
                    <?php include "../Includes/materialPreviewIncludes/materialPreviewSection.php" ?>
                </div>
            </div>

        </main>
    </div>

    <!-- Material Preview Script -->
    <?php include "../Includes/materialPreviewIncludes/materialPreviewScript.php" ?>

    <!-- Download Confirmation Modal -->
    <?php include "../Modals/materialDownloadModal.php" ?>
</body>

</html>