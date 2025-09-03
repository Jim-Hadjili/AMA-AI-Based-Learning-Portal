<!-- Mobile Menu Button - Outside Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-30" role="banner" aria-label="Teacher Portal Header">
    <div class="container mx-auto flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
        <!-- Left Section: Logo/Tagline -->
        <div class="flex items-center gap-3">
            <!-- Logo and Tagline -->
            <a href="../Dashboard/teachersDashboard.php" class="flex items-center gap-3 group" aria-label="Go to Dashboard">
                <img src="../../../Assets/Images/Logo.png" alt="AMA Logo" class="h-10 w-10 object-contain" />
                <span class="text-gray-900 font-semibold text-lg tracking-tight group-hover:text-blue-600 transition-colors">AMA Teacher Portal</span>
            </a>
        </div>

        <!-- Right Section: User Profile -->
        <div class="flex items-center">
            <div class="relative">
                <button id="teacherProfileTrigger" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                    onclick="toggleTeacherProfileDropdown(event)" aria-haspopup="true" aria-expanded="false" aria-label="Open profile menu">
                    <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-medium text-sm"><?php echo strtoupper(htmlspecialchars(substr($user_name, 0, 1))); ?></span>
                    </div>
                    <div class="hidden md:flex items-center gap-2">
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                            <p class="text-xs text-gray-500">Teacher Account</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div id="teacherProfileDropdown" class="absolute top-full right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-50 hidden overflow-hidden" role="menu" aria-label="Profile options">
                    <div class="px-4 py-3 bg-gray-50">
                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-xs text-gray-500">Teacher Account</p>
                    </div>
                    <div class="py-1">
                        <a href="#" onclick="openEditTeacherProfileModal(); return false;" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200" role="menuitem">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        <button onclick="openLogoutConfirmationModal(); return false;" class="flex items-center gap-3 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200" role="menuitem">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sign Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Welcome Section -->
<div class="px-4 sm:px-6 lg:px-8 pt-6">
    <!-- Enhanced welcome section with better gradient and animations -->
    <div class="relative bg-white rounded-3xl p-8 border border-blue-100/50 shadow-lg hover:shadow-xl transition-all duration-500 overflow-hidden"> 
        
        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-3">
                <!-- Enhanced typography with better spacing and animations -->
                <h1 class="text-3xl lg:text-4xl font-bold  text-black leading-tight">
                    Welcome back, <?php echo htmlspecialchars($user_name); ?>! 
                    <span class="inline-block animate-bounce">👋</span>
                </h1>
                <p class="text-gray-600 text-lg font-medium">Ready to inspire your students today?</p>
            </div>
            <!-- Enhanced button with better styling and animations -->
            <button
                id="addClassBtn"
                type="button"
                onclick="window.openAddClassModal && window.openAddClassModal()"
                class="group relative inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/30 focus:ring-offset-2 w-full lg:w-auto transform hover:scale-105 overflow-hidden"
                aria-label="Add New Class">
                <!-- Added animated background effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <span class="relative">Add New Class</span>
            </button>
        </div>
    </div>
</div>

<script defer>
    // Function to toggle the profile dropdown
    function toggleTeacherProfileDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('teacherProfileDropdown');
        const trigger = document.getElementById('teacherProfileTrigger');
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

        dropdown.classList.toggle('hidden');
        trigger.setAttribute('aria-expanded', !isExpanded);

        // Focus first menu item for accessibility
        if (!dropdown.classList.contains('hidden')) {
            const firstItem = dropdown.querySelector('[role="menuitem"]');
            if (firstItem) firstItem.focus();
        }
    }

    // Keyboard navigation for dropdown
    document.addEventListener('keydown', function(event) {
        const dropdown = document.getElementById('teacherProfileDropdown');
        if (!dropdown || dropdown.classList.contains('hidden')) return;

        if (event.key === 'Escape') {
            dropdown.classList.add('hidden');
            document.getElementById('teacherProfileTrigger').setAttribute('aria-expanded', 'false');
        }
    });

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
