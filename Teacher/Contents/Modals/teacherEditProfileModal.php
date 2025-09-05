<div id="editTeacherProfileModal" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-100 transform transition-all duration-300 relative">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
            <h2 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                    <i class="fas fa-user-edit text-purple-600"></i>
                </span>
                Edit Profile
            </h2>
            <button type="button" onclick="closeEditTeacherProfileModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="editTeacherProfileForm" method="post" action="../../Functions/updateTeacherProfile.php" class="px-6 py-6 bg-white rounded-b-2xl" enctype="multipart/form-data">
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <img src="<?php echo !empty($profile_picture) ? '../../../Uploads/ProfilePictures/' . htmlspecialchars($profile_picture) : '../../Assets/Images/default_profile.png'; ?>" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover border border-gray-300">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                        <input type="file" name="profile_picture" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" />
                        <span class="text-xs text-gray-400">JPG, PNG, JPEG (Max 2MB)</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="teacher_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="<?php echo htmlspecialchars($user_name); ?>" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="teacher_email" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" value="<?php echo htmlspecialchars($user_email); ?>" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Employee ID</label>
                    <input type="text" name="employee_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        value="<?php echo htmlspecialchars($employee_id ?? ''); ?>" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <div class="relative">
                        <select name="department"
                            class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none"
                            required>
                            <option value="" disabled>Select department</option>
                            <option value="Mathematics" <?php if(($department ?? '') === 'Mathematics') echo 'selected'; ?>>Mathematics</option>
                            <option value="Science" <?php if(($department ?? '') === 'Science') echo 'selected'; ?>>Science</option>
                            <option value="English" <?php if(($department ?? '') === 'English') echo 'selected'; ?>>English</option>
                            <option value="Filipino" <?php if(($department ?? '') === 'Filipino') echo 'selected'; ?>>Filipino</option>
                            <option value="Social Studies" <?php if(($department ?? '') === 'Social Studies') echo 'selected'; ?>>Social Studies</option>
                            <option value="ICT" <?php if(($department ?? '') === 'ICT') echo 'selected'; ?>>ICT</option>
                            <option value="Business" <?php if(($department ?? '') === 'Business') echo 'selected'; ?>>Business</option>
                            <option value="Arts" <?php if(($department ?? '') === 'Arts') echo 'selected'; ?>>Arts</option>
                            <option value="PE & Health" <?php if(($department ?? '') === 'PE & Health') echo 'selected'; ?>>PE & Health</option>
                            <option value="Guidance" <?php if(($department ?? '') === 'Guidance') echo 'selected'; ?>>Guidance</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Expertise</label>
                    <input type="text" name="subject_expertise" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        value="<?php echo htmlspecialchars($subject_expertise ?? ''); ?>" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="new_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Leave blank to keep current password" autocomplete="new-password" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-xs text-gray-400">(required to change password)</span></label>
                    <input type="password" name="current_password" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Enter current password to change" autocomplete="current-password" />
                </div>
                
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeEditTeacherProfileModal()" class="px-4 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-save mr-1.5"></i>Save
                </button>
            </div>
        </form>
    </div>
</div>