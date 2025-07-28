<?php
$today = date('Y-m-d');
?>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Quizzes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Recent Quizzes</h3>
            <a href="../Pages/quizzes.php" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors px-3 py-2 rounded-lg hover:bg-blue-100">
                View All &rarr;
            </a>
        </div>
        <?php if (!empty($recentQuizzes)): ?>
            <ul>
                <?php foreach ($recentQuizzes as $i => $quiz): ?>
                    <?php $isNewToday = (date('Y-m-d', strtotime($quiz['created_at'])) === $today); ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/classDetails.php?class_id=<?php echo $quiz['class_id']; ?>#quiz-<?php echo $quiz['quiz_id']; ?>"
                           class="flex items-center gap-3 border border-blue-200 hover:bg-blue-100 rounded-xl p-3 transition relative shadow-sm">
                            <i class="fas fa-clipboard-list text-blue-400 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium  flex items-center">
                                    <?php echo htmlspecialchars($quiz['quiz_title']); ?>
                                </div>
                                <div class="text-xs "><?php echo htmlspecialchars($quiz['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($quiz['created_at'])); ?></div>
                            </div>
                            <?php if ($isNewToday): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold border border-blue-400 text-blue-700 rounded shadow">Recently Added</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-blue-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No recent quizzes available</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quiz Results: Only Passed Attempts -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Quiz Results</h3>
            <a href="../Pages/quizResults.php" class="text-sm font-semibold text-green-600 hover:text-green-700 transition-colors px-3 py-2 rounded-lg hover:bg-green-100">
                View All &rarr;
            </a>
        </div>
        <?php if (!empty($passedQuizAttempts)): ?>
            <ul>
                <?php foreach ($passedQuizAttempts as $i => $attempt): ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/quizAttempts.php?quiz_id=<?php echo $attempt['quiz_id']; ?>&class_id=<?php echo $attempt['class_id']; ?>"
                           class="flex items-center gap-3 border border-green-200 hover:bg-green-100 rounded-xl p-3 transition relative shadow-sm">
                            <i class="fas fa-poll text-green-400 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium flex items-center">
                                    <?php echo htmlspecialchars($attempt['quiz_title']); ?>
                                </div>
                                <div class="text-xs">
                                    <?php echo htmlspecialchars($attempt['class_name']); ?> &middot;
                                    <?php echo date('M d, Y', strtotime($attempt['end_time'])); ?> &middot;
                                    Score: <?php echo $attempt['score']; ?>
                                </div>
                            </div>
                            <?php if ($i === 0): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold border border-green-400 text-green-700 rounded shadow">New</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-poll text-green-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No passed quiz results to display</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Recent Materials -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Recent Materials</h3>
            <a href="../Pages/materials.php" class="text-sm font-semibold text-yellow-600 hover:text-yellow-700 transition-colors px-3 py-2 rounded-lg hover:bg-yellow-100">
                View All &rarr;
            </a>
        </div>
        <?php if (!empty($recentMaterials)): ?>
            <ul>
                <?php foreach ($recentMaterials as $i => $material): ?>
                    <?php $isNewToday = (date('Y-m-d', strtotime($material['upload_date'])) === $today); ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/classDetails.php?class_id=<?php echo $material['class_id']; ?>#material-<?php echo $material['material_id']; ?>"
                           class="flex items-center gap-3 border border-yellow-200 hover:bg-yellow-100 rounded-xl p-3 transition relative shadow-sm">
                            <i class="fas fa-file-alt text-yellow-300 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium flex items-center">
                                    <?php echo htmlspecialchars($material['material_title']); ?>
                                </div>
                                <div class="text-xs"><?php echo htmlspecialchars($material['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($material['upload_date'])); ?></div>
                            </div>
                            <?php if ($isNewToday): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold border border-yellow-400 text-yellow-700 rounded shadow">Recently Added</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-file-alt text-yellow-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No recent materials</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Latest Announcements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold ">Latest Announcements</h3>
            <a href="../Pages/announcements.php" class="text-sm font-semibold text-red-600 hover:text-red-700 transition-colors px-3 py-2 rounded-lg hover:bg-red-100">
                View All &rarr;
            </a>
        </div>
        <?php if (!empty($recentAnnouncements)): ?>
            <ul>
                <?php foreach ($recentAnnouncements as $i => $announcement): ?>
                    <?php $isNewToday = (date('Y-m-d', strtotime($announcement['created_at'])) === $today); ?>
                    <li class="mb-4 relative">
                        <a href="../Pages/classDetails.php?class_id=<?php echo $announcement['class_id']; ?>#announcement-<?php echo $announcement['announcement_id']; ?>"
                           class="flex items-center gap-3 border border-red-200 hover:bg-red-100 rounded-xl p-3 transition relative shadow-sm">
                            <i class="fas fa-bullhorn text-red-300 text-2xl"></i>
                            <div class="flex-1">
                                <div class="font-medium flex items-center">
                                    <?php echo htmlspecialchars($announcement['title']); ?>
                                </div>
                                <div class="text-xs"><?php echo htmlspecialchars($announcement['class_name']); ?> &middot; <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?></div>
                            </div>
                            <?php if ($isNewToday): ?>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 px-2 py-0.5 text-xs font-semibold border border-red-400 text-red-700 rounded shadow">Recently Added</span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-bullhorn text-red-300 text-4xl mb-4"></i>
                <p class="text-gray-500">No announcements yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Confirmation Modal -->
<?php include '../Modals/openContentModal.php'  ?>

<script>
    document.querySelectorAll(".flex.items-center.gap-3").forEach(function (card) {
  card.addEventListener("click", function (e) {
    // Only trigger for anchor tags
    if (e.currentTarget.tagName.toLowerCase() !== "a") return;
    e.preventDefault();

    // Get class name from card
    var className = card
      .querySelector(".text-xs")
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