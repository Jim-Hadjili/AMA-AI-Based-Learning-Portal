<div id="retakeQuizModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center relative animate-in fade-in-0 zoom-in-95 duration-200">
        <!-- Accent Icon -->
        <div class="mb-6 mt-2 flex justify-center">
            <i class="fas fa-exclamation-circle text-red-500 text-5xl drop-shadow"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">
            Quiz Failed
        </h2>
        <p class="text-gray-700 mb-6">
            You did not pass your last attempt for this quiz.<br>
            Would you like to retake it with new AI-generated questions?
        </p>
        <div class="flex justify-center gap-3">
            <button onclick="closeRetakeQuizModal()" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium flex items-center gap-2 transition-colors duration-200">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button id="retakeQuizConfirmBtn" class="px-5 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-xl font-medium flex items-center gap-2 shadow transition-colors duration-200">
                <i class="fas fa-redo-alt"></i>
                Retake Quiz
            </button>
        </div>
    </div>
</div>