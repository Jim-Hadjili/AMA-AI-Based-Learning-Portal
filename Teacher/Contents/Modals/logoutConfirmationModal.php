<!-- Logout Confirmation Modal -->
<div id="logoutConfirmationModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md transition-all duration-300 scale-100 opacity-100 modal-content">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-semibold text-gray-900">Sign Out?</h3>
            <button onclick="closeLogoutConfirmationModal()" class="text-gray-400 hover:text-gray-700 transition-colors duration-150">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <p class="text-gray-600 mb-8 text-base">Are you sure you want to log out of your account?</p>
        <div class="flex justify-end gap-4">
            <button onclick="closeLogoutConfirmationModal()" class="px-5 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 transition-colors duration-150 font-medium">
                Cancel
            </button>
            <a href="../../../Assets/Auth/logout.php" class="px-5 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 transition-all duration-150 font-medium flex items-center gap-2 shadow-sm">
                <i class="fas fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </div>
</div>
