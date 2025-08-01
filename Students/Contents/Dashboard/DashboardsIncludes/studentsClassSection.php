<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-900">My Classes</h2>
        <div class="flex items-center space-x-4">
        </div>

        <button onclick="showClassSearchModal()" type="button"
            class="inline-flex items-center justify-center space-x-2 py-3 px-5 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" fill="none" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            <div class="font-semibold">Search Enrolled Classes</div>
        </button>

    </div>

    <?php
    // Define status colors for the badges
    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-red-100 text-red-800',
        'archived' => 'bg-gray-100 text-gray-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
    ];

    // Define subject-specific styles
    $subjectStyles = [
        'English' => [
            'strip' => 'from-blue-500 to-blue-700',
            'icon_bg' => 'bg-blue-100',
            'icon_color' => 'text-blue-600',
            'icon_class' => 'fas fa-book-reader'
        ],
        'Math' => [
            'strip' => 'from-green-500 to-green-700',
            'icon_bg' => 'bg-green-100',
            'icon_color' => 'text-green-600',
            'icon_class' => 'fas fa-calculator'
        ],
        'Science' => [
            'strip' => 'from-purple-500 to-purple-700',
            'icon_bg' => 'bg-purple-100',
            'icon_color' => 'text-purple-600',
            'icon_class' => 'fas fa-flask'
        ],
        'History' => [
            'strip' => 'from-yellow-500 to-yellow-700',
            'icon_bg' => 'bg-yellow-100',
            'icon_color' => 'text-yellow-600',
            'icon_class' => 'fas fa-landmark'
        ],
        'Arts' => [
            'strip' => 'from-pink-500 to-pink-700',
            'icon_bg' => 'bg-pink-100',
            'icon_color' => 'text-pink-600',
            'icon_class' => 'fas fa-paint-brush'
        ],
        'PE' => [
            'strip' => 'from-red-500 to-red-700',
            'icon_bg' => 'bg-red-100',
            'icon_color' => 'text-red-600',
            'icon_class' => 'fas fa-running'
        ],
        'ICT' => [ // Assuming TVL-ICT maps to ICT subject
            'strip' => 'from-indigo-500 to-indigo-700',
            'icon_bg' => 'bg-indigo-100',
            'icon_color' => 'text-indigo-600',
            'icon_class' => 'fas fa-laptop-code'
        ],
        'Home Economics' => [ // Assuming TVL-HE maps to Home Economics
            'strip' => 'from-orange-500 to-orange-700',
            'icon_bg' => 'bg-orange-100',
            'icon_color' => 'text-orange-600',
            'icon_class' => 'fas fa-utensils'
        ],
        // Default style for subjects not explicitly listed
        'Default' => [
            'strip' => 'from-gray-500 to-gray-700',
            'icon_bg' => 'bg-gray-100',
            'icon_color' => 'text-gray-600',
            'icon_class' => 'fas fa-graduation-cap'
        ]
    ];
    ?>



    <?php if (empty($enrolledClasses)): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="inline-block mb-4 p-4 bg-blue-50 rounded-full">
                <i class="fas fa-graduation-cap text-blue-500 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Classes Yet</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">You haven't enrolled in any classes yet. Join a class using the class code provided by your teacher.</p>
            <button onclick="showJoinClassModal()" class="bg-blue-primary hover:bg-blue-dark text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-search mr-2"></i> Join Your First Class
            </button>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $totalClasses = count($enrolledClasses);
            $initialDisplayCount = 6;
            $hasMoreClasses = ($totalClasses > $initialDisplayCount);

            foreach ($enrolledClasses as $index => $class):
                $isHidden = ($index >= $initialDisplayCount) ? 'hidden' : '';
                $description = !empty($class['class_description']) ? $class['class_description'] : 'No description provided.';
                $strand = !empty($class['strand']) ? $class['strand'] : 'N/A';
                $studentCount = $class['student_count'] ?? 0; // Use fetched count
                $quizCount = $class['quiz_count'] ?? 0; // Use fetched count

                // Determine subject-specific styles using the derived class_subject
                $subject = $class['class_subject'] ?? 'Default';
                $style = $subjectStyles[$subject] ?? $subjectStyles['Default'];
            ?>
                <a href="../Pages/classDetails.php?class_id=<?php echo $class['class_id']; ?>"
                    class="group relative overflow-hidden bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 class-card <?php echo $isHidden; ?>"
                    data-index="<?php echo $index; ?>">
                    <!-- Class Card Header with Color Strip -->
                    <div class="h-2 bg-gradient-to-r <?php echo $style['strip']; ?>"></div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <!-- Subject Icon -->
                            <div class="inline-block p-3 rounded-full <?php echo $style['icon_bg']; ?> mr-3">
                                <i class="<?php echo $style['icon_class']; ?> text-xl <?php echo $style['icon_color']; ?>"></i>
                            </div>
                            <h3 class="font-semibold text-lg text-gray-900 flex-grow"><?php echo htmlspecialchars($class['class_name']); ?></h3>
                            <span class="px-2 py-1 text-xs rounded-full <?php echo isset($statusColors[$class['status']]) ? $statusColors[$class['status']] : $statusColors['inactive']; ?>">
                                <?php echo ucfirst($class['status']); ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo htmlspecialchars($description); ?></p>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="bg-gray-50 p-2 rounded">
                                <p class="text-xs text-gray-500">Grade</p>
                                <p class="font-medium text-sm text-gray-800">Grade <?php echo htmlspecialchars($class['grade_level']); ?></p>
                            </div>
                            <div class="bg-gray-50 p-2 rounded">
                                <p class="text-xs text-gray-500">Strand</p>
                                <p class="font-medium text-sm text-gray-800"><?php echo htmlspecialchars($strand); ?></p>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-users mr-2 <?php echo $style['icon_color']; ?>"></i>
                                <span><?php echo $studentCount; ?> Students</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-book mr-2 <?php echo $style['icon_color']; ?>"></i>
                                <span><?php echo $quizCount; ?> Quizzes</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-key mr-1"></i>
                                Code: <span class="font-mono font-medium"><?php echo htmlspecialchars($class['class_code']); ?></span>
                            </div>
                            <div class="text-purple-primary hover:text-purple-dark text-sm font-medium">
                                View Class <i class="fas fa-arrow-right ml-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($hasMoreClasses): ?>
            <div class="text-center mt-4">
                <button type="button"
                    onclick="window.location.href='../Pages/studentAllClasses.php'"
                    class="inline-flex items-center justify-center space-x-2 py-3 px-6 border border-blue-600 text-sm font-semibold rounded-lg text-blue-700 hover:text-white bg-blue-50 hover:bg-blue-600 transition-colors shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="font-semibold">View All Classes</span>
                    <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full text-xs font-bold ml-2">
                        <?php echo $totalClasses; ?>
                    </span>
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Modal for searching classes -->
<div id="classSearchModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Search Enrolled Classes</h3>
        <input type="text" placeholder="Type class name..." class="w-full border rounded px-3 py-2 mb-4" />
        <button onclick="closeClassSearchModal()" class="bg-blue-600 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>

