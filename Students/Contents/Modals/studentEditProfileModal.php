<div id="editProfileModal" class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-0 relative">
        <!-- Accent Bar -->
        <div class="h-2 bg-gradient-to-r from-blue-400 to-blue-600 rounded-t-2xl"></div>
        <button onclick="closeEditProfileModal()" class="absolute top-4 right-4 text-gray-400 hover:text-blue-600 text-2xl rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300">
                <i class="fas fa-times text-2xl"></i>
        </button>
        <div class="p-8">
            <h2 class="text-xl font-bold mb-6 text-blue-900 flex items-center gap-2">
                <i class="fas fa-user-edit text-blue-500"></i>
                Edit Profile
            </h2>
            <form id="editProfileForm" method="post" action="../../Functions/updateStudentProfile.php">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="st_userName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm" value="<?php echo htmlspecialchars($user_name); ?>" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="st_email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm" value="<?php echo htmlspecialchars($user_email); ?>" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                    <div class="relative">
                        <select name="grade_level" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none" required>
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
                        <select name="strand" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none" required>
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
                    <input type="password" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm" placeholder="Leave blank to keep current password" autocomplete="new-password" />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-xs text-gray-400">(required to change password)</span></label>
                    <input type="password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm" placeholder="Enter current password to change" autocomplete="current-password" />
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeEditProfileModal()" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors duration-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition-colors duration-200 shadow">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>