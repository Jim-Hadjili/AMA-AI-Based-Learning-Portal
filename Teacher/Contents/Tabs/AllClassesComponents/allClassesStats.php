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
                    <button id="addClassBtn" class="w-full px-4 py-2 bg-purple-primary text-white rounded-md hover:bg-purple-dark transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Add New Class</span>
                    </button>
                </div>
                <div class="text-sm text-gray-500 text-center">Action</div>
            </div>
        </div>
    </div>
</div>