<div class="flex flex-col md:flex-row gap-6">
    <!-- File Info Section -->
    <div class="w-full max-w-xl mx-auto bg-white rounded-2xl shadow-lg border border-white/50 mb-6 overflow-hidden flex flex-col">
        <div class="p-8 flex flex-col gap-4 h-full">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-info-circle text-indigo-600"></i>
                File Information
            </h2>
            <div class="grid grid-cols-1 gap-4 mt-8">
                <div class="p-4 border-b border-gray-200 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">File Name</h3>
                        <p class="text-base font-medium break-all"><?php echo htmlspecialchars($material['file_name']); ?></p>
                    </div>
                </div>
                <div class="p-4 border-b border-gray-200 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">File Type</h3>
                        <p class="text-base font-medium uppercase"><?php echo $extension; ?></p>
                    </div>
                </div>
                <div class="p-4 border-b border-gray-200 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-weight-hanging text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">File Size</h3>
                        <p class="text-base font-medium"><?php echo formatFileSize($material['file_size']); ?></p>
                    </div>
                </div>
                <div class="p-4 border-b border-gray-200 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Upload Date</h3>
                        <p class="text-base font-medium"><?php echo date('F d, Y', strtotime($material['upload_date'])); ?></p>
                    </div>
                </div>

            </div>
            <?php if (!empty($material['material_description'])): ?>
                <div class="p-4 border-gray-200 flex items-start gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg mt-1 flex-shrink-0" style="min-width: 2.5rem;">
                        <i class="fas fa-align-left text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Description</h3>
                        <p class="text-base text-justify"><?php echo nl2br(htmlspecialchars($material['material_description'])); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- File Preview -->
    <?php include "filePreviewSection.php"; ?>
</div>