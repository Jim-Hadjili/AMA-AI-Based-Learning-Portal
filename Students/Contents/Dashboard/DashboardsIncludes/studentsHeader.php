<!-- Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
    <div class="container mx-auto flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        <!-- Left Section: Mobile Menu Toggle (for mobile) & Logo/Tagline -->
        <div class="flex items-center gap-6">
            <!-- Mobile Menu Toggle -->
            <button type="button" class="lg:hidden text-gray-500 hover:text-blue-600 focus:outline-none" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Logo and Tagline -->
            <a href="../Dashboard/studentDashboard.php" class="flex items-center gap-2">
                <img src="../../../Assets/Images/Logo.png" alt="AMA Logo" class="h-10 w-10 object-contain" />
                <span class="text-gray-900 font-bold text-xl tracking-tight hidden md:inline-block">AMA Student Portal</span>
            </a>
        </div>

        <!-- Right Section: User Profile and Notifications -->
        <div class="flex items-center gap-4">
            <!-- Profile Section -->
            <div class="relative">
                <button id="userProfileTrigger" class="flex items-center gap-2 p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="toggleProfileDropdown(event)" aria-haspopup="true" aria-expanded="false">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 overflow-hidden">
                        <?php if (!empty($_SESSION['profile_picture']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/' . $_SESSION['profile_picture'])): ?>
                            <img src="/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-medium text-sm"><?php echo strtoupper(substr($user_name, 0, 1)); ?></span>
                            </div>
                        <?php endif; ?>
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
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                <?php if (!empty($_SESSION['profile_picture']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/' . $_SESSION['profile_picture'])): ?>
                                    <img src="/AMA-AI-Based-Learning-Portal/Uploads/ProfilePictures/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full bg-blue-600 flex items-center justify-center">
                                        <span class="text-white font-medium text-sm"><?php echo strtoupper(substr($user_name, 0, 1)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                                <p class="text-xs text-gray-500">Student</p>
                            </div>
                        </div>
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
        document.getElementById('profileDropdown').classList.add('hidden'); // Close profile dropdown when opening edit modal
    }
    function closeEditProfileModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }

    // Optional: Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            closeLogoutModal();
            closeEditProfileModal();
        }
    });
</script>