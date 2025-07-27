<div id="quizPassedModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle text-emerald-500 text-5xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-900 mb-2">Quiz Already Passed</h2>
        <p class="text-gray-700 mb-4">You have already passed this quiz.<br>Your score: <span id="quizPassedScore" class="font-bold"></span></p>
        <div class="flex justify-center gap-3">
            <button id="quizPassedViewResultBtn" class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium flex items-center gap-2">
            <i class="fas fa-eye"></i>
            View Result
            </button>
            <button onclick="closeQuizPassedModal()" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium flex items-center gap-2">
            <i class="fas fa-times"></i>
            Close
            </button>
        </div>
    </div>
</div>