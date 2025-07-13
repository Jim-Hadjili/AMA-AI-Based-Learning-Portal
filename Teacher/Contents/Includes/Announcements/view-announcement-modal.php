<!-- View Announcement Modal -->
<div id="viewAnnouncementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-auto p-6 relative">
        <!-- Close Button -->
        <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="document.getElementById('viewAnnouncementModal').classList.add('hidden')">
            <i class="fas fa-times text-lg"></i>
        </button>

        <h3 id="viewAnnouncementTitle" class="text-2xl font-bold text-gray-900 mb-4"></h3>
        
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <i class="fas fa-calendar-alt mr-2"></i> 
            <span id="viewAnnouncementDate"></span>
            <span id="viewAnnouncementPinned" class="ml-4 text-yellow-600 hidden">
                <i class="fas fa-thumbtack mr-1"></i> Pinned
            </span>
        </div>

        <div id="viewAnnouncementContent" class="prose max-w-none text-gray-700 overflow-y-auto max-h-[70vh] pb-4">
            <!-- Announcement content will be loaded here -->
        </div>
    </div>
</div>
