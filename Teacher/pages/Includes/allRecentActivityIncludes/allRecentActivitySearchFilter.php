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
</div>