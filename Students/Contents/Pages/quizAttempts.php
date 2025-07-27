<?php include "../../Functions/quizAttemptsFunction.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Attempts - <?php echo htmlspecialchars($quiz['quiz_title'] ?? 'Quiz'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../Assets/Css/quizAttempts.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../Assets/Scripts/quizAttemptsConfig.js"></script>    
</head>

<body class="bg-slate-100 font-sans">
    <!-- Page Header -->
    <?php include "../Includes/quizAttemptsIncludes/quizAttemptsBreadcrumb.php"; ?>

    <div class="max-w-8xl mx-auto px-6 pb-6">

        <?php if (empty($attempts)): ?>

            <!-- Empty State -->
            <?php include "../Includes/quizAttemptsIncludes/quizAttemptsEmptyState.php" ?>

        <?php else: ?>

            <!-- Performance Trend Graph -->
            <?php if (count($attempts) > 0):?>
            
                <?php include "../Includes/quizAttemptsIncludes/quizAttemptsGraph.php" ?>

            <?php endif; ?>

            <!-- Attempts Table -->
            <?php include "../Includes/quizAttemptsIncludes/quizAttemptsTable.php"; ?>

        <?php endif; ?>
        
    </div>

    <?php include "../Includes/quizAttemptsIncludes/quizAttemptsScript.php"; ?>

</body>
</html>