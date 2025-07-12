<!-- Download Confirmation Modal -->
<div id="downloadConfirmationModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Confirm Download</h3>
            <button type="button" id="closeDownloadModalBtn" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center mb-4 text-blue-600">
                <i class="fas fa-download text-xl mr-3"></i>
                <span class="text-lg font-medium">Download Material</span>
            </div>
            <p class="text-gray-700">You're about to download:</p>
            <p class="font-medium text-gray-900 mt-1" id="materialTitleToDownload"></p>
            <p class="text-sm text-gray-500 mt-2">Click "Download" to continue or "Cancel" to go back.</p>
        </div>
        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
            <button type="button" id="cancelDownloadBtn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" id="confirmDownloadBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Download
            </button>
        </div>
    </div>
</div>