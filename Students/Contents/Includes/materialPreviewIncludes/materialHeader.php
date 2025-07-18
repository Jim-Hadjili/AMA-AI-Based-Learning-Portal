<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
    <div class="h-3 bg-gradient-to-r <?php echo $style['strip']; ?>"></div>
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center">
                <div class="inline-block p-4 rounded-lg bg-blue-100 mr-4">
                    <i class="<?php echo $materialDetails['file_icon']; ?> text-2xl text-blue-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($materialDetails['material_title']); ?></h1>
                    <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($materialDetails['material_description'] ?? 'No description provided.'); ?></p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-file mr-1"></i><?php echo htmlspecialchars($materialDetails['file_name']); ?></span>
                        <span><i class="fas fa-hdd mr-1"></i><?php echo $materialDetails['formatted_file_size']; ?></span>
                        <span><i class="fas fa-calendar mr-1"></i><?php echo date('M j, Y', strtotime($materialDetails['upload_date'])); ?></span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-end space-y-2">
                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                    <?php echo strtoupper($materialDetails['file_type']); ?>
                </span>
                <?php if ($fileExists): ?>
                    <button id="downloadBtn" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                        <i class="fas fa-download mr-2"></i>Download
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>