<div id="quizPassedModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center relative">
        <!-- Accent Bar -->
        <div class="mb-6 mt-4">
            <i class="fas fa-check-circle text-emerald-500 text-5xl drop-shadow"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">
            Quiz Already Passed
        </h2>

        <div class="mb-4 text-gray-700 ">
            <p class="mb-2">
                You have already passed this quiz.
            </p>
            <p class="mb-2 hidden">
                <span class="font-semibold">Score:</span>
                <span id="quizPassedScore" class="text-emerald-600 font-bold">0</span>
            </p>
            <p class="mb-2 hidden">
                <span class="font-semibold">Attempts:</span>
                <span id="quizPassedAttempts" class="text-blue-600 font-bold">1</span>
            </p>
            <p>
                You can view your quiz results, check your answers, and see your attempt history by clicking the <span class="font-semibold text-blue-600">View Result</span> button below.
            </p>
        </div>

        <div class="flex justify-center gap-3">
            <button onclick="closeQuizPassedModal()" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium flex items-center gap-2 transition-colors duration-200">
                <i class="fas fa-times"></i>
                Close
            </button>

            <button id="quizPassedViewResultBtn" class="px-5 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-xl font-medium flex items-center gap-2 shadow transition-colors duration-200">
                <i class="fas fa-eye"></i>
                View Result
            </button>
        </div>
    </div>
</div>