<div id="quizDetailsModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden animate-in fade-in-0 zoom-in-95 duration-200">
        <!-- Modal Header -->
        <div class="px-8 py-6 border-b border-gray-100">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center border border-emerald-100 flex-shrink-0">
                        <i class="fas fa-question-circle text-emerald-600"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 id="modalQuizTitle" class="text-xl font-semibold text-gray-900 mb-4"></h2>
                    </div>
                </div>
                <button id="closeQuizDetailsModal" class="w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-all duration-200 flex-shrink-0 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Full Width Instructions Section -->
            <div class="mt-4">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-info-circle text-indigo-500"></i>
                    <span class="text-base font-semibold text-indigo-700">Instructions</span>
                </div>
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl px-6 py-4">
                    <p id="modalQuizDescription" class="text-sm sm:text-base text-indigo-900 leading-relaxed font-medium"></p>
                </div>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="px-8 py-2 overflow-y-auto max-h-[60vh]">
            <!-- Quiz Details Grid -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-gray-600"></i>
                    Quiz Details
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl border border-blue-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <p class="text-sm font-medium text-blue-700">Questions</p>
                        </div>
                        <p id="modalQuizQuestions" class="text-2xl font-bold"></p>
                    </div>
                    
                    <div class="p-4 rounded-2xl border border-orange-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            <p class="text-sm font-medium text-orange-700">Time Limit</p>
                        </div>
                        <p id="modalQuizTimeLimit" class="text-2xl font-bold"></p>
                    </div>
                    
                    <div class="p-4 rounded-2xl border border-purple-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                            <p class="text-sm font-medium text-purple-700">Total Score</p>
                        </div>
                        <p id="modalQuizTotalScore" class="text-2xl font-bold"></p>
                    </div>
                    
                    <div class="p-4 rounded-2xl border border-green-200">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <p class="text-sm font-medium text-green-700">Status</p>
                        </div>
                        <p id="modalQuizStatus" class="text-2xl font-bold"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/50">
            <div class="flex justify-center">
                <div class="flex gap-3">
                    <button id="cancelQuizBtn" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium border border-gray-200">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button id="takeQuizBtn" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl" data-class-id="<?php echo $class_id; ?>">
                        <i class="fas fa-play mr-2"></i>Start Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quiz Already Passed Modal -->
<?php include "quizPassedModal.php"; ?>

<script>
function closeQuizPassedModal() {
  document.getElementById("quizPassedModal").classList.add("hidden");
  document.body.classList.remove("overflow-hidden");
}
</script>