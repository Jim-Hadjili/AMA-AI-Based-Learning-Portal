<div id="retakeQuizModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full text-center">
        <h2 class="text-xl font-bold text-red-600 mb-2">Quiz Failed</h2>
        <p class="text-gray-700 mb-4">You did not pass your last attempt for this quiz.<br>Would you like to retake it with new questions?</p>
        <div class="flex justify-center gap-4 mt-6">
            <button onclick="closeRetakeQuizModal()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">Cancel</button>
            <button id="retakeQuizConfirmBtn" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold">Retake Quiz</button>
        </div>
    </div>
</div>