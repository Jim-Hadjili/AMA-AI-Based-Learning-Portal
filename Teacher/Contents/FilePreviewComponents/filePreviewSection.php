<!-- File Preview Section -->
    <div class="md:w-full bg-white rounded-2xl shadow-lg border border-white/50 mb-6 overflow-hidden">
        <div class="p-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-eye text-blue-600"></i>
                    File Preview
                </h2>
                <div class="flex flex-row gap-4">
                    <button
                        id="downloadBtn"
                        type="button"
                        class="group relative inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden mt-4 md:mt-0"
                        aria-label="Download File">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <i class="fas fa-download h-5 w-5 mr-2 pt-[2px] group-hover:rotate-90 transition-transform duration-300"></i>
                        <span class="relative">Download File</span>
                    </button>
                    <button id="deleteBtn"
                        class="group relative inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:from-red-600 hover:to-pink-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-red-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden mt-4 md:mt-0"
                        aria-label="Delete Material">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <i class="fas fa-trash-alt h-5 w-5 mr-2 pt-[2px] group-hover:rotate-90 transition-transform duration-300"></i>
                        <span class="relative">Delete Material</span>
                    </button>
                </div>
            </div>

            <div class="preview-container mt-8 border border-gray-300 rounded-lg overflow-hidden bg-white" style="height: 900px; min-height: 900px;">
                <?php if ($extension === 'pdf'): ?>
                    <!-- PDF Preview -->
                    <div id="pdf-viewer" class="w-full h-full" style="height: 100%; min-height: 900px;"></div>
                <?php elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <!-- Image Preview -->
                    <div class="flex items-center justify-center h-full bg-gray-100" style="height: 100%; min-height: 900px;">
                        <img src="<?php echo $file_path; ?>" alt="<?php echo htmlspecialchars($material['material_title']); ?>" class="max-w-full max-h-full object-contain rounded-lg shadow">
                    </div>
                <?php elseif (in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                    <!-- Video Preview -->
                    <div class="flex items-center justify-center h-full bg-gray-900" style="height: 100%; min-height: 900px;">
                        <video controls class="max-w-full max-h-full rounded-lg shadow">
                            <source src="<?php echo $file_path; ?>" type="video/<?php echo $extension === 'mov' ? 'quicktime' : $extension; ?>">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php else: ?>
                    <!-- Other File Types -->
                    <div class="flex flex-col items-center justify-center h-full bg-gray-50 text-center p-8" style="height: 100%; min-height: 900px;">
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
                            class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-lg flex items-center text-base font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-download mr-2"></i> Download to View
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>