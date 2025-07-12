 <div id="materials-tab" class="tab-content p-6 hidden">
            <?php if (empty($materials)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Materials Yet</h3>
                    <p class="text-gray-500 mb-4">You haven't uploaded any learning materials for this class yet.</p>
                    <button id="addFirstMaterialBtn" class="px-4 py-2 bg-purple-primary text-white rounded-lg hover:bg-purple-dark transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>Upload Materials
                    </button>
                </div>
            <?php else: ?>
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="font-medium text-gray-900">Learning Materials (<?php echo count($materials); ?>)</h3>
                    <button id="addMaterialBtn" class="px-3 py-1.5 bg-purple-primary text-white rounded-md hover:bg-purple-dark text-sm">
                        <i class="fas fa-plus mr-1"></i> Add Material
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($materials as $material): ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-200 transition-colors">
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
                                            <a href="<?php echo htmlspecialchars($material['file_path']); ?>" download class="text-blue-600 hover:text-blue-900 text-sm mr-2">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button class="delete-material-btn text-red-600 hover:text-red-900 text-sm" data-material-id="<?php echo $material['material_id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>