<?php if (count($allAttempts) > 1): ?>
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
                                        'isCurrent' => ($attemptItem['attempt_id'] == $attempt_id),
                                        'date' => date('M j, Y', strtotime($attemptItem['end_time']))
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
                        label: 'Performance Score',
                        data: chartScores,
                        borderColor: '#3b82f6', // blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', // blue-500 with transparency
                        borderWidth: 3,
                        tension: 0.4,
                        pointBackgroundColor: chartData.map(item =>
                            item.isAI ? '#8b5cf6' : '#3b82f6' // purple for AI, blue for original
                        ),
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 7,
                        pointHoverRadius: 9,
                        pointHoverBackgroundColor: chartData.map(item =>
                            item.isAI ? '#7c3aed' : '#1d4ed8' // darker on hover
                        ),
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                        fill: true
                    }, {
                        label: 'Passing Threshold',
                        data: new Array(chartLabels.length).fill(65),
                        borderColor: '#10b981', // green-500
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [8, 4],
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        fill: false
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
                                    const dataIndex = context[0].dataIndex;
                                    return chartData[dataIndex].label;
                                },
                                label: function(context) {
                                    if (context.datasetIndex === 0) {
                                        const dataIndex = context.dataIndex;
                                        const item = chartData[dataIndex];
                                        const score = context.raw;
                                        const status = score >= 65 ? '✅ Passing' : '❌ Below Passing';
                                        const quizType = item.isAI ? '🤖 AI Generated' : '📝 Original Quiz';
                                        
                                        return [
                                            `Score: ${score}% (${status})`,
                                            `Type: ${quizType}`,
                                            `Date: ${item.date}`
                                        ];
                                    }
                                    return null; // Don't show tooltip for passing threshold line
                                },
                                afterBody: function(context) {
                                    const score = context[0].raw;
                                    if (score >= 90) return 'Performance: Excellent 🌟';
                                    if (score >= 80) return 'Performance: Good 👍';
                                    if (score >= 70) return 'Performance: Satisfactory ✓';
                                    if (score >= 65) return 'Performance: Passing ✓';
                                    return 'Performance: Needs Improvement 📈';
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
                                text: 'Quiz Attempts (Chronological Order)',
                                color: '#4b5563', // gray-600
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            ticks: {
                                color: '#6b7280', // gray-500
                                font: {
                                    size: 12
                                }
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
                            hoverBackgroundColor: function(context) {
                                const item = chartData[context.dataIndex];
                                return item.isAI ? '#7c3aed' : '#1d4ed8';
                            }
                        }
                    }
                }
            });
        });
    </script>
<?php endif; ?>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>