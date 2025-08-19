<?php if (count($studentScores) > 0): ?>
    <div class="chart-container rounded-2xl shadow-sm border p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Student Performance Comparison</h2>
        <div class="relative h-64">
            <canvas id="resultsChart"></canvas>
        </div>
    </div>
<?php endif; ?>