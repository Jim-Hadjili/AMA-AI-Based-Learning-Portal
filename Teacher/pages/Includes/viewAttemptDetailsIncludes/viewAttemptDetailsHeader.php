<div class="gradient-bg text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Navigation -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <a href="javascript:history.back()" class="flex items-center text-white hover:text-blue-200 transition-colors duration-200 bg-white bg-opacity-10 px-3 py-2 rounded-lg backdrop-blur-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Results
                </a>
                <div class="h-6 w-px bg-white bg-opacity-30"></div>
                <a href="../index.php" class="flex items-center text-white hover:text-blue-200 transition-colors duration-200">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard
                </a>
            </div>

            <div class="flex items-center space-x-3 no-print">
                <button onclick="window.print()" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-white px-4 py-2 rounded-lg transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>
                <button onclick="exportToPDF()" class="bg-white bg-opacity-10 hover:bg-opacity-20 text-white px-4 py-2 rounded-lg transition-all duration-200 backdrop-blur-sm">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </button>
            </div>
        </div>

        <!-- Header Content -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold mb-2 flex items-center">
                    <i class="fas fa-clipboard-check mr-3 text-blue-200"></i>
                    Student Attempt Analysis
                </h1>
                <p class="text-blue-100 text-lg"><?php echo htmlspecialchars($quiz_title); ?></p>
                <div class="flex items-center mt-2 text-sm text-blue-200">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Completed on <?php echo date('F j, Y \a\t g:i A', strtotime($attempt['end_time'])); ?>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                    <div class="text-2xl font-bold"><?php echo $scorePercentage; ?>%</div>
                    <div class="text-xs text-blue-200 uppercase tracking-wide">Score</div>
                </div>
                <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                    <div class="text-2xl font-bold"><?php echo $totalPointsEarned; ?>/<?php echo $totalPossiblePoints; ?></div>
                    <div class="text-xs text-blue-200 uppercase tracking-wide">Points</div>
                </div>
                <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                    <div class="text-2xl font-bold"><?php echo count($questions); ?></div>
                    <div class="text-xs text-blue-200 uppercase tracking-wide">Questions</div>
                </div>
                <div class="bg-white bg-opacity-10 rounded-xl p-4 text-center backdrop-blur-sm">
                    <div class="text-2xl font-bold"><?php echo $timeSpent; ?></div>
                    <div class="text-xs text-blue-200 uppercase tracking-wide">Time</div>
                </div>
            </div>
        </div>
    </div>
</div>