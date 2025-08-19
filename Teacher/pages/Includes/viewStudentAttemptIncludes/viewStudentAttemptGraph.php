<?php if (count($allAttempts) > 1): ?>
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
        <div class="border-b border-gray-200 px-6 py-5">
            <h2 class="text-xl font-semibold text-gray-900">Performance Trend</h2>
        </div>
        <div class="p-6">
            <div class="relative h-64">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('performanceChart').getContext('2d');

            // Prepare data for the chart - sort by attempt number for chronological display
            const chartData = <?php
                                // Create an array with attempt numbers and scores in chronological order
                                $chronologicalAttempts = array_values($allAttempts);
                                usort($chronologicalAttempts, function ($a, $b) {
                                    return $a['attempt_number'] - $b['attempt_number'];
                                });

                                $chartData = array_map(function ($attemptItem) use ($conn, $attempt_id) {
                                    // Get total points for this quiz
                                    $quizPointsStmt = $conn->prepare("
                                SELECT SUM(question_points) AS total_points 
                                FROM quiz_questions_tb 
                                WHERE quiz_id = ?
                            ");
                                    $quizPointsStmt->bind_param("i", $attemptItem['quiz_id']);
                                    $quizPointsStmt->execute();
                                    $quizPointsResult = $quizPointsStmt->get_result();
                                    $quizPointsRow = $quizPointsResult->fetch_assoc();
                                    $totalPossiblePoints = $quizPointsRow['total_points'] ?? 0;
                                    if ($totalPossiblePoints == 0) $totalPossiblePoints = 1;

                                    return [
                                        'label' => "Attempt " . $attemptItem['attempt_number'],
                                        'score' => round(($attemptItem['score'] / $totalPossiblePoints) * 100),
                                        'isAI' => !empty($attemptItem['parent_quiz_id']),
                                        'isCurrent' => ($attemptItem['attempt_id'] == $attempt_id)
                                    ];
                                }, $chronologicalAttempts);

                                echo json_encode($chartData);
                                ?>;

            // Extract labels and scores
            const chartLabels = chartData.map(item => item.label);
            const chartScores = chartData.map(item => item.score);

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
                        pointBackgroundColor: chartData.map(item =>
                            item.isAI ? '#8b5cf6' : '#0ea5e9' // purple for AI, blue for original
                        ),
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true // Fill area under the line
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend since we only have one data series
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = `Score: ${context.raw}%`;
                                    if (chartData[context.dataIndex].isAI) {
                                        label += ' (AI Generated)';
                                    }
                                    return label;
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
                                color: '#4b5563', // gray-600
                                font: {
                                    size: 14
                                }
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
                                text: 'Score (%)',
                                color: '#4b5563', // gray-600
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
<?php endif; ?>