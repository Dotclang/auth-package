// Toggle dark mode and sidebar; intended to be small and dependency-free
(function () {
  var darkKey = 'theme';

  function init() {
    var darkToggle = document.getElementById('darkModeToggle');
    // optional element for showing an emoji/icon inside the toggle (not required)
    var darkIcon = document.getElementById('darkModeIcon');
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');
    var sidebarKey = 'sidebarHidden';
    var profileMenuButton = document.getElementById('profileMenuButton');
    var profileMenu = document.getElementById('profileMenu');

    var darkLabel = document.getElementById('darkModeLabel');

    function applyTheme(mode) {
      // mode: 'auto' | 'dark' | 'light'
      if (mode === 'dark') {
        document.documentElement.classList.add('dark');
      } else if (mode === 'light') {
        document.documentElement.classList.remove('dark');
      } else {
        // auto: follow prefers-color-scheme
        try {
          var prefersDark = window.matchMedia(
            '(prefers-color-scheme: dark)',
          ).matches;
          if (prefersDark) document.documentElement.classList.add('dark');
          else document.documentElement.classList.remove('dark');
        } catch (e) {
          document.documentElement.classList.remove('dark');
        }
      }
      // Update aria-pressed to indicate whether dark is active
      if (darkToggle)
        darkToggle.setAttribute(
          'aria-pressed',
          document.documentElement.classList.contains('dark')
            ? 'true'
            : 'false',
        );
      // Update label text
      if (darkLabel) {
        var labelText =
          mode === 'auto' ? 'Auto' : mode === 'dark' ? 'Dark' : 'Light';
        darkLabel.textContent = labelText;
      }
      if (darkIcon) {
        if (mode === 'auto') darkIcon.textContent = '🌓';
        else if (mode === 'dark') darkIcon.textContent = '🌙';
        else darkIcon.textContent = '☀️';
      }
    }

    // initialize from storage
    try {
      var storedMode = localStorage.getItem(darkKey);
      if (!storedMode) storedMode = 'auto';
    } catch (e) {
      var storedMode = 'auto';
    }

    applyTheme(storedMode);

    if (darkToggle) {
      var themeMenu = document.getElementById('themeMenu');

      var lastFocused = null;

      function openThemeMenu() {
        if (!themeMenu) return;
        lastFocused = document.activeElement;
        themeMenu.classList.remove('hidden');
        themeMenu.setAttribute('aria-hidden', 'false');
        darkToggle.setAttribute('aria-expanded', 'true');
        // move focus to first menu item
        var first = themeMenu.querySelector('[role="menuitem"]');
        if (first && typeof first.focus === 'function') first.focus();
      }

      function closeThemeMenu() {
        if (!themeMenu) return;
        themeMenu.classList.add('hidden');
        themeMenu.setAttribute('aria-hidden', 'true');
        darkToggle.setAttribute('aria-expanded', 'false');
        // restore focus to the toggle to avoid hidden element retaining focus
        try {
          if (lastFocused && typeof lastFocused.focus === 'function')
            lastFocused.focus();
          else if (darkToggle && typeof darkToggle.focus === 'function')
            darkToggle.focus();
        } catch (e) {}
      }

      darkToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        if (!themeMenu) return;
        if (themeMenu.classList.contains('hidden')) openThemeMenu();
        else closeThemeMenu();
      });

      // handle option clicks inside the menu
      var themeOptions = themeMenu
        ? themeMenu.querySelectorAll('[data-theme-option]')
        : [];
      themeOptions.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
          var choice = btn.getAttribute('data-theme-option');
          try {
            localStorage.setItem(darkKey, choice);
          } catch (e) {}
          applyTheme(choice);
          closeThemeMenu();
        });
      });

      // Close when clicking outside
      document.addEventListener('click', function (e) {
        if (!themeMenu) return;
        if (!themeMenu.contains(e.target) && !darkToggle.contains(e.target)) {
          closeThemeMenu();
        }
      });

      // Close on Escape
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeThemeMenu();
      });

      // if in auto mode, react to system theme changes
      try {
        var mql = window.matchMedia('(prefers-color-scheme: dark)');
        if (mql && typeof mql.addEventListener === 'function') {
          mql.addEventListener('change', function () {
            try {
              var cur = localStorage.getItem(darkKey) || 'auto';
            } catch (e) {
              var cur = 'auto';
            }
            if (cur === 'auto') applyTheme('auto');
          });
        }
      } catch (e) {}
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
          var expanded = sidebar.classList.contains('hidden')
            ? 'false'
            : 'true';
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
