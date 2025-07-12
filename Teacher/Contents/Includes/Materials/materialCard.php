<div class="border border-gray-200 rounded-lg p-4 hover:border-purple-200 transition-colors cursor-pointer material-card"
     data-material-id="<?php echo $material['material_id']; ?>"
     data-material-path="<?php echo '../../../' . htmlspecialchars($material['file_path']); ?>">
    <div class="flex items-start">
        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
            <?php
            $extension = pathinfo($material['file_path'], PATHINFO_EXTENSION);
            $icon = 'fa-file';
            
            if (in_array($extension, ['pdf'])) {
                $icon = 'fa-file-pdf';
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $icon = 'fa-file-word';
            } elseif (in_array($extension, ['xls', 'xlsx'])) {
                $icon = 'fa-file-excel';
            } elseif (in_array($extension, ['ppt', 'pptx'])) {
                $icon = 'fa-file-powerpoint';
            } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $icon = 'fa-file-image';
            } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                $icon = 'fa-file-video';
            }
            ?>
            <i class="fas <?php echo $icon; ?> text-blue-600"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-medium text-gray-900 mb-1"><?php echo htmlspecialchars($material['material_title']); ?></h4>
            <p class="text-xs text-gray-500 mb-2"><?php echo date('M d, Y', strtotime($material['upload_date'])); ?></p>
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500"><?php echo formatFileSize($material['file_size'] ?? 0); ?></span>
                <div>
                    <button class="download-material-btn text-blue-600 hover:text-blue-900 text-sm mr-2" 
                            data-material-id="<?php echo $material['material_id']; ?>"
                            data-material-title="<?php echo htmlspecialchars($material['material_title']); ?>"
                            data-material-filename="<?php echo htmlspecialchars($material['file_name']); ?>"
                            data-material-path="<?php echo '../../../' . htmlspecialchars($material['file_path']); ?>">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="delete-material-btn text-red-600 hover:text-red-900 text-sm" 
                            data-material-id="<?php echo $material['material_id']; ?>"
                            data-material-title="<?php echo htmlspecialchars($material['material_title']); ?>">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>