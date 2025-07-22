<!-- Mobile Menu Button - Outside Header -->
<header class="bg-gray-100  sticky top-0 z-30 ">
    <div class="container mx-auto flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        <!-- Left Section: Mobile Menu Toggle (for mobile) & Logo/Tagline -->
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Button -->
            <div onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-md bg-white shadow-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                <i class="fas fa-bars text-xl"></i>
            </div>
            <!-- Logo/Tagline (optional, add your logo here) -->
            
            <!-- Logo and Tagline -->
            <a href="#" class="hidden sm:flex items-center gap-3 font-bold text-purple-700 text-lg">
                <img src="../../../Assets/Images/Logo.png" alt="AMA Logo" class="h-12 w-12 object-contain" />
                <span class="text-gray-900 font-bold text-xl tracking-tight">AMA Teacher Portal</span>
            </a>
                    </div>

        <!-- Right Section: User Profile and Notifications -->
        <div class="flex items-center gap-4">

            <!-- Profile Section -->
            <div class="relative">
                <button id="teacherProfileTrigger" class="flex items-center gap-2 p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 border border-gray-200 bg-white" onclick="toggleTeacherProfileDropdown(event)" aria-haspopup="true" aria-expanded="false">
                    <div class="w-8 h-8 bg-purple-primary rounded-full flex items-center justify-center shrink-0">
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
                <div id="teacherProfileDropdown" class="absolute top-full right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-xs text-gray-500">Teacher</p>
                    </div>
                    <a href="#" onclick="openEditTeacherProfileModal(); return false;" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                    <button onclick="openLogoutConfirmationModal(); return false;" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
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

<!-- Welcome Section -->
<div class="my-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p class="text-gray-600">Here's what's happening with your classes today.</p>
</div>

<script>
    // Function to toggle the profile dropdown
    function toggleTeacherProfileDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('teacherProfileDropdown');
        const trigger = document.getElementById('teacherProfileTrigger');
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

        dropdown.classList.toggle('hidden');
        trigger.setAttribute('aria-expanded', !isExpanded);
    }

    // Close the dropdown if the user clicks outside of it
    document.addEventListener('click', function(event) {
        const profileDropdown = document.getElementById('teacherProfileDropdown');
        const profileTrigger = document.getElementById('teacherProfileTrigger');
        if (profileDropdown && profileTrigger && !profileDropdown.contains(event.target) && !profileTrigger.contains(event.target)) {
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
                profileTrigger.setAttribute('aria-expanded', 'false');
            }
        }
    });

    function openLogoutConfirmationModal() {
        // Implement your logout modal logic here
        alert('Show logout modal here!');
        document.getElementById('teacherProfileDropdown').classList.add('hidden');
        document.getElementById('teacherProfileTrigger').setAttribute('aria-expanded', 'false');
    }

    function openEditTeacherProfileModal() {
        document.getElementById('editTeacherProfileModal').classList.remove('hidden');
    }
    function closeEditTeacherProfileModal() {
        document.getElementById('editTeacherProfileModal').classList.add('hidden');
    }
</script>