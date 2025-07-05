/**
 * Dashboard Security Script
 * Prevents access to dashboard pages after logout via browser history
 */
(function() {
  // Run this before anything else loads
  // Check if the session is still valid
  fetch('../../Functions/Sessions/checkActiveSession.php', {
    method: 'GET',
    headers: {
      'Cache-Control': 'no-cache, no-store, must-revalidate',
      'Pragma': 'no-cache',
      'Expires': '0'
    },
    credentials: 'same-origin'
  })
  .then(response => response.json())
  .then(data => {
    if (!data.valid) {
      // If session is invalid, force redirect to login
      window.location.replace('../../index.php?msg=session_expired');
    }
  })
  .catch(error => {
    console.error('Session check failed:', error);
    // On error, still redirect to be safe
    window.location.replace('../../index.php?msg=error');
  });
})();