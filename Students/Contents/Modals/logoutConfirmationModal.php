<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 sm:p-8 border border-gray-100"
         id="logoutModalContent">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-sign-out-alt text-red-500"></i> Confirm Logout
            </h2>
        </div>
        <p class="mb-6 text-gray-700 leading-relaxed">Are you sure you want to log out of your account?</p>
        <div class="flex flex-col sm:flex-row-reverse gap-3">
            <form id="logoutForm" action="../../../Assets/Auth/logout.php" method="post" class="w-full sm:w-auto">
                <button type="submit" class="w-full inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-sign-out-alt mr-2"></i> Yes, Log Out
                </button>
            </form>
            <button onclick="closeLogoutModal()" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 font-medium hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                <i class="fas fa-times mr-2"></i> Cancel
            </button>
        </div>
    </div>
</div>
