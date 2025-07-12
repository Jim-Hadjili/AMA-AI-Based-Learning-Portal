<div id="materialUploadModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Upload Learning Material</h3>
            <button type="button" id="closeMaterialModalBtn" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="materialUploadForm" enctype="multipart/form-data">
            <div class="px-6 py-4">
                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                
                <div class="mb-4">
                    <label for="material_title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="material_title" id="material_title" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>
                
                <div class="mb-4">
                    <label for="material_description" class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                    <textarea name="material_description" id="material_description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500"></textarea>
                </div>
                
                <div class="mb-2">
                    <label for="material_file" class="block text-sm font-medium text-gray-700 mb-1">File</label>
                    <div class="flex items-center justify-center w-full">
                        <!-- Change to a div, not a label -->
                        <div class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-md shadow-sm border border-gray-300 border-dashed cursor-pointer hover:bg-gray-50" id="file-upload-area">
                            <div id="file-upload-icon" class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl"></i>
                                <p class="mt-2 text-sm text-gray-600">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, images, video files</p>
                            </div>
                            <div id="file-preview" class="hidden w-full">
                                <div class="flex items-center p-2">
                                    <div id="file-icon" class="mr-2 text-blue-600"></div>
                                    <div class="flex-1 truncate">
                                        <span id="file-name" class="text-sm font-medium text-gray-900"></span>
                                        <span id="file-size" class="block text-xs text-gray-500"></span>
                                    </div>
                                    <button type="button" id="remove-file-btn" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <input id="material_file" name="material_file" type="file" class="hidden" required>
                        </div>
                    </div>
                    <div id="file-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
                <button type="button" id="cancelMaterialUploadBtn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-primary hover:bg-purple-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Upload
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