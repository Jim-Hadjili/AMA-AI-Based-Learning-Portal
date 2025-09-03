<div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <!-- Top accent strip -->
    <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-600"></div>
    <div class="p-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-gray-900 mb-1"><?php echo $totalClasses ?? 0; ?></div>
                <div class="text-sm text-gray-500 text-center">Total Classes</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-green-600 mb-1"><?php echo $activeClasses ?? 0; ?></div>
                <div class="text-sm text-gray-500 text-center">Active</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="text-2xl font-bold text-yellow-600 mb-1"><?php echo $inactiveClasses ?? 0; ?></div>
                <div class="text-sm text-gray-500 text-center">Inactive</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center">
                <div class="flex-1 flex items-center justify-center mb-2">
                    <button
                        id="addClassBtn"
                        type="button"
                        onclick="window.openAddClassModal && window.openAddClassModal()"
                        class="group relative inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden"
                        aria-label="Add New Class">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <span class="relative">Add New Class</span>
                    </button>
                </div>
                <div class="text-sm text-gray-500 text-center">Action</div>
            </div>
        </div>
    </div>
</div>