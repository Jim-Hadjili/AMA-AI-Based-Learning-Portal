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
                    <button id="addClassBtn" type="button"
                        class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-purple-600 text-sm font-semibold rounded-lg text-purple-700 hover:text-white bg-purple-50 hover:bg-purple-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold">Add New Class</span>
                    </button>
                </div>
                <div class="text-sm text-gray-500 text-center">Action</div>
            </div>
        </div>
    </div>
</div>