<div id="announcementModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg mr-3">
                        <i class="fas fa-bullhorn text-orange-600"></i>
                    </div>
                    <div>
                        <h2 id="modalAnnouncementTitle" class="text-xl font-semibold text-gray-900"></h2>
                        <div class="flex items-center mt-1">
                            <span id="modalAnnouncementDate" class="text-sm text-gray-500"></span>
                            <span id="modalPinnedBadge" class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full hidden">
                                <i class="fas fa-thumbtack mr-1"></i>Pinned
                            </span>
                        </div>
                    </div>
                </div>
                <button id="closeAnnouncementModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <div id="modalAnnouncementContent" class="text-gray-700 leading-relaxed whitespace-pre-wrap"></div>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-end">
                <button id="closeAnnouncementModalBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>