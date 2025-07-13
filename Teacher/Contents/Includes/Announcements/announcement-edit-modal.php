<!-- Edit Announcement Modal -->
<div id="editAnnouncementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto p-6 relative border border-gray-200 transform transition-all duration-300">
        <!-- Close Button -->
        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="document.getElementById('editAnnouncementModal').classList.add('hidden')">
            <i class="fas fa-times text-lg"></i>
        </button>

        <div class="px-0 py-0 flex items-center justify-between border-b border-gray-200 bg-gradient-to-r from-purple-50 to-white rounded-t-xl -mx-6 -mt-6 px-6 py-5">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                    <i class="fas fa-edit text-purple-600"></i>
                </span>
                Edit Announcement
            </h3>
        </div>
        
        <form id="editAnnouncementForm" action="../Includes/handle-edit-announcement.php" method="POST" class="mt-4">
            <input type="hidden" name="announcement_id" id="editAnnouncementId">
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($classDetails['class_id'] ?? ''); ?>">
            <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($classDetails['th_id'] ?? ''); ?>">

            <div class="mb-4">
                <label for="editAnnouncementTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="editAnnouncementTitle" name="title" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="editAnnouncementContent" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea id="editAnnouncementContent" name="content" rows="5" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required></textarea>
            </div>
            <div class="flex items-center justify-between mb-6">
                <label for="editPinAnnouncement" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="editPinAnnouncement" name="is_pinned" class="sr-only">
                        <div class="block bg-gray-200 w-10 h-6 rounded-full"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Pin to top</span>
                </label>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-xl border-t border-gray-200 -mx-6 -mb-6">
                <button type="button" class="px-4 py-2.5 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300" onclick="document.getElementById('editAnnouncementModal').classList.add('hidden')">
                    <i class="fas fa-times mr-1.5"></i>Cancel
                </button>
                <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-600 hover:to-purple-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-save mr-1.5"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom styles for the toggle switch (for both create and edit modals) */
#pinAnnouncement:checked + .block, #editPinAnnouncement:checked + .block {
    background-color: #8B5CF6; /* purple-primary */
}
#pinAnnouncement:checked + .block + .dot, #editPinAnnouncement:checked + .block + .dot {
    transform: translateX(100%);
}
</style>
