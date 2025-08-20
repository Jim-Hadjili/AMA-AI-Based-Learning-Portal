<!-- Updated Quiz Tab Header Component -->
<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 mb-6">
    <div class="bg-white border-b border-gray-100 px-6 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Recent Quizzes</h3>
                    <p class="text-sm text-gray-600">Manage and track quiz performance</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-white border-2 border-indigo-200 px-4 py-2 rounded-xl shadow-sm">
                    <div class="text-center">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Quizzes</p>
                        <p class="text-xl font-bold text-indigo-600"><?php echo count($quizzes); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button id="addQuizTabBtn" type="button" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Quiz
                    </button>
                    <button id="aiQuizBtn" class="inline-flex items-center px-4 py-2 border border-purple-300 text-sm font-medium rounded-lg text-purple-700 bg-purple-50 hover:bg-purple-100 hover:border-purple-400 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        AI Generator
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quiz Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Published</p>
                <p class="text-lg font-bold text-gray-900"><?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'published'; })); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Drafts</p>
                <p class="text-lg font-bold text-gray-900"><?php echo count(array_filter($quizzes, function($q) { return $q['status'] === 'draft'; })); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Questions</p>
                <p class="text-lg font-bold text-gray-900">
                    <?php 
                    $totalQuestions = 0;
                    foreach ($quizzes as $quiz) {
                        $totalQuestions += $quiz['question_count'] ?? 0;
                    }
                    echo $totalQuestions;
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>