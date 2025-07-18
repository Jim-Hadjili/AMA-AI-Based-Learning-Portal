<div id="quizDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <i class="fas fa-question-circle text-green-600"></i>
                    </div>
                    <div>
                        <h2 id="modalQuizTitle" class="text-xl font-semibold text-gray-900"></h2>
                        <p id="modalQuizDescription" class="text-sm text-gray-600 mt-1"></p>
                    </div>
                </div>
                <button id="closeQuizDetailsModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <div>
                    <p class="font-medium">Questions:</p>
                    <p id="modalQuizQuestions" class="text-lg font-bold"></p>
                </div>
                <div>
                    <p class="font-medium">Time Limit:</p>
                    <p id="modalQuizTimeLimit" class="text-lg font-bold"></p>
                </div>
                <div>
                    <p class="font-medium">Total Score:</p>
                    <p id="modalQuizTotalScore" class="text-lg font-bold"></p>
                </div>
                <div>
                    <p class="font-medium">Status:</p>
                    <p id="modalQuizStatus" class="text-lg font-bold"></p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200 bg-gray-50 flex justify-end space-x-3">
            <button id="cancelQuizBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Cancel
            </button>
            <button id="takeQuizBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Take Quiz
            </button>
        </div>
    </div>
</div>