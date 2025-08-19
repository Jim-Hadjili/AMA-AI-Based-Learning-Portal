<?php if (count($studentScores) > 0): ?>
    <div class="w-full mb-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Chart Header -->
            <div class="bg-white border-b border-gray-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Student Performance Analysis</h2>
                        <p class="text-sm text-gray-600">Visual comparison of individual student scores across all attempts</p>
                    </div>
                </div>
            </div>
            
            <!-- Chart Content -->
            <div class="p-6">
                <div class="relative h-80 bg-gray-50 rounded-lg p-4">
                    <canvas id="resultsChart"></canvas>
                </div>
                
                <!-- Chart Legend -->
                <div class="mt-4 flex items-center justify-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span>Student Scores</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span>Passing Scores (65%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>