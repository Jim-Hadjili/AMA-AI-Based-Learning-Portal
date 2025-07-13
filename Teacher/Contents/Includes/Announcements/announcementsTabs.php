<div id="announcements-tab" class="tab-content p-6 hidden">
            <?php if (empty($announcements)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-bullhorn text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Announcements Yet</h3>
                    <p class="text-gray-500 mb-4">Create announcements to keep your students informed and engaged.</p>
                    <button id="addFirstAnnouncementBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Create Announcement
                    </button>
                </div>
            <?php else: ?>
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="font-medium text-gray-900">Class Announcements (<?php echo count($announcements); ?>)</h3>
                    <button id="addAnnouncementBtn" class="px-3 py-1.5 bg-purple-primary text-white rounded-md hover:bg-purple-dark text-sm">
                        <i class="fas fa-plus mr-1"></i> New Announcement
                    </button>
                </div>

                <div class="space-y-4">
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-200 transition-colors cursor-pointer announcement-card-clickable"
                            data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                            data-announcement-title="<?php echo htmlspecialchars($announcement['title']); ?>"
                            data-announcement-content="<?php echo htmlspecialchars($announcement['content']); ?>"
                            data-announcement-date="<?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>"
                            data-announcement-pinned="<?php echo $announcement['is_pinned'] ? 'true' : 'false'; ?>">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($announcement['title']); ?></h4>
                                <div class="flex items-center space-x-2">
                                    <button class="edit-announcement-btn text-blue-600 hover:text-blue-900 text-sm" 
                                            data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-announcement-btn text-red-600 hover:text-red-900 text-sm" 
                                            data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 mb-3 line-clamp-3"><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                            
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>
                                    <i class="fas fa-calendar-alt mr-1"></i> 
                                    <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>
                                </span>
                                <?php if ($announcement['is_pinned']): ?>
                                    <span class="text-yellow-600">
                                        <i class="fas fa-thumbtack mr-1"></i> Pinned
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>