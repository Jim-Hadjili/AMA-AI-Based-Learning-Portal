<div id="sidebar" class="fixed left-0 top-0 h-full rounded-tr-[2rem] rounded-br-[2rem] sidebar-base lg:sidebar-base bg-gradient-to-b from-blue-primary to-blue-dark text-white z-50 -translate-x-full lg:translate-x-0 sidebar-mobile"
    onmouseenter="handleSidebarMouseEnter()" onmouseleave="handleSidebarMouseLeave()">
  <!-- Logo Section -->
  <div class="flex items-center justify-center lg:justify-start h-16 px-4 border-b border-blue-400/20">
      <div class="flex items-center space-x-3">
          <img src="../../../Assets/Images/Logo.png" alt="AMA Logo" class="w-8 h-8 flex-shrink-0  object-cover">
          <span class="font-bold text-lg sidebar-text">AMA Learning</span>
      </div>
  </div>

  <!-- Navigation Menu -->
  <nav class="mt-8 px-2">
      <ul class="space-y-2">
          <li>
              <a href="studentsDashboard.php" class="flex items-center px-3 py-3 rounded-lg bg-white/10 text-white hover:bg-white/20 transition-colors duration-200">
                  <i class="fas fa-home w-5 h-5 text-center flex-shrink-0"></i>
                  <span class="ml-4 sidebar-text">Dashboard</span>
              </a>
          </li>
          <li>
              <a href="javascript:void(0)" onclick="showJoinClassModal()" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                  <i class="fas fa-search w-5 h-5 text-center flex-shrink-0"></i>
                  <span class="ml-4 sidebar-text">Join Class</span>
              </a>
          </li>
          <li>
              <a href="../Pages/studentAllClasses.php" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
                  <i class="fas fa-book-open w-5 h-5 text-center flex-shrink-0"></i>
                  <span class="ml-4 sidebar-text">My Classes</span>
              </a>
          </li>
      </ul>
  </nav>

  <!-- Bottom Section -->
  <div class="absolute bottom-4 left-0 right-0 px-2">
      <a href="#" onclick="openLogoutModal(); return false;" class="flex items-center px-3 py-3 rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-200">
          <i class="fas fa-sign-out-alt w-5 h-5 text-center flex-shrink-0"></i>
          <span class="ml-4 sidebar-text">Logout</span>
      </a>
  </div>
</div>

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