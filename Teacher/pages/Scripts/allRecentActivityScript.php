<script>
    // Store activity data for modal display
    const activityData = <?= json_encode($activities) ?>;

    function showActivityDetails(index) {
        const activity = activityData[index];
        const modal = document.getElementById('activityDetailsModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');
        const modalActions = document.getElementById('modalActions');

        // Clear previous content
        modalContent.innerHTML = '';
        modalActions.innerHTML = '';

        // Set modal title based on activity type
        if (activity.type === 'enrollment') {
            modalTitle.textContent = 'Student Enrollment Details';
        } else if (activity.type === 'quiz_submission') {
            modalTitle.textContent = 'Quiz Attempt Details';
        }

        // Create content based on activity type
        if (activity.type === 'enrollment') {
            // Enrollment details
            modalContent.innerHTML = `
            <div class="space-y-4">
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-green-100">
                        <img src="${activity.profile_picture}" alt="${activity.student_name}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='../../../Assets/Images/defaultProfile.png'">
                    </div>
                </div>
                <div class="text-center mb-4">
                    <p class="text-lg font-bold">${activity.student_name}</p>
                    <p class="text-sm text-gray-500">Enrolled on ${new Date(activity.time).toLocaleString()}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-sm text-gray-500">Class</p>
                            <p class="font-medium">${activity.class_name}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Student ID</p>
                            <p class="font-medium">${activity.student_number}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Grade Level</p>
                            <p class="font-medium">${activity.grade_level.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Strand</p>
                            <p class="font-medium">${activity.strand.toUpperCase()}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        } else if (activity.type === 'quiz_submission') {
            // For quiz submissions, show the latest attempt (may be AI-generated)
            const quizTypeDisplay = activity.latest_quiz_type !== 'manual' ?
                '<span class="text-xs px-2 py-1 bg-purple-100 text-purple-800 rounded-full ml-2">AI-Generated</span>' : '';

            const attemptTimeDisplay = new Date(activity.latest_time).toLocaleString();

            modalContent.innerHTML = `
            <div class="space-y-4">
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-blue-100">
                        <img src="${activity.profile_picture}" alt="${activity.student_name}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='../../../Assets/Images/defaultProfile.png'">
                    </div>
                </div>
                <div class="text-center mb-4">
                    <p class="text-lg font-bold">${activity.student_name}</p>
                    <p class="text-sm text-gray-500">Latest attempt on ${attemptTimeDisplay}</p>
                </div>
                <div>
                    <div class="flex items-center">
                        <p class="font-medium text-lg">${activity.original_quiz_title}</p>
                    </div>
                    <p class="text-gray-500 mb-3">Class: ${activity.class_name}</p>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Latest Score</p>
                                <p class="font-medium">${activity.latest_score}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Attempts</p>
                                <p class="font-medium">${activity.total_attempts}</p>
                            </div>
                            ${activity.latest_quiz_type !== 'manual' ? `
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Latest Quiz Version</p>
                                <p class="font-medium flex items-center">
                                    ${activity.latest_quiz_title}
                                    ${quizTypeDisplay}
                                </p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    <p class="text-sm italic">
                        ${activity.student_name} has attempted this quiz and its AI-generated versions 
                        ${activity.total_attempts} time${activity.total_attempts !== 1 ? 's' : ''}.
                    </p>
                </div>
            </div>
        `;

            // Add action button to view the latest attempt details
            modalActions.innerHTML = `
            <a href="viewStudentAttempt.php?attempt_id=${activity.latest_attempt_id}" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                View Attempt
            </a>
            
        `;
        }

        // Show modal
        modal.classList.remove('hidden');
    }

    function closeActivityModal() {
        document.getElementById('activityDetailsModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('activityDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeActivityModal();
        }
    });
</script>