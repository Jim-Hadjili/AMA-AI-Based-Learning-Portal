<div id="editTeacherProfileModal" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden p-4">
    <!-- Added padding and improved responsive sizing -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[95vh] mx-auto border border-gray-100 transform transition-all duration-300 relative flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-100 to-purple-200 rounded-t-2xl flex-shrink-0">
            <h2 class="text-xl font-bold text-purple-900 flex items-center gap-2">
                <span class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">
                    <i class="fas fa-user-edit text-purple-600 text-3xl"></i>
                </span>
                Edit Profile
            </h2>
            <button type="button" onclick="closeEditTeacherProfileModal()" class="text-gray-400 hover:text-purple-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-purple-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Made form scrollable and improved layout -->
        <div class="flex-1 overflow-y-auto">
            <form id="editTeacherProfileForm" method="post" action="../../Functions/updateTeacherProfile.php" class="px-6 py-2" enctype="multipart/form-data">
                <!-- Organized fields in a responsive grid layout -->
                <div class="space-y-6">
                    <!-- Profile Picture Section -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="flex flex-col items-center gap-2 relative">
                            <div class="relative w-20 h-20">
                                <img
                                    id="profilePicPreviewOld"
                                    src="<?php echo !empty($profile_picture) ? '../../../Uploads/ProfilePictures/' . htmlspecialchars($profile_picture) : '../../Assets/Images/default_profile.png'; ?>"
                                    alt="Current Profile Picture"
                                    class="w-20 h-20 rounded-full object-cover border-2 border-purple-200 shadow-sm cursor-pointer"
                                    onclick="document.getElementById('profilePicInput').click()"
                                    title="Click to select a new profile picture"
                                >
                                <!-- Edit indicator overlay, perfectly aligned in bottom-right of image -->
                                <span
                                    class="absolute"
                                    style="
                                        right: 4px;
                                        bottom: 4px;
                                        background: #1bd13cff;
                                        color: #fff;
                                        border-radius: 9999px;
                                        padding: 4px;
                                        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-size: 1rem;
                                    "
                                >
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                            </div>
                            <span class="text-xs text-gray-500">Current</span>
                        </div>
                        <div class="flex flex-col items-center gap-2">
                            <img id="profilePicPreviewNew" src="" alt="New Profile Picture Preview" class="w-20 h-20 rounded-full object-cover border-2 border-green-300 shadow-sm hidden cursor-pointer" onclick="document.getElementById('profilePicInput').click()" title="Click to select a new profile picture">

                            <span id="newPicLabel" class="text-xs text-green-600 hidden">New (will be updated)</span>
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                            <!-- Hidden file input -->
                            <input id="profilePicInput" type="file" name="profile_picture" accept="image/*" class="hidden" />
                            <span class="text-xs text-gray-500 mt-1 block">Click your profile picture to select a new one.</span>
                        </div>
                    </div>

                    <!-- Organized personal info in a grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" name="teacher_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($user_name); ?>" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="teacher_email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($user_email); ?>" required />
                        </div>
                    </div>

                    <!-- Professional info in a grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employee ID</label>
                            <input type="text" name="employee_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                value="<?php echo htmlspecialchars($employee_id ?? ''); ?>" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                            <div class="relative">
                                <select name="department"
                                    class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none transition-all"
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
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Subject Expertise - Full width -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject Expertise</label>
                        <input type="text" name="subject_expertise" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            value="<?php echo htmlspecialchars($subject_expertise ?? ''); ?>" placeholder="e.g., Algebra, Physics, Creative Writing" />
                    </div>

                    <!-- Password section with better visual separation -->
                    <div class="border-t border-gray-200 pt-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-lock text-purple-600"></i>
                            Change Password
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="new_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" placeholder="Leave blank to keep current" autocomplete="new-password" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Password 
                                    <span class="text-xs text-gray-500 font-normal">(required to change)</span>
                                </label>
                                <input type="password" name="current_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" placeholder="Enter current password" autocomplete="current-password" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Fixed footer with better button styling -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex-shrink-0">
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeEditTeacherProfileModal()" class="w-full sm:w-auto px-6 py-3 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" form="editTeacherProfileForm" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-purple-700 hover:to-purple-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('profilePicInput').addEventListener('change', function(e) {
    const [file] = e.target.files;
    const previewNew = document.getElementById('profilePicPreviewNew');
    const newPicLabel = document.getElementById('newPicLabel');
    const editIndicatorNew = document.getElementById('editIndicatorNew');
    if (file) {
        previewNew.src = URL.createObjectURL(file);
        previewNew.classList.remove('hidden');
        newPicLabel.classList.remove('hidden');
        editIndicatorNew.classList.remove('hidden');
    } else {
        previewNew.src = "";
        previewNew.classList.add('hidden');
        newPicLabel.classList.add('hidden');
        editIndicatorNew.classList.add('hidden');
    }
});
</script>
