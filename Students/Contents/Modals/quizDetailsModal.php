<div id="quizDetailsModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden animate-in fade-in-0 zoom-in-95 duration-200">
        <!-- Modal Header -->
        <div class="px-8 py-6 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center border border-emerald-100">
                        <i class="fas fa-question-circle text-emerald-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 id="modalQuizTitle" class="text-xl font-semibold text-gray-900 mb-2"></h2>
                        <p id="modalQuizDescription" class="text-sm text-gray-600 leading-relaxed"></p>
                    </div>
                </div>
                <button id="closeQuizDetailsModal" class="w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="px-8 py-6 overflow-y-auto max-h-[60vh]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 rounded-2xl">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <p class="text-sm font-medium text-gray-600">Questions</p>
                    </div>
                    <p id="modalQuizQuestions" class="text-2xl font-semibold text-gray-900"></p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-2xl">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                        <p class="text-sm font-medium text-gray-600">Time Limit</p>
                    </div>
                    <p id="modalQuizTimeLimit" class="text-2xl font-semibold text-gray-900"></p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-2xl">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                        <p class="text-sm font-medium text-gray-600">Total Score</p>
                    </div>
                    <p id="modalQuizTotalScore" class="text-2xl font-semibold text-gray-900"></p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-2xl">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                    </div>
                    <p id="modalQuizStatus" class="text-2xl font-semibold text-gray-900"></p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3">
            <button id="cancelQuizBtn" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium">
                Cancel
            </button>
            <button id="takeQuizBtn" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 font-medium shadow-sm">
                Take Quiz
            </button>
        </div>
    </div>
</div>