<!-- Student Search Enrolled Classes Modal -->
<div id="studentSearchClassModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-100 modal-content">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Search Enrolled Classes</h3>
            <button onclick="closeStudentSearchModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="relative mb-6">
            <input
                autocomplete="off"
                type="text"
                id="studentClassSearchInput"
                placeholder="Search by class name..."
                class="w-full pl-12 pr-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
            >
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
        </div>
        <div id="studentSearchResults" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
            <div class="p-6 text-center text-gray-500 text-lg">Start typing to search for your classes.</div>
        </div>
    </div>
</div>

<script>
    function showClassSearchModal() {
        document.getElementById('studentSearchClassModal').classList.remove('hidden');
        document.getElementById('studentClassSearchInput').value = "";
        document.getElementById('studentSearchResults').innerHTML =
            '<div class="p-6 text-center text-gray-500 text-lg">Start typing to search for your classes.</div>';
    }
    function closeStudentSearchModal() {
        document.getElementById('studentSearchClassModal').classList.add('hidden');
    }

    // Debounced search
    let studentSearchDebounceTimeout;
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("studentClassSearchInput");
        const searchResultsContainer = document.getElementById("studentSearchResults");

        searchInput.addEventListener("input", function () {
            clearTimeout(studentSearchDebounceTimeout);
            const query = this.value;

            if (query.length < 2) {
                searchResultsContainer.innerHTML =
                    '<div class="p-6 text-center text-gray-500 text-lg">Type at least 2 characters to search.</div>';
                return;
            }

            searchResultsContainer.innerHTML =
                '<div class="p-6 text-center text-blue-500"><i class="fas fa-spinner fa-spin mr-2"></i> Searching...</div>';

            studentSearchDebounceTimeout = setTimeout(() => {
                fetch(`../../Functions/fetchStudentSearchSuggestions.php?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayStudentSearchResults(data.data);
                        } else {
                            searchResultsContainer.innerHTML = `<div class="p-6 text-center text-red-500">Error: ${data.message}</div>`;
                        }
                    })
                    .catch(() => {
                        searchResultsContainer.innerHTML =
                            '<div class="p-6 text-center text-red-500">Failed to fetch search results.</div>';
                    });
            }, 300);
        });

        function displayStudentSearchResults(results) {
            searchResultsContainer.innerHTML = "";
            if (results.length === 0) {
                searchResultsContainer.innerHTML =
                    '<div class="p-6 text-center text-gray-500 text-lg">No classes found.</div>';
                return;
            }
            const gridContainer = document.createElement("div");
            gridContainer.className = "grid grid-cols-1 gap-4 p-4";
            results.forEach(classItem => {
                const statusColors = {
                    active: "bg-green-100 text-green-800",
                    inactive: "bg-gray-100 text-gray-800",
                    archived: "bg-red-100 text-red-800",
                };
                const description = classItem.class_description || "No description available";
                const strand = classItem.strand || "N/A";
                const statusClass = statusColors[classItem.status] || statusColors.inactive;
                const classCardHtml = `
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                        <div class="h-2 bg-blue-500"></div>
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="font-semibold text-lg text-gray-900">${classItem.class_name}</h3>
                                <span class="px-2 py-1 text-xs rounded-full ${statusClass}">
                                    ${classItem.status.charAt(0).toUpperCase() + classItem.status.slice(1)}
                            </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">${description}</p>
                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <div class="bg-gray-50 p-2 rounded">
                                    <p class="text-xs text-gray-500">Grade</p>
                                    <p class="font-medium text-sm text-gray-800">Grade ${classItem.grade_level}</p>
                                </div>
                                <div class="bg-gray-50 p-2 rounded">
                                    <p class="text-xs text-gray-500">Strand</p>
                                    <p class="font-medium text-sm text-gray-800">${strand}</p>
                                </div>
                            </div>
                            <div class="flex justify-between text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-users mr-2 text-blue-500"></i>
                                    <span>${classItem.student_count} Students</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-book mr-2 text-blue-500"></i>
                                    <span>${classItem.quiz_count} Quizzes</span>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-key mr-1"></i>
                                    Code: <span class="font-mono font-medium">${classItem.class_code}</span>
                                </div>
                                <a href="../Pages/classDetails.php?class_id=${classItem.class_id}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Class <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                gridContainer.insertAdjacentHTML("beforeend", classCardHtml);
            });
            searchResultsContainer.appendChild(gridContainer);
        }
    });
</script>