<div id="materialUploadModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-100 transform transition-all duration-300">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h3 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-file-upload text-purple-600"></i>
                </span>
                Upload Learning Material
            </h3>
            <button type="button" id="closeMaterialModalBtn" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="materialUploadForm" enctype="multipart/form-data" class="px-6 py-6 bg-white rounded-b-2xl"">
            <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
            <div class="space-y-4">
                <div>
                    <label for="material_title" class="block text-sm font-medium text-gray-700 mb-1">Title<span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-heading text-gray-400"></i>
                        </div>
                        <input type="text" name="material_title" id="material_title" required 
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors">
                    </div>
                </div>
                <div>
                    <label for="material_description" class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                            <i class="fas fa-align-left text-gray-400"></i>
                        </div>
                        <textarea name="material_description" id="material_description" rows="3"
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors"></textarea>
                    </div>
                </div>
                <div>
                    <label for="material_file" class="block text-sm font-medium text-gray-700 mb-1">File<span class="text-red-500">*</span></label>
                    <div class="flex items-center justify-center w-full">
                        <!-- File upload area -->
                        <div class="w-full flex flex-col items-center p-5 bg-gray-50 rounded-lg shadow-sm border-2 border-dashed border-gray-300 cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all duration-200" id="file-upload-area">
                            <div id="file-upload-icon" class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mb-3">
                                    <i class="fas fa-cloud-upload-alt text-purple-600 text-2xl"></i>
                                </div>
                                <p class="font-medium text-sm text-gray-700">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500 mt-1.5 text-center">
                                    PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, images, video files
                                    <br>
                                    <span class="text-purple-600">Maximum size: 50MB</span>
                                </p>
                            </div>
                            <div id="file-preview" class="hidden w-full mt-3">
                                <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
                                    <div id="file-icon" class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3 text-blue-600"></div>
                                    <div class="flex-1 truncate">
                                        <span id="file-name" class="text-sm font-medium text-gray-900 block"></span>
                                        <span id="file-size" class="text-xs text-gray-500"></span>
                                    </div>
                                    <button type="button" id="remove-file-btn" class="ml-2 w-8 h-8 flex items-center justify-center rounded-full text-red-500 hover:bg-red-50 hover:text-red-700 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <input id="material_file" name="material_file" type="file" class="hidden" required>
                        </div>
                    </div>
                    <div id="file-error" class="mt-2 text-sm text-red-600 hidden flex items-center">
                        <i class="fas fa-exclamation-circle mr-1.5"></i>
                        <span id="file-error-message"></span>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancelMaterialUploadBtn" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    <i class="fas fa-times mr-1.5"></i>Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-upload mr-1.5"></i>Upload
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set up the file upload area click handler
    const fileUploadArea = document.getElementById('file-upload-area');
    const materialFileInput = document.getElementById('material_file');
    
    if (fileUploadArea && materialFileInput) {
        fileUploadArea.addEventListener('click', function() {
            materialFileInput.click();
        });
    }
});
</script>