<?php if (count($allAttempts) > 1): ?>
    <div class="w-full mb-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <!-- Chart Header -->
            <div class="bg-white border-b border-gray-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Performance Progress</h2>
                        <p class="text-sm text-gray-600">Track improvement across all quiz attempts over time</p>
                    </div>
                </div>
            </div>
            
            <!-- Chart Content -->
            <div class="p-6">
                <div class="relative h-80 bg-gray-50 rounded-lg p-4">
                    <canvas id="performanceChart"></canvas>
                </div>
                
                <!-- Chart Legend -->
                <div class="mt-4 flex items-center justify-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span>Original Quiz</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                        <span>AI Generated</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span>Passing Score (65%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>