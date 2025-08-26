<!-- Activity Details Modal -->
<div id="activityDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto transition-all duration-300">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-white border-b border-gray-100 px-6 py-5 rounded-t-xl flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Activity Details</h3>
            </div>
            <button onclick="closeActivityModal()" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <!-- Modal Content -->
        <div class="p-6" id="modalContent">
            <!-- Content will be dynamically inserted here -->
        </div>
        <!-- Modal Actions -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 rounded-b-xl flex justify-end items-center gap-2">
            <?php if (!empty($activities)): ?>
                <button onclick="closeActivityModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-all duration-200">
                    Close
                </button>
                <div id="modalActions" class="inline-block">
                    <!-- Additional action buttons will be added here -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>