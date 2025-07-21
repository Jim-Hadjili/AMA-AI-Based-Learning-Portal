<!-- Mobile Overlay -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden" onclick="closeMobileMenu()"></div>

<!-- Mobile Menu Button - Outside Header -->
<div onclick="toggleMobileMenu()" class="lg:hidden p-2 fixed left-4 top-4 z-30 rounded-md bg-white shadow-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
    <i class="fas fa-bars text-xl"></i>
</div>

<!-- Top Header - Right Side Only -->
<header class="bg-gray-100 sticky top-0 z-20">
    <div class="flex justify-end max-w-screen-2xl mx-auto">
        <div class="flex items-center px-3 lg:px-4 py-2 ml-auto">
            <!-- User Profile and Notifications Container - Now the relative parent -->
            <div class="flex items-center space-x-2 bg-white py-1.5 px-3 rounded-lg shadow-sm relative">
                <button class="p-1.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg relative transition-colors duration-200">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute -top-1 -right-1 h-3.5 w-3.5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">2</span>
                </button>

                <div class="h-5 border-r border-gray-200"></div>

                <!-- Profile Section - Clickable Trigger with improved design -->
                <div id="userProfileTrigger" class="flex items-center space-x-2 cursor-pointer p-1 rounded-md hover:bg-gray-50 transition-colors duration-200" onclick="toggleProfileDropdown(event)">
                    <div class="w-7 h-7 bg-blue-primary rounded-full flex items-center justify-center">
                        <span class="text-white font-medium text-xs"><?php echo strtoupper(substr($user_name, 0, 1)); ?></span>
                    </div>
                    <div class="hidden md:block">
                        <p class="text-xs font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-xs text-gray-500">Student</p>
                    </div>
                </div>

                <!-- Dropdown Menu - Positioned relative to the main white container -->
                <div id="profileDropdown" class="absolute top-full right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-lg z-50 hidden">
                    <a href="/edit-profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </a>
                    <a href="#" onclick="openLogoutModal(); return false;" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<?php include "../Modals/logoutConfirmationModal.php" ?>

<script>
    function toggleProfileDropdown(event) {
        event.stopPropagation(); // Prevent click from propagating to document and closing immediately
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close the dropdown if the user clicks outside of the profile trigger area or the dropdown itself
    document.addEventListener('click', function(event) {
        const profileContainer = document.querySelector('.bg-white.py-1\\.5.px-3.rounded-lg.shadow-sm.relative'); // Target the main container
        const profileDropdown = document.getElementById('profileDropdown');
        
        // If the dropdown is open AND the click was outside the entire profile container
        if (profileContainer && !profileContainer.contains(event.target)) {
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
        }
    });

    function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
    }

    // Optional: Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeLogoutModal();
    });
</script>