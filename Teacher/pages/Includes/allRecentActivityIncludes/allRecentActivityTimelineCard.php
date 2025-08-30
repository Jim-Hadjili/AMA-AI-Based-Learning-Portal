<div class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-6">
    <?php if (empty($activities)): ?>
        <div class="text-center py-16">
            <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                <i class="fas fa-clock text-gray-300 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Recent Activity</h3>
            <p class="text-gray-500 max-w-md mx-auto">There are no new activities to display.</p>
        </div>
    <?php else: ?>
        <ul id="activityTimeline" class="space-y-6">
            <?php foreach ($activities as $index => $act): ?>
                <li class="flex items-start gap-4 activity-item bg-gray-50 rounded-lg shadow-sm border border-gray-100 px-4 py-4 hover:shadow-md transition-shadow duration-200"
                    data-type="<?= $act['type'] ?>"
                    data-class="<?= $act['class_id'] ?>"
                    data-desc="<?= htmlspecialchars(strip_tags($act['desc'])) ?>"
                    data-student="<?= htmlspecialchars($act['student_name']) ?>"
                    data-quiz="<?= isset($act['quiz_title']) ? htmlspecialchars($act['quiz_title']) : '' ?>">
                    <span class="flex-shrink-0 p-3 rounded-full
                                <?php
                                if ($act['type'] === 'enrollment') echo 'bg-green-100';
                                elseif ($act['type'] === 'quiz_submission') echo 'bg-blue-100';
                                else echo 'bg-gray-100';
                                ?>">
                        <?php
                        if ($act['type'] === 'enrollment') echo '<i class="fas fa-user-plus text-green-600 text-xl"></i>';
                        elseif ($act['type'] === 'quiz_submission') echo '<i class="fas fa-file-alt text-blue-600 text-xl"></i>';
                        else echo '<i class="fas fa-info-circle text-gray-400 text-xl"></i>';
                        ?>
                    </span>
                    <div class="w-full">
                        <div class="text-gray-800 cursor-pointer hover:text-indigo-600 flex justify-between items-center"
                            onclick="showActivityDetails(<?= $index ?>)">
                            <span class="font-medium"><?= $act['desc'] ?></span>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </div>
                        <div class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <?= date('M d, Y h:i A', strtotime($act['time'])) ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>