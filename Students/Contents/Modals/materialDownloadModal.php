<div id="downloadConfirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 z-50 flex items-center justify-center hidden backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 border border-gray-200 transform transition-all duration-300">
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white rounded-t-xl">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                    <i class="fas fa-file-download text-blue-600"></i>
                </span>
                Confirm Download
            </h3>
            <button type="button" id="closeDownloadModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 rounded-full p-1 hover:bg-gray-100">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="px-6 py-5">
            <div class="flex items-start">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-download text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-blue-600 mb-2">Download Material</h4>
                    <p class="text-gray-700 mb-2">You're about to download:</p>
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg mb-3 flex items-center">
                        <i class="fas fa-file-alt text-blue-500 mr-3"></i>
                        <p class="font-medium text-gray-900" id="materialTitleToDownload"></p>
                    </div>
                    <p class="text-sm text-gray-500 flex items-center">
                        <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                        Click "Download" to continue or "Cancel" to go back.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-xl border-t border-gray-200">
            <button type="button" id="cancelDownloadBtn" class="py-2 px-4 rounded-lg hover:bg-gray-200  font-medium transition-colors shadow-md flex items-center">
                <i class="fas fa-times mr-2"></i>Cancel
            </button>
            <button type="button" id="confirmDownloadBtn" class="py-2 px-4 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-medium transition-colors shadow-md flex items-center">
                <i class="fas fa-download mr-2"></i>Download
            </button>
        </div>
    </div>
</div>