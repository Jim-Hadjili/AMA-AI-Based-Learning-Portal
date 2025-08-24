
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
    <?php if (empty($activities)): ?>
        <div class="text-center py-12">
            <i class="fas fa-clock text-gray-300 text-4xl mb-4"></i>
            <p class="text-gray-500 mb-2">No recent activity to display</p>
        </div>
    <?php else: ?>
        <ul class="timeline space-y-4">
            <?php foreach ($activities as $index => $act): ?>
                <li class="flex items-start">
                    <span class="mr-3 flex-shrink-0">
                        <?php
                        if ($act['type'] === 'enrollment') echo '<i class="fas fa-user-plus text-green-500"></i>';
                        elseif ($act['type'] === 'quiz_submission') echo '<i class="fas fa-file-alt text-blue-500"></i>';
                        else echo '<i class="fas fa-info-circle text-gray-400"></i>';
                        ?>
                    </span>
                    <div class="w-full">
                        <div class="text-gray-800 cursor-pointer hover:text-blue-600 flex justify-between" 
                             onclick="showActivityDetails(<?= $index ?>)">
                            <span><?= $act['desc'] ?></span>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </div>
                        <div class="text-xs text-gray-400"><?= date('M d, Y h:i A', strtotime($act['time'])) ?></div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<!-- Activity Details Modal -->
<div id="activityDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-5 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Activity Details</h3>
                <button onclick="closeActivityModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-5" id="modalContent">
            <!-- Content will be dynamically inserted here -->
        </div>
        <div class="p-4 border-t border-gray-200 text-right">
            <?php if (!empty($activities)): ?>
                <button onclick="closeActivityModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    Close
                </button>
                <div id="modalActions" class="inline-block">
                    <!-- Additional action buttons will be added here -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

