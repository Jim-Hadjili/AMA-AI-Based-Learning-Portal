<div id="editTeacherProfileModal" class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 relative">
        <button onclick="closeEditTeacherProfileModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <i class="fas fa-times text-lg"></i>
        </button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Edit Profile</h2>
        <form id="editTeacherProfileForm" method="post" action="../../Functions/updateTeacherProfile.php">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="teacher_name" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($user_name); ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="teacher_email" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($user_email); ?>" required />
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
                <button type="button" onclick="closeEditTeacherProfileModal()" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>