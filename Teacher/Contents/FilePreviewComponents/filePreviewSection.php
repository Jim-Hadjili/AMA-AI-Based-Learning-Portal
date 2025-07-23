<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-400">
    <h2 class="text-xl font-medium mb-4">File Preview</h2>

    <div class="preview-container border border-gray-300 rounded-lg overflow-hidden">
        <?php if ($extension === 'pdf'): ?>
            <!-- PDF Preview -->
            <div id="pdf-viewer" class="w-full h-full"></div>
        <?php elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
            <!-- Image Preview -->
            <div class="flex items-center justify-center h-full bg-gray-100">
                <img src="<?php echo $file_path; ?>" alt="<?php echo htmlspecialchars($material['material_title']); ?>" class="max-w-full max-h-full object-contain">
            </div>
        <?php elseif (in_array($extension, ['mp4', 'avi', 'mov'])): ?>
            <!-- Video Preview -->
            <div class="flex items-center justify-center h-full bg-gray-900">
                <video controls class="max-w-full max-h-full">
                    <source src="<?php echo $file_path; ?>" type="video/<?php echo $extension === 'mov' ? 'quicktime' : $extension; ?>">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php else: ?>
            <!-- Other File Types -->
            <div class="flex flex-col items-center justify-center h-full bg-gray-50 text-center p-8">
                <div class="text-6xl text-gray-400 mb-4">
                    <i class="fas fa-file<?php
                                            if (in_array($extension, ['doc', 'docx'])) echo '-word';
                                            elseif (in_array($extension, ['xls', 'xlsx'])) echo '-excel';
                                            elseif (in_array($extension, ['ppt', 'pptx'])) echo '-powerpoint';
                                            else echo '';
                                            ?>"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-700 mb-2">Preview not available</h3>
                <p class="text-gray-500 mb-6">This file type cannot be previewed directly in the browser.</p>
                <a href="<?php echo $file_path; ?>" download="<?php echo htmlspecialchars($material['file_name']); ?>"
                    class="bg-purple-primary hover:bg-purple-dark text-white px-6 py-3 rounded-lg flex items-center text-base font-medium transition-all duration-200">
                    <i class="fas fa-download mr-2"></i> Download to View
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>