<!-- View Announcement Modal -->
<div id="viewAnnouncementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-auto p-0 relative border border-gray-200">
        <!-- Header with Icon -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100 bg-orange-100  rounded-t-xl">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm bg-orange-100">
                <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <h3 id="viewAnnouncementTitle" class="text-2xl font-bold text-gray-900 flex-1 truncate"></h3>
            <!-- Close Button -->
            <button class="text-gray-400 hover:text-gray-600 ml-2" onclick="document.getElementById('viewAnnouncementModal').classList.add('hidden')">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <div class="px-6 py-5">
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    <span id="viewAnnouncementDate"></span>
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                    <i class="fas fa-clock mr-1"></i>
                    <span id="viewAnnouncementTime"></span>
                </span>
                <span id="viewAnnouncementPinned" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200 hidden">
                    <i class="fas fa-thumbtack mr-1"></i> Pinned
                </span>
            </div>
            <div id="viewAnnouncementContent" class="prose max-w-none text-gray-700 overflow-y-auto max-h-[60vh] pb-4" style="word-break: break-word; white-space: pre-line;">
                <!-- Announcement content will be loaded here -->
            </div>
        </div>
    </div>
</div>
