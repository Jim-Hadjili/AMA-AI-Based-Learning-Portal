<?php include "../../Functions/quizResultFunction.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../../Assets/Images/Logo.png">
    <title><?php echo htmlspecialchars($quizDetails['quiz_title']); ?> - Answer Sheet</title>
    <link rel="stylesheet" href="../../Assets/Css/studentsDashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="../../Assets/Scripts/tailwindConfig.js"></script>
    <script src="../../Assets/Scripts/studentsDashboard.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div id="main-content" class="min-h-screen">

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6 pt-6">

            <!-- Breadcrumb for Answer Sheet -->
            <?php include "../Includes/quizResultIncludes/answerSheetBreadcrumb.php" ?>

            <!-- Answer Sheet Header -->
            <?php include "../Includes/quizResultIncludes/answerSheetHeader.php" ?>

            <!-- Detailed Answer Review -->
            <?php include "../Includes/quizResultIncludes/quizResultReviewSection.php" ?>

        </main>
    </div>

</body>

</html>