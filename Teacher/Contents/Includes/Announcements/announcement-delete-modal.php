<!-- Delete Announcement Confirmation Modal -->
<div id="deleteAnnouncementModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex items-center justify-center hidden backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 border border-gray-200 transform transition-all duration-300">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-200 bg-gradient-to-r from-red-50 to-white rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <span class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                    <i class="fas fa-trash-alt text-red-600"></i>
                </span>
                Confirm Deletion
            </h3>
            <button type="button" id="closeDeleteAnnouncementModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full p-1 hover:bg-gray-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="px-6 py-5">
            <div class="flex items-start mb-4">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-red-600 mb-2">Warning</h4>
                    <p class="text-gray-700 mb-2">Are you sure you want to delete this announcement:</p>
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg mb-3 flex items-center">
                        <i class="fas fa-bullhorn text-red-500 mr-3"></i>
                        <p class="font-medium text-gray-900" id="announcementTitleToDelete"></p>
                    </div>
                    <p class="text-sm text-gray-500 flex items-center">
                        <i class="fas fa-info-circle text-red-400 mr-2"></i>
                        This action cannot be undone and all associated data will be permanently removed.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-xl border-t border-gray-200">
            <button type="button" id="cancelDeleteAnnouncementBtn" class="px-4 py-2.5 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                <i class="fas fa-times mr-1.5"></i>Cancel
            </button>
            <!-- Changed to type="submit" and wrapped in a form -->
            <form id="deleteAnnouncementForm" action="../Includes/handle-delete-announcement.php" method="POST" class="inline-block">
                <input type="hidden" name="announcement_id" id="deleteAnnouncementIdInput">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($classDetails['class_id'] ?? ''); ?>">
                <button type="submit" id="confirmDeleteAnnouncementBtn" class="px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-sm text-sm font-medium text-white hover:from-red-600 hover:to-red-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash-alt mr-1.5"></i>Delete
                </button>
            </form>
        </div>
    </div>
</div>
