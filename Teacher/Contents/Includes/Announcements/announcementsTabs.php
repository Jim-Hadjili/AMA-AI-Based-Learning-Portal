<div id="announcements-tab" class="tab-content p-6 hidden">
    <?php if (empty($announcements)): ?>
        <!-- Empty State -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="text-center py-16 px-6">
                <div class="p-4 bg-gray-100 rounded-full w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Announcements Yet</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Create announcements to keep your students informed about important updates, assignments, and class information.</p>
                
                <button id="addFirstAnnouncementBtn" class="inline-flex items-center px-6 py-3 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create First Announcement
                </button>
            </div>
        </div>
    <?php else: ?>
        <!-- Announcements Header -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
            <div class="bg-white border-b border-gray-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Class Announcements</h3>
                            <p class="text-sm text-gray-600">Keep your students informed with important updates</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-white border-2 border-orange-200 px-4 py-2 rounded-xl shadow-sm">
                            <div class="text-center">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Announcements</p>
                                <p class="text-xl font-bold text-orange-600"><?php echo count($announcements); ?></p>
                            </div>
                        </div>
                        <button id="addAnnouncementBtn" type="button" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            New Announcement
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcements Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($announcements as $announcement): ?>
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl hover:border-blue-300 transition-all duration-200 cursor-pointer announcement-card-clickable"
                    data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                    data-announcement-title="<?php echo htmlspecialchars($announcement['title']); ?>"
                    data-announcement-content="<?php echo htmlspecialchars($announcement['content']); ?>"
                    data-announcement-date="<?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>"
                    data-announcement-pinned="<?php echo $announcement['is_pinned'] ? 'true' : 'false'; ?>">
                    
                    <!-- Card Header -->
                    <div class="p-6 pb-4">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-lg font-semibold text-gray-900 pr-4 line-clamp-2" title="<?php echo htmlspecialchars($announcement['title']); ?>">
                                <?php echo htmlspecialchars($announcement['title']); ?>
                            </h4>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button class="edit-announcement-btn p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200" 
                                        data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                                        title="Edit announcement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                                <button class="delete-announcement-btn p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" 
                                        data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                                        title="Delete announcement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Content Preview -->
                        <div class="mb-4">
                            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">
                                <?php echo nl2br(htmlspecialchars($announcement['content'])); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                                </svg>
                                <span><?php echo date('M j, Y', strtotime($announcement['created_at'])); ?></span>
                                <span class="mx-2">•</span>
                                <span><?php echo date('g:i A', strtotime($announcement['created_at'])); ?></span>
                            </div>
                            
                            <?php if ($announcement['is_pinned']): ?>
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Pinned
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>