<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Material Preview</h2>
                <p class="text-sm text-gray-600">Preview and access your learning material</p>
            </div>
            <a href="<?php echo $webFilePath; ?>" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-all duration-200 hover:shadow-lg hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Full Material
            </a>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8">
        <?php if (!$fileExists): ?>
            <!-- File Not Found State -->
            <div class="text-center py-16">
                <div class="w-16 h-16 mx-auto mb-6 bg-red-50 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">File Not Found</h3>
                <p class="text-gray-600 max-w-sm mx-auto">The requested file could not be found on the server. Please check if the file exists or contact support.</p>
            </div>

        <?php elseif ($canPreview): ?>
            <!-- Preview Content -->
            <div class="rounded-xl border border-gray-200 overflow-hidden bg-gray-50">
                <?php if (strtolower($materialDetails['file_type']) === 'pdf'): ?>
                    <!-- PDF Preview -->
                    <div id="pdf-viewer" class="w-full min-h-[500px] bg-white"></div>
                    
                <?php elseif (in_array(strtolower($materialDetails['file_type']), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <!-- Image Preview -->
                    <div class="flex items-center justify-center p-4 bg-white">
                        <img src="<?php echo $webFilePath; ?>"
                             alt="<?php echo htmlspecialchars($materialDetails['material_title']); ?>"
                             class="max-w-full max-h-[600px] object-contain rounded-lg shadow-sm">
                    </div>
                    
                <?php elseif (strtolower($materialDetails['file_type']) === 'txt'): ?>
                    <!-- Text Preview -->
                    <div class="p-6 bg-white max-h-[500px] overflow-y-auto">
                        <pre class="whitespace-pre-wrap text-sm text-gray-800 font-mono leading-relaxed"><?php echo htmlspecialchars(file_get_contents($serverFilePath)); ?></pre>
                    </div>
                    
                <?php elseif (in_array(strtolower($materialDetails['file_type']), ['mp4', 'avi', 'mov'])): ?>
                    <!-- Video Preview -->
                    <div class="flex items-center justify-center p-6 bg-gray-900 rounded-xl">
                        <video controls class="max-w-full max-h-[500px] rounded-lg shadow-lg">
                            <source src="<?php echo $webFilePath; ?>" type="video/<?php echo strtolower($materialDetails['file_type']) === 'mov' ? 'quicktime' : strtolower($materialDetails['file_type']); ?>">
                            <div class="text-white text-center p-8">
                                <p>Your browser does not support the video tag.</p>
                            </div>
                        </video>
                    </div>
                <?php endif; ?>
            </div>
            
        <?php else: ?>
            <!-- Preview Not Available State -->
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class="<?php echo $materialDetails['file_icon']; ?> text-blue-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Preview Not Available</h3>
                <p class="text-gray-600 mb-2 max-w-md mx-auto">This file type cannot be previewed directly in the browser.</p>
                <p class="text-sm text-gray-500 mb-8">Supported formats: PDF, Images (JPG, PNG, GIF), Text files, Videos</p>
                
                <a href="<?php echo $webFilePath; ?>"
                   download="<?php echo $materialDetails['file_name']; ?>"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-all duration-200 hover:shadow-lg hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download to View
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>