<?php if (count($attempts) > 0): ?>
    <script>
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const chartLabels = <?php echo $chartLabelsJson; ?>;
        const chartScores = <?php echo $chartScoresJson; ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Score (%)',
                    data: chartScores,
                    borderColor: '#0ea5e9', // accent-500
                    backgroundColor: 'rgba(14, 165, 233, 0.1)', // accent-500 with transparency
                    borderWidth: 2,
                    tension: 0.4, // Smooth the line
                    pointBackgroundColor: '#0ea5e9',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true, // Fill area under the line
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide legend as there's only one dataset
                    },
                    title: {
                        display: false, // Title is already in H2 tag
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Hide x-axis grid lines
                        },
                        title: {
                            display: true,
                            text: 'Attempt Number',
                            color: '#4b5563' // gray-600
                        },
                        ticks: {
                            color: '#4b5563' // gray-600
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + '%';
                            },
                            color: '#4b5563' // gray-600
                        },
                        grid: {
                            color: '#e5e7eb' // gray-200
                        },
                        title: {
                            display: true,
                            text: 'Score',
                            color: '#4b5563' // gray-600
                        }
                    }
                }
            }
        });
    </script>
<?php endif; ?>