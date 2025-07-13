<div id="announcements-tab" class="tab-content p-6 hidden">
  <?php if (empty($announcements)): ?>
      <div class="flex flex-col items-center justify-center py-12 bg-card text-card-foreground rounded-lg shadow-sm border border-dashed border-border">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone text-muted-foreground mb-4">
              <path d="m3 11 18-8v11l-18 8z"/>
              <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>
          </svg>
          <h3 class="text-xl font-semibold text-foreground mb-2">No Announcements Yet</h3>
          <p class="text-muted-foreground mb-6 text-center max-w-sm">Create announcements to keep your students informed and engaged.</p>
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

      <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          <?php foreach ($announcements as $announcement): ?>
              <div class="relative bg-card text-card-foreground rounded-lg shadow-sm border border-border p-6 hover:shadow-md transition-all cursor-pointer announcement-card-clickable"
                  data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                  data-announcement-title="<?php echo htmlspecialchars($announcement['title']); ?>"
                  data-announcement-content="<?php echo htmlspecialchars($announcement['content']); ?>"
                  data-announcement-date="<?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>"
                  data-announcement-pinned="<?php echo $announcement['is_pinned'] ? 'true' : 'false'; ?>">
                  
                  <div class="flex justify-between items-start mb-3">
                      <h4 class="text-lg font-semibold text-foreground pr-8"><?php echo htmlspecialchars($announcement['title']); ?></h4>
                      <div class="absolute top-6 right-6 flex items-center space-x-2">
                          <button class="edit-announcement-btn text-muted-foreground hover:text-blue-600 text-sm" 
                                  data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                                  aria-label="Edit announcement">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit">
                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"/>
                              </svg>
                          </button>
                          <button class="delete-announcement-btn text-muted-foreground hover:text-destructive hover:text-red-600 text-sm" 
                                  data-announcement-id="<?php echo htmlspecialchars($announcement['announcement_id']); ?>"
                                  aria-label="Delete announcement">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                                  <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/>
                              </svg>
                          </button>
                      </div>
                  </div>
                  
                  <p class="text-muted-foreground mb-4 line-clamp-3 text-sm"><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                  
                  <div class="flex justify-between items-center text-xs text-muted-foreground">
                      <span class="flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days mr-1">
                              <path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
                          </svg>
                          <?php echo date('M d, Y', strtotime($announcement['created_at'])); ?>
                      </span>
                      <?php if ($announcement['is_pinned']): ?>
                          <span class="flex items-center text-amber-600">
                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pin mr-1">
                                  <path d="M12 17V3"/><path d="M15 10l-3 3-3-3"/><path d="M12 17a2 2 0 1 1 0 4 2 2 0 0 1 0-4Z"/>
                              </svg>
                              Pinned
                          </span>
                      <?php endif; ?>
                  </div>
              </div>
          <?php endforeach; ?>
      </div>
  <?php endif; ?>
</div>
