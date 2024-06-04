const darkModeCheckbox = document.getElementById('dark-mode-checkbox');
const body = document.body;

// Check session for dark mode preference
const isDarkMode = sessionStorage.getItem('dark_mode') === 'true';
if (isDarkMode) {
    body.classList.add('dark-mode');
    darkModeCheckbox.checked = true;
}

darkModeCheckbox.addEventListener('change', function () {
    const formData = new FormData();
    formData.append('dark_mode', this.checked);
    fetch('update_dark_mode.php', {
        method: 'POST',
        body: formData
    });

    // Update session storage for immediate effect
    sessionStorage.setItem('dark_mode', this.checked);
    if (this.checked) {
        body.classList.add('dark-mode');
    } else {
        body.classList.remove('dark-mode');
    }
});