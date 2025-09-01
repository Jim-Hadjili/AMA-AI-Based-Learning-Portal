<!-- Announcement Modal -->
<div id="announcementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-100 transform transition-all duration-300">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h3 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-bullhorn text-purple-600"></i>
                </span>
                Create Announcement
            </h3>
            <button type="button" onclick="document.getElementById('announcementModal').classList.add('hidden')" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="announcementForm" action="../Includes/handle-announcement.php" method="POST" class="px-6 py-6 bg-white rounded-b-2xl">
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($classDetails['class_id'] ?? ''); ?>">
            <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($classDetails['th_id'] ?? ''); ?>">

            <div class="space-y-4">
                <div>
                    <label for="announcementTitle" class="block text-sm font-medium text-gray-700 mb-1">Title<span class="text-red-500">*</span></label>
                    <input type="text" id="announcementTitle" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="e.g., Important Update, New Assignment" required>
                </div>
                <div>
                    <label for="announcementContent" class="block text-sm font-medium text-gray-700 mb-1">Content<span class="text-red-500">*</span></label>
                    <textarea id="announcementContent" name="content" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Write your announcement here..." required></textarea>
                </div>
                <div class="flex items-center">
                    <label for="pinAnnouncement" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" id="pinAnnouncement" name="is_pinned" class="sr-only">
                            <div class="block bg-gray-200 w-10 h-6 rounded-full transition-colors"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Pin to top</span>
                    </label>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('announcementModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-bullhorn mr-1.5"></i>Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom styles for the toggle switch */
input:checked + .block {
    background-color: #8B5CF6;
}
input:checked + .block + .dot {
    transform: translateX(100%);
}
</style>
