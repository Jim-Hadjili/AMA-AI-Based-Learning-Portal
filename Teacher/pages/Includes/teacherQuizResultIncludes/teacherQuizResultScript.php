<?php if (count($studentScores) > 0): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('resultsChart').getContext('2d');
            const chartLabels = <?php echo $chartLabelsJson; ?>;
            const chartData = <?php echo $chartDataJson; ?>;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Student Score',
                        data: chartData,
                        borderColor: '#3b82f6', // blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', // blue-500 with transparency
                        borderWidth: 3,
                        tension: 0.4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#1d4ed8', // blue-700
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                        fill: true,
                    }, {
                        label: 'Passing Threshold',
                        data: new Array(chartLabels.length).fill(65),
                        borderColor: '#10b981', // green-500
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1f2937', // gray-800
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#374151', // gray-700
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                title: function(context) {
                                    return 'Student: ' + chartLabels[context[0].dataIndex];
                                },
                                label: function(context) {
                                    if (context.datasetIndex === 0) {
                                        const score = context.raw;
                                        const status = score >= 65 ? '✅ Passing' : '❌ Below Passing';
                                        return `Score: ${score}% (${status})`;
                                    }
                                    return null; // Don't show tooltip for passing threshold line
                                },
                                afterBody: function(context) {
                                    const score = context[0].raw;
                                    if (score >= 90) return 'Grade: Excellent (A)';
                                    if (score >= 80) return 'Grade: Good (B)';
                                    if (score >= 70) return 'Grade: Satisfactory (C)';
                                    if (score >= 65) return 'Grade: Passing (D)';
                                    return 'Grade: Needs Improvement (F)';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                color: '#d1d5db' // gray-300
                            },
                            title: {
                                display: true,
                                text: 'Students',
                                color: '#4b5563', // gray-600
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            ticks: {
                                display: false,
                                color: '#6b7280' // gray-500
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            border: {
                                color: '#d1d5db' // gray-300
                            },
                            grid: {
                                color: '#e5e7eb', // gray-200
                                lineWidth: 1
                            },
                            title: {
                                display: true,
                                text: 'Score Percentage (%)',
                                color: '#4b5563', // gray-600
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            ticks: {
                                stepSize: 10,
                                color: '#6b7280', // gray-500
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverBackgroundColor: '#1d4ed8' // blue-700
                        }
                    }
                }
            });
        });
    </script>
<?php endif; ?>

<!-- Alpine.js for interactive components -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>