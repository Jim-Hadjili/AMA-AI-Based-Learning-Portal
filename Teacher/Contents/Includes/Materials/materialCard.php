<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl hover:border-blue-300 transition-all duration-200 cursor-pointer material-card mb-4"
     data-material-id="<?php echo $material['material_id']; ?>"
     data-material-path="<?php echo '../../../' . htmlspecialchars($material['file_path']); ?>">
    
    <div class="p-6">
        <div class="flex items-start gap-4">
            <!-- File Type Icon -->
            <div class="flex-shrink-0">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-sm
                    <?php
                    $extension = pathinfo($material['file_path'], PATHINFO_EXTENSION);
                    $iconClass = 'bg-gray-100';
                    $iconColor = 'text-gray-600';
                    $icon = 'fa-file';

                    if (in_array($extension, ['pdf'])) {
                        $iconClass = 'bg-red-100';
                        $iconColor = 'text-red-600';
                        $icon = 'fa-file-pdf';
                    } elseif (in_array($extension, ['doc', 'docx'])) {
                        $iconClass = 'bg-blue-100';
                        $iconColor = 'text-blue-600';
                        $icon = 'fa-file-word';
                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                        $iconClass = 'bg-green-100';
                        $iconColor = 'text-green-600';
                        $icon = 'fa-file-excel';
                    } elseif (in_array($extension, ['ppt', 'pptx'])) {
                        $iconClass = 'bg-orange-100';
                        $iconColor = 'text-orange-600';
                        $icon = 'fa-file-powerpoint';
                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $iconClass = 'bg-purple-100';
                        $iconColor = 'text-purple-600';
                        $icon = 'fa-file-image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                        $iconClass = 'bg-indigo-100';
                        $iconColor = 'text-indigo-600';
                        $icon = 'fa-file-video';
                    }
                    
                    echo $iconClass;
                    ?>">
                    <svg class="w-7 h-7 <?php echo $iconColor; ?>" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <?php if (in_array($extension, ['pdf'])): ?>
                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            <path d="M16 3v6a2 2 0 002 2h6"/>
                        <?php elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        <?php elseif (in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                            <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        <?php else: ?>
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        <?php endif; ?>
                    </svg>
                </div>
            </div>

            <!-- Material Information -->
            <div class="flex-1 min-w-0">
                <div class="mb-3">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1 truncate" title="<?php echo htmlspecialchars($material['material_title']); ?>">
                        <?php echo htmlspecialchars($material['material_title']); ?>
                    </h4>
                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2"/>
                            </svg>
                            <?php echo date('M j, Y', strtotime($material['upload_date'])); ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <?php echo formatFileSize($material['file_size'] ?? 0); ?>
                        </span>
                    </div>
                </div>

                <!-- File Type Badge -->
                <div class="mb-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                        <?php
                        if (in_array($extension, ['pdf'])) {
                            echo 'bg-red-100 text-red-800 border border-red-200';
                        } elseif (in_array($extension, ['doc', 'docx'])) {
                            echo 'bg-blue-100 text-blue-800 border border-blue-200';
                        } elseif (in_array($extension, ['xls', 'xlsx'])) {
                            echo 'bg-green-100 text-green-800 border border-green-200';
                        } elseif (in_array($extension, ['ppt', 'pptx'])) {
                            echo 'bg-orange-100 text-orange-800 border border-orange-200';
                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo 'bg-purple-100 text-purple-800 border border-purple-200';
                        } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                            echo 'bg-indigo-100 text-indigo-800 border border-indigo-200';
                        } else {
                            echo 'bg-gray-100 text-gray-800 border border-gray-200';
                        }
                        ?>">
                        <?php echo strtoupper($extension); ?> File
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <button class="download-material-btn inline-flex items-center px-3 py-1.5 border border-blue-300 text-xs font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200"
                            data-material-id="<?php echo $material['material_id']; ?>"
                            data-material-title="<?php echo htmlspecialchars($material['material_title']); ?>"
                            data-material-filename="<?php echo htmlspecialchars($material['file_name']); ?>"
                            data-material-path="<?php echo '../../../' . htmlspecialchars($material['file_path']); ?>"
                            title="Download material">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download
                    </button>
                    
                    <button class="delete-material-btn inline-flex items-center px-3 py-1.5 border border-red-300 text-xs font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-400 transition-colors duration-200"
                            data-material-id="<?php echo $material['material_id']; ?>"
                            data-material-title="<?php echo htmlspecialchars($material['material_title']); ?>"
                            title="Delete material">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>