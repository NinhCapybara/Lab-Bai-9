(function () {
  var storageKey = 'feedbackhub-theme';
  var savedTheme = localStorage.getItem(storageKey);
  var initialTheme = savedTheme || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

  document.documentElement.setAttribute('data-theme', initialTheme);

  function updateThemeButton(theme) {
    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
      var darkMode = theme === 'dark';
      button.textContent = darkMode ? '☀ Giao diện sáng' : '☾ Giao diện tối';
      button.setAttribute('aria-pressed', darkMode ? 'true' : 'false');
      button.setAttribute('aria-label', darkMode ? 'Chuyển sang giao diện sáng' : 'Chuyển sang giao diện tối');
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    updateThemeButton(initialTheme);
    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
      button.addEventListener('click', function () {
        var nextTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', nextTheme);
        localStorage.setItem(storageKey, nextTheme);
        updateThemeButton(nextTheme);
      });
    });
  });
}());
