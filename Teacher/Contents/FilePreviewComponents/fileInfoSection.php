<div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
    <!-- Top accent strip (static or use subject color if available) -->
    <div class="h-1 bg-gradient-to-r from-indigo-400 to-indigo-600"></div>
    <div class="p-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="p-4 border-r border-gray-200">
            <h3 class="text-sm font-medium text-gray-500 mb-1">File Name</h3>
            <p class="text-base font-medium"><?php echo htmlspecialchars($material['file_name']); ?></p>
            </div>
            <div class="p-4 border-r border-gray-200">
            <h3 class="text-sm font-medium text-gray-500 mb-1">File Type</h3>
            <p class="text-base font-medium uppercase"><?php echo $extension; ?></p>
            </div>
            <div class="p-4 border-r border-gray-200">
            <h3 class="text-sm font-medium text-gray-500 mb-1">File Size</h3>
            <p class="text-base font-medium"><?php echo formatFileSize($material['file_size']); ?></p>
            </div>
            <div class="p-4 border-r border-gray-200">
            <h3 class="text-sm font-medium text-gray-500 mb-1">Upload Date</h3>
            <p class="text-base font-medium"><?php echo date('F d, Y', strtotime($material['upload_date'])); ?></p>
            </div>
            <div class="p-4 flex flex-col gap-2 justify-center items-start md:items-center">
            <!-- Change the download button to show the modal instead of directly downloading -->
            <button id="downloadBtn" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center text-sm font-medium transition-all duration-200">
                <i class="fas fa-download mr-2"></i> Download File
            </button>
            <button id="deleteBtn" class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center text-sm font-medium transition-all duration-200">
                <i class="fas fa-trash-alt mr-2"></i> Delete Material
            </button>
            </div>
        </div>
        <?php if (!empty($material['material_description'])): ?>
            <div class="mt-4 p-4 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                <p class="text-base"><?php echo nl2br(htmlspecialchars($material['material_description'])); ?></p>
            </div>
        <?php endif; ?>
    </div>

    
</div>
