<div id="announcementModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden animate-in fade-in-0 zoom-in-95 duration-200">
        <!-- Modal Header -->
        <div class="px-8 py-6 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center border border-amber-100">
                        <i class="fas fa-bullhorn text-amber-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 id="modalAnnouncementTitle" class="text-xl font-semibold text-gray-900 mb-2"></h2>
                        <div class="flex flex-wrap items-center gap-3">
                            <span id="modalAnnouncementDate" class="text-sm text-gray-600"></span>
                            <span id="modalPinnedBadge" class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium bg-amber-50 text-amber-700 rounded-full border border-amber-200 hidden">
                                <div class="w-1.5 h-1.5 bg-amber-400 rounded-full"></div>
                                Pinned
                            </span>
                        </div>
                    </div>
                </div>
                <button id="closeAnnouncementModal" class="w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="px-8 py-6 overflow-y-auto max-h-[60vh]">
            <div id="modalAnnouncementContent" class="text-gray-700 leading-relaxed whitespace-pre-wrap prose prose-gray max-w-none text-justify"></div>
        </div>

        <!-- Modal Footer -->
        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/50">
            <div class="flex justify-end">
                <button id="closeAnnouncementModalBtn" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all duration-200 font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>