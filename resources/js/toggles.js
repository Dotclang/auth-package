// Toggle dark mode and sidebar; intended to be small and dependency-free
(function () {
  var darkKey = 'dotclang_dark';
  var darkToggle = document.getElementById('darkToggle');
  var darkIcon = document.getElementById('darkIcon');

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
    if (stored === '1') document.documentElement.classList.add('dark');
    if (stored === '0') document.documentElement.classList.remove('dark');
  } catch (e) {}

  updateDarkIcon();

  if (darkToggle) {
    darkToggle.addEventListener('click', function () {
      var isDark = document.documentElement.classList.toggle('dark');
      try {
        localStorage.setItem(darkKey, isDark ? '1' : '0');
      } catch (e) {}
      updateDarkIcon();
    });
  }

  var sidebarToggle = document.getElementById('sidebarToggle');
  var sidebar = document.getElementById('sidebar');
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('hidden');
      var expanded = sidebar.classList.contains('hidden') ? 'false' : 'true';
      sidebarToggle.setAttribute('aria-expanded', expanded);
    });
  }
})();
