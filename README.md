quiz result link button

<!-- View Results Button -->

            <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                <a href="../Quiz/quizResults.php?quiz_id=<?php echo $quiz['quiz_id']; ?>"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Results
                </a>
            <?php endif; ?>

all quizzes

 <!-- View Results Button -->

            <?php if ($quiz['status'] === 'published' && $quiz['attempt_count'] > 0): ?>
                <a href="../Quiz/quizResults.php?quiz_id=<?php echo $quiz['quiz_id']; ?>"
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 focus:ring-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Results
                </a>
            <?php endif; ?>

<div class="flex items-center space-x-3">
            <a href="../Dashboard/teachersDashboard.php" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
        </div>

<a href="../Tabs/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>" 
                   class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-400/50">
<i class="fas fa-arrow-left mr-2"></i>
Back to Class
</a>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <h2 class="text-xl font-bold text-gray-900">All Your Classes</h2>
                    <div class="flex items-center gap-3">
                        <button id="addClassBtn" class="px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center shadow-sm hover:shadow">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Add New Class</span>
                        </button>
                        
                        <button 
                        onclick="window.location.href='../Dashboard/teachersDashboard.php'"
                        class="bg-white/80 hover:bg-white text-gray-700 px-4 py-2.5 rounded-xl flex items-center text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-gray-200/50"
                    >
                        <i class="fas fa-arrow-left mr-2"></i> Dashboard
                    </button>
                    </div>
                </div>
