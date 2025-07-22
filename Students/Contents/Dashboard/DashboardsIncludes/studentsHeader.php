<!-- Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
    <div class="container mx-auto flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        <!-- Left Section: Mobile Menu Toggle (for mobile) & Logo/Tagline -->
        <div class="flex items-center gap-6">

            <!-- Logo and Tagline -->
            <a href="#" class="flex items-center gap-2">
                <img src="../../../Assets/Images/Logo.png" alt="AMA Logo" class="h-12 w-12 object-contain" />
                <span class="text-gray-900 font-bold text-xl tracking-tight">AMA Student Learning Portal</span>
            </a>
        </div>

        <!-- Right Section: User Profile and Notifications -->
        <div class="flex items-center gap-4">
            <!-- Notification Bell -->
            <!-- <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition-colors duration-200" aria-label="Notifications">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold leading-none">2</span>
            </button> -->

            <!-- Profile Section -->
            <div class="relative">
                <button id="userProfileTrigger" class="flex items-center gap-2 p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="toggleProfileDropdown(event)" aria-haspopup="true" aria-expanded="false">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center shrink-0">
                        <span class="text-white font-medium text-sm"><?php echo strtoupper(substr($user_name, 0, 1)); ?></span>
                    </div>
                    <div class="hidden md:flex items-center gap-1">
                        <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($user_name); ?></p>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="absolute top-full right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-xs text-gray-500">Student</p>
                    </div>
                    <a href="/edit-profile" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200" onclick="openEditProfileModal(); return false;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                    <button onclick="openLogoutModal(); return false;" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<?php include "../Modals/logoutConfirmationModal.php" ?>

<script>
    // Function to toggle the profile dropdown
    function toggleProfileDropdown(event) {
        event.stopPropagation(); // Prevent click from propagating to document and closing immediately
        const dropdown = document.getElementById('profileDropdown');
        const trigger = document.getElementById('userProfileTrigger');
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

        dropdown.classList.toggle('hidden');
        trigger.setAttribute('aria-expanded', !isExpanded);
    }

    // Close the dropdown if the user clicks outside of it
    document.addEventListener('click', function(event) {
        const profileDropdown = document.getElementById('profileDropdown');
        const userProfileTrigger = document.getElementById('userProfileTrigger');

        if (profileDropdown && userProfileTrigger && !profileDropdown.contains(event.target) && !userProfileTrigger.contains(event.target)) {
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
                userProfileTrigger.setAttribute('aria-expanded', 'false');
            }
        }
    });

    // Mobile menu toggle (assuming you have a mobile menu element with id 'mobileMenu')
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu'); // Assuming this ID exists for your mobile menu
        const overlay = document.getElementById('overlay');
        if (mobileMenu) {
            mobileMenu.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
            overlay.classList.toggle('opacity-0'); // Toggle opacity for transition
            document.body.classList.toggle('overflow-hidden'); // Prevent scrolling when menu is open
        }
    }

    function closeMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('overlay');
        if (mobileMenu) {
            mobileMenu.classList.add('hidden');
            overlay.classList.add('hidden');
            overlay.classList.add('opacity-0'); // Ensure opacity is reset
            document.body.classList.remove('overflow-hidden');
        }
    }

    function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
        document.getElementById('profileDropdown').classList.add('hidden'); // Close profile dropdown when opening logout modal
        document.getElementById('userProfileTrigger').setAttribute('aria-expanded', 'false');
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
    }

    function openEditProfileModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    function closeEditProfileModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }

    // Optional: Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeLogoutModal();
    });
</script>