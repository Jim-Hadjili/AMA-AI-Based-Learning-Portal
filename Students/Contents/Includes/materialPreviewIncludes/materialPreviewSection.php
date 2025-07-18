<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">File Preview</h2>
    </div>
    <div class="p-6">
        <?php if (!$fileExists): ?>
            <div class="text-center py-12">
                <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">File Not Found</h3>
                <p class="text-gray-500">The requested file could not be found on the server.</p>
            </div>
        <?php elseif ($canPreview): ?>
            <div class="border rounded-lg overflow-hidden">
                <?php if (strtolower($materialDetails['file_type']) === 'pdf'): ?>
                    <!-- PDF Preview -->
                    <div id="pdf-viewer" class="w-full h-full"></div>
                <?php elseif (in_array(strtolower($materialDetails['file_type']), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <img src="<?php echo $webFilePath; ?>"
                        alt="<?php echo htmlspecialchars($materialDetails['material_title']); ?>"
                        class="w-full h-auto max-h-96 object-contain bg-gray-50">
                <?php elseif (strtolower($materialDetails['file_type']) === 'txt'): ?>
                    <div class="p-4 bg-gray-50 max-h-96 overflow-y-auto">
                        <pre class="whitespace-pre-wrap text-sm text-gray-800"><?php echo htmlspecialchars(file_get_contents($serverFilePath)); ?></pre>
                    </div>
                <?php elseif (in_array(strtolower($materialDetails['file_type']), ['mp4', 'avi', 'mov'])): ?>
                    <!-- Video Preview -->
                    <div class="flex items-center justify-center h-full bg-gray-900">
                        <video controls class="max-w-full max-h-full">
                            <source src="<?php echo $webFilePath; ?>" type="video/<?php echo strtolower($materialDetails['file_type']) === 'mov' ? 'quicktime' : strtolower($materialDetails['file_type']); ?>">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="<?php echo $materialDetails['file_icon']; ?> text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Preview Not Available</h3>
                <p class="text-gray-500 mb-4">This file type cannot be previewed in the browser.</p>
                <p class="text-sm text-gray-400 mb-4">Supported preview formats: PDF, Images (JPG, PNG, GIF), Text files</p>
                <a href="<?php echo $webFilePath; ?>"
                    download="<?php echo $materialDetails['file_name']; ?>"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>Download to View
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>