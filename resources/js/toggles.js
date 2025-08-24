// Toggle dark mode and sidebar; intended to be small and dependency-free
(function () {
  var darkKey = 'theme';

  function init() {
    var darkToggle = document.getElementById('darkModeToggle');
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');

    function updateDarkUI() {
      if (document.documentElement.classList.contains('dark')) {
        darkToggle && darkToggle.setAttribute('aria-pressed', 'true');
      } else {
        darkToggle && darkToggle.setAttribute('aria-pressed', 'false');
      }
    }

    function updateDarkIcon() {
      if (document.documentElement.classList.contains('dark')) {
        darkIcon && (darkIcon.textContent = '☀️');
        darkToggle && darkToggle.setAttribute('aria-pressed', 'true');
      } else {
        darkIcon && (darkIcon.textContent = '🌙');
        darkToggle && darkToggle.setAttribute('aria-pressed', 'false');
      }
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
      sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('hidden');
        var expanded = sidebar.classList.contains('hidden') ? 'false' : 'true';
        sidebarToggle.setAttribute('aria-expanded', expanded);
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
