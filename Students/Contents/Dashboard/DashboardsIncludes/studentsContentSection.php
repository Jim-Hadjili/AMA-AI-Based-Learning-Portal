<?php
$today = date('Y-m-d');
?>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Quizzes -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-800">Recent Quizzes</h3>
            <a href="../Pages/dashboardAllQuizzes.php" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-blue-50">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <?php if (!empty($recentQuizzes)): ?>
            <ul class="space-y-4">
                <?php foreach ($recentQuizzes as $i => $quiz): ?>
                    <?php $isNewToday = (date('Y-m-d', strtotime($quiz['created_at'])) === $today); ?>
                    <li>
                        <a href="../Pages/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>#quiz-<?php echo $quiz['quiz_id']; ?>"
                           class="flex items-center gap-4 bg-gray-50 hover:bg-gray-100 rounded-lg p-4 transition-all duration-200 ease-in-out group shadow-sm border border-gray-100">
                            <i class="fas fa-clipboard-list text-blue-500 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 group-hover:text-blue-700 transition-colors duration-200 flex items-center gap-2">
                                    <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                    <?php if ($isNewToday): ?>
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">New</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    <?php echo htmlspecialchars($quiz['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($quiz['created_at'])); ?>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors duration-200"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-clipboard-list text-5xl mb-4 text-gray-400"></i>
                <p class="text-lg font-medium">No recent quizzes available</p>
                <p class="mt-2 text-gray-500 text-sm">Check back later for new quizzes from your classes.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quiz Results: Only Passed Attempts -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-800">Quiz Results</h3>
            <a href="../Pages/dashboardAllQuizResults.php" class="inline-flex items-center gap-1 text-sm font-medium text-green-600 hover:text-green-700 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-green-50">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <?php if (!empty($passedQuizAttempts)): ?>
            <ul class="space-y-4">
                <?php foreach ($passedQuizAttempts as $i => $attempt): ?>
                    <li>
                        <a href="../Pages/quizAttempts.php?quiz_id=<?php echo $attempt['quiz_id']; ?>&class_id=<?php echo $attempt['class_id']; ?>"
                           class="flex items-center gap-4 bg-gray-50 hover:bg-gray-100 rounded-lg p-4 transition-all duration-200 ease-in-out group shadow-sm border border-gray-100">
                            <i class="fas fa-poll text-green-500 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 group-hover:text-green-700 transition-colors duration-200 flex items-center gap-2">
                                    <?php echo htmlspecialchars($attempt['quiz_title']); ?>
                                    <?php if ($i === 0): ?>
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Latest</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    <?php
                                        // Compute percentage based on total_points (sum of question_points)
                                        $total_points = $attempt['total_points'] ?? 1;
                                        if ($total_points == 0) $total_points = 1;
                                        $percentage_score = round(($attempt['score'] / $total_points) * 100);
                                    ?>
                                    <?php echo htmlspecialchars($attempt['class_name']); ?> &middot;
                                    
                                    Score: <span class="font-medium text-gray-700"><?php echo $percentage_score; ?>%</span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-600 transition-colors duration-200"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-poll text-5xl mb-4 text-gray-400"></i>
                <p class="text-lg font-medium">No passed quiz results to display</p>
                <p class="mt-2 text-gray-500 text-sm">Keep taking quizzes to see your progress here!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Recent Materials -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-800">Recent Materials</h3>
            <a href="../Pages/dashboardAllMaterials.php" class="inline-flex items-center gap-1 text-sm font-medium text-yellow-600 hover:text-yellow-700 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-yellow-50">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <?php if (!empty($recentMaterials)): ?>
            <ul class="space-y-4">
                <?php foreach ($recentMaterials as $i => $material): ?>
                    <?php $isNewToday = (date('Y-m-d', strtotime($material['upload_date'])) === $today); ?>
                    <li>
                        <a href="../Pages/classDetails.php?class_id=<?php echo $material['class_id']; ?>#material-<?php echo $material['material_id']; ?>"
                           class="flex items-center gap-4 bg-gray-50 hover:bg-gray-100 rounded-lg p-4 transition-all duration-200 ease-in-out group shadow-sm border border-gray-100">
                            <i class="fas fa-file-alt text-yellow-500 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 group-hover:text-yellow-700 transition-colors duration-200 flex items-center gap-2">
                                    <?php echo htmlspecialchars($material['material_title']); ?>
                                    <?php if ($isNewToday): ?>
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-700">New</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    <?php echo htmlspecialchars($material['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($material['upload_date'])); ?>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-600 transition-colors duration-200"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-file-alt text-5xl mb-4 text-gray-400"></i>
                <p class="text-lg font-medium">No recent materials</p>
                <p class="mt-2 text-gray-500 text-sm">Materials from your classes will appear here.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Latest Announcements -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-800">Latest Announcements</h3>
            <a href="../Pages/dashboardAllAnnouncements.php" class="inline-flex items-center gap-1 text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-red-50">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <?php if (!empty($recentAnnouncements)): ?>
            <ul class="space-y-4">
                <?php foreach ($recentAnnouncements as $i => $announcement): ?>
                    <?php $isNewToday = (date('Y-m-d', strtotime($announcement['created_at'])) === $today); ?>
                    <li>
                        <a href="../Pages/classDetails.php?class_id=<?php echo $announcement['class_id']; ?>#announcement-<?php echo $announcement['announcement_id']; ?>"
                           class="flex items-center gap-4 bg-gray-50 hover:bg-gray-100 rounded-lg p-4 transition-all duration-200 ease-in-out group shadow-sm border border-gray-100">
                            <i class="fas fa-bullhorn text-red-500 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 group-hover:text-red-700 transition-colors duration-200 flex items-center gap-2">
                                    <?php echo htmlspecialchars($announcement['title']); ?>
                                    <?php if ($isNewToday): ?>
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">New</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    <?php echo htmlspecialchars($announcement['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-red-600 transition-colors duration-200"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-bullhorn text-5xl mb-4 text-gray-400"></i>
                <p class="text-lg font-medium">No announcements yet</p>
                <p class="mt-2 text-gray-500 text-sm">Important updates from your teachers will be posted here.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Confirmation Modal -->
<?php include '../Modals/openContentModal.php'  ?>

<script>
    document.querySelectorAll(".flex.items-center.gap-4").forEach(function (card) { // Updated selector to .gap-4
  card.addEventListener("click", function (e) {
    // Only trigger for anchor tags
    if (e.currentTarget.tagName.toLowerCase() !== "a") return;
    e.preventDefault();

    // Get class name from card
    var className = card
      .querySelector(".text-sm") // Updated selector to .text-sm for consistency
      .textContent.split("·")[0]
      .trim();
    var message = "You are about to view content from " + className + " Class" + ".";

    // Show modal
    document.getElementById("confirmMessage").textContent = message;
    document.getElementById("confirmModal").classList.remove("hidden");

    // Store link
    var href = card.getAttribute("href");
    document.getElementById("confirmBtn").onclick = function () {
      window.location.href = href;
    };
    document.getElementById("cancelBtn").onclick = function () {
      document.getElementById("confirmModal").classList.add("hidden");
    };
  });
});

</script>