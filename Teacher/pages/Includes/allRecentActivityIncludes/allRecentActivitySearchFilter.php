<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 px-6 pt-6 pb-4 flex flex-col md:flex-row gap-4 items-center">
    <input id="activitySearch" type="text" placeholder="Search by student, class, or quiz..." class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
    <select id="activityTypeFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
        <option value="">All Types</option>
        <option value="enrollment">Enrollment</option>
        <option value="quiz_submission">Quiz Submission</option>
    </select>
    <select id="classFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
        <option value="">All Classes</option>
        <?php
        // Output class options
        if (isset($classNames) && is_array($classNames)) {
            foreach ($classNames as $cid => $cname) {
                echo "<option value=\"$cid\">" . htmlspecialchars($cname) . "</option>";
            }
        }
        ?>
    </select>
    <!-- Reset Button -->
    <button id="resetActivityFilters" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition duration-150 flex items-center gap-2 border border-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
        </svg>
        Reset
    </button>
</div>