// Toggle dark mode and sidebar; intended to be small and dependency-free
(function () {
  var darkKey = 'theme';

  function init() {
    var darkToggle = document.getElementById('darkModeToggle');
    // optional element for showing an emoji/icon inside the toggle (not required)
    var darkIcon = null;
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');
  var sidebarKey = 'sidebarHidden';
    var profileMenuButton = document.getElementById('profileMenuButton');
    var profileMenu = document.getElementById('profileMenu');

    function updateDarkUI() {
      var isDark = document.documentElement.classList.contains('dark');
      if (darkToggle)
        darkToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
      if (darkIcon) darkIcon.textContent = isDark ? '☀️' : '🌙';
    }

    try {
      var stored = localStorage.getItem(darkKey);
      if (stored === 'dark') document.documentElement.classList.add('dark');
      if (stored === 'light') document.documentElement.classList.remove('dark');
    } catch (e) {}

    updateDarkUI();

    if (darkToggle) {
      darkToggle.addEventListener('click', function () {
        var isDark = document.documentElement.classList.toggle('dark');
        try {
          localStorage.setItem(darkKey, isDark ? 'dark' : 'light');
        } catch (e) {}
        updateDarkUI();
      });
    }

    if (sidebarToggle && sidebar) {
      // Initialize sidebar visibility from localStorage
      try {
        var stored = localStorage.getItem(sidebarKey);
        if (stored === 'true') {
          sidebar.classList.add('hidden');
          sidebarToggle.setAttribute('aria-expanded', 'false');
        } else if (stored === 'false') {
          sidebar.classList.remove('hidden');
          sidebarToggle.setAttribute('aria-expanded', 'true');
        } else {
          // If nothing stored, ensure aria reflects current DOM
          var expanded = sidebar.classList.contains('hidden') ? 'false' : 'true';
          sidebarToggle.setAttribute('aria-expanded', expanded);
        }
      } catch (e) {}

      sidebarToggle.addEventListener('click', function () {
        var nowHidden = sidebar.classList.toggle('hidden');
        var expanded = nowHidden ? 'false' : 'true';
        sidebarToggle.setAttribute('aria-expanded', expanded);
        try {
          localStorage.setItem(sidebarKey, nowHidden ? 'true' : 'false');
        } catch (e) {}
      });
    }

    // Profile menu toggle + accessibility (close on outside click / Escape)
    if (profileMenuButton && profileMenu) {
      function closeProfileMenu() {
        profileMenu.classList.add('hidden');
        profileMenu.setAttribute('aria-hidden', 'true');
        profileMenuButton.setAttribute('aria-expanded', 'false');
      }

      function openProfileMenu() {
        profileMenu.classList.remove('hidden');
        profileMenu.setAttribute('aria-hidden', 'false');
        profileMenuButton.setAttribute('aria-expanded', 'true');
      }

      profileMenuButton.addEventListener('click', function (e) {
        e.stopPropagation();
        if (profileMenu.classList.contains('hidden')) {
          openProfileMenu();
        } else {
          closeProfileMenu();
        }
      });

      // Close when clicking outside
      document.addEventListener('click', function (e) {
        if (
          !profileMenu.contains(e.target) &&
          !profileMenuButton.contains(e.target)
        ) {
          closeProfileMenu();
        }
      });

      // Close on Escape
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeProfileMenu();
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
