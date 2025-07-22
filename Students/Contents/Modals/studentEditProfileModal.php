<div id="editProfileModal" class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 relative">
        <button onclick="closeEditProfileModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <i class="fas fa-times text-lg"></i>
        </button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Edit Profile</h2>
        <form id="editProfileForm" method="post" action="../../Functions/updateStudentProfile.php">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="st_userName" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($user_name); ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="st_email" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($user_email); ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                <div class="relative">
                    <select name="grade_level" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 appearance-none" required>
                        <option value="">Select grade</option>
                        <option value="grade_11" <?php if (($_SESSION['grade_level'] ?? '') === 'grade_11') echo 'selected'; ?>>Grade 11</option>
                        <option value="grade_12" <?php if (($_SESSION['grade_level'] ?? '') === 'grade_12') echo 'selected'; ?>>Grade 12</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Strand</label>
                <div class="relative">
                    <select name="strand" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 appearance-none" required>
                        <option value="">Select strand</option>
                        <option value="stem" <?php if (($_SESSION['strand'] ?? '') === 'stem') echo 'selected'; ?>>STEM</option>
                        <option value="abm" <?php if (($_SESSION['strand'] ?? '') === 'abm') echo 'selected'; ?>>ABM</option>
                        <option value="humss" <?php if (($_SESSION['strand'] ?? '') === 'humss') echo 'selected'; ?>>HUMSS</option>
                        <option value="gas" <?php if (($_SESSION['strand'] ?? '') === 'gas') echo 'selected'; ?>>GAS</option>
                        <option value="tvl_ict" <?php if (($_SESSION['strand'] ?? '') === 'tvl_ict') echo 'selected'; ?>>TVL-ICT</option>
                        <option value="tvl_he" <?php if (($_SESSION['strand'] ?? '') === 'tvl_he') echo 'selected'; ?>>TVL-HE</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Leave blank to keep current password" autocomplete="new-password" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-xs text-gray-400">(required to change password)</span></label>
                <input type="password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Enter current password to change" autocomplete="current-password" />
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditProfileModal()" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>