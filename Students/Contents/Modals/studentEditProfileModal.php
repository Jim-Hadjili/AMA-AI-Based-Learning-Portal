<?php
$grade_level = $_SESSION['grade_level'] ?? '';
$strand = $_SESSION['strand'] ?? '';
?>
<div id="editProfileModal" class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[95vh] mx-auto border border-gray-100 transform transition-all duration-300 relative flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-100 to-blue-200 rounded-t-2xl flex-shrink-0">
            <h2 class="text-xl font-bold text-blue-900 flex items-center gap-2">
                <span class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user-edit text-blue-600 text-3xl"></i>
                </span>
                Edit Profile
            </h2>
            <button type="button" onclick="closeEditProfileModal()" class="text-gray-400 hover:text-blue-600 transition-colors duration-150 rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Scrollable form content -->
        <div class="flex-1 overflow-y-auto">
            <form id="editProfileForm" method="post" action="../../Functions/updateStudentProfile.php" class="px-6 py-2" enctype="multipart/form-data">
                <div class="space-y-6">
                    <!-- Profile Picture Section -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="flex flex-col items-center gap-2 relative">
                            <div class="relative w-20 h-20">
                                <?php if (!empty($_SESSION['profile_picture']) && file_exists('../../../Uploads/ProfilePictures/' . $_SESSION['profile_picture'])): ?>
                                    <img
                                        id="profilePicPreviewOld"
                                        src="../../../Uploads/ProfilePictures/<?php echo $_SESSION['profile_picture']; ?>"
                                        alt="Current Profile Picture"
                                        class="w-20 h-20 rounded-full object-cover border-2 border-blue-200 shadow-sm cursor-pointer"
                                        onclick="document.getElementById('profilePicInput').click()"
                                        title="Click to select a new profile picture"
                                    >
                                <?php else: ?>
                                    <div id="profilePicPreviewOld" class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-200 shadow-sm cursor-pointer"
                                         onclick="document.getElementById('profilePicInput').click()" title="Click to select a new profile picture">
                                        <span class="text-blue-600 font-bold text-2xl">
                                            <?php 
                                                $initials = explode(' ', $user_name);
                                                echo strtoupper(substr($initials[0], 0, 1) . (isset($initials[1]) ? substr($initials[1], 0, 1) : ''));
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <!-- Edit indicator overlay -->
                                <span class="absolute" style="
                                    right: 4px;
                                    bottom: 4px;
                                    background: #2563eb;
                                    color: #fff;
                                    border-radius: 9999px;
                                    padding: 4px;
                                    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 1rem;
                                ">
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
                            <input id="profilePicInput" type="file" name="profile_picture" accept="image/*" class="hidden" onchange="previewStudentImage(this)" />
                            <span class="text-xs text-gray-500 mt-1 block">Click your profile picture to select a new one.</span>
                        </div>
                    </div>

                    <!-- Organized personal info in a grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" name="st_userName" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($user_name); ?>" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="st_email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($user_email); ?>" required />
                        </div>
                    </div>

                    <!-- Academic Info in a grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                            <div class="relative">
                                <select name="grade_level" class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition-all" required>
                                    <option value="">Select grade</option>
                                    <option value="Grade 11" <?php if ($grade_level === 'Grade 11') echo 'selected'; ?>>Grade 11</option>
                                    <option value="Grade 12" <?php if ($grade_level === 'Grade 12') echo 'selected'; ?>>Grade 12</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Strand</label>
                            <div class="relative">
                                <select name="strand" class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition-all" required>
                                    <option value="">Select strand</option>
                                    <option value="STEM" <?php if ($strand === 'STEM') echo 'selected'; ?>>STEM</option>
                                    <option value="ABM" <?php if ($strand === 'ABM') echo 'selected'; ?>>ABM</option>
                                    <option value="HUMSS" <?php if ($strand === 'HUMSS') echo 'selected'; ?>>HUMSS</option>
                                    <option value="GAS" <?php if ($strand === 'GAS') echo 'selected'; ?>>GAS</option>
                                    <option value="TVL-ICT" <?php if ($strand === 'TVL-ICT') echo 'selected'; ?>>TVL-ICT</option>
                                    <option value="TVL-HE" <?php if ($strand === 'TVL-HE') echo 'selected'; ?>>TVL-HE</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password section with better visual separation -->
                    <div class="border-t border-gray-200 pt-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-lock text-blue-600"></i>
                            Change Password
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="new_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Leave blank to keep current password" autocomplete="new-password" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Password 
                                    <span class="text-xs text-gray-500 font-normal">(required to change)</span>
                                </label>
                                <input type="password" name="current_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Enter current password" autocomplete="current-password" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Fixed footer with better button styling -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex-shrink-0">
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeEditProfileModal()" class="w-full sm:w-auto px-6 py-3 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button type="submit" form="editProfileForm" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-sm text-sm font-medium text-white hover:from-blue-700 hover:to-blue-800 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function previewStudentImage(input) {
    const previewNew = document.getElementById('profilePicPreviewNew');
    const newPicLabel = document.getElementById('newPicLabel');
    if (input.files && input.files[0]) {
        previewNew.src = URL.createObjectURL(input.files[0]);
        previewNew.classList.remove('hidden');
        newPicLabel.classList.remove('hidden');
    } else {
        previewNew.src = "";
        previewNew.classList.add('hidden');
        newPicLabel.classList.add('hidden');
    }
}
</script>

