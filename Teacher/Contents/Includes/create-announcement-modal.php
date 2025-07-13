<!-- Announcement Modal -->
<div id="announcementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-auto p-6 relative">
        <!-- Close Button -->
        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="document.getElementById('announcementModal').classList.add('hidden')">
            <i class="fas fa-times text-lg"></i>
        </button>

        <h3 class="text-xl font-bold text-gray-900 mb-4">Create New Announcement</h3>
        
        <!-- Corrected form action path -->
        <form id="announcementForm" action="../Includes/handle-announcement.php" method="POST">
            <!-- Hidden input to pass class_id -->
            <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($classDetails['class_id'] ?? ''); ?>">
            <!-- Hidden input to pass teacher_id -->
            <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($classDetails['th_id'] ?? ''); ?>">

            <div class="mb-4">
                <label for="announcementTitle" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="announcementTitle" name="title" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="e.g., Important Update, New Assignment" required>
            </div>
            <div class="mb-4">
                <label for="announcementContent" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea id="announcementContent" name="content" rows="5" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Write your announcement here..." required></textarea>
            </div>
            <div class="flex items-center justify-between mb-6">
                <label for="pinAnnouncement" class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="pinAnnouncement" name="is_pinned" class="sr-only">
                        <div class="block bg-gray-200 w-10 h-6 rounded-full"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Pin to top</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" onclick="document.getElementById('announcementModal').classList.add('hidden')">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-purple-primary text-white rounded-md text-sm font-medium hover:bg-purple-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom styles for the toggle switch */
input:checked + .block {
    background-color: #8B5CF6; /* purple-primary */
}
input:checked + .block + .dot {
    transform: translateX(100%);
}
</style>
