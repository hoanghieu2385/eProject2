document.addEventListener('DOMContentLoaded', function () {
    const userIconBtn = document.getElementById('user-icon-btn');
    const userMenu = document.getElementById('user-menu');
    const loginLogoutBtn = document.getElementById('login-logout-btn');
    const manageAccount = document.getElementById('manage-account');

    // show / hide menu in user-icon
    let isLoggedIn = false;

    function toggleUserMenu(show) {
        userMenu.classList.toggle('show', show);
    }

    function updateUI() {
        loginLogoutBtn.textContent = isLoggedIn ? 'Logout' : 'Login';
        manageAccount.style.display = isLoggedIn ? 'block' : 'none';
    }

    // check login/logout 
    function handleLoginLogout(e) {
        e.preventDefault();
        isLoggedIn = !isLoggedIn;
        alert(isLoggedIn ? 'Đã đăng nhập' : 'Đã đăng xuất');
        updateUI();
        toggleUserMenu(false);
    }

    userIconBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleUserMenu();
    });

    document.addEventListener('click', function (e) {
        if (!userMenu.contains(e.target) && e.target !== userIconBtn) {
            toggleUserMenu(false);
        }
    });

    loginLogoutBtn.addEventListener('click', handleLoginLogout);

    updateUI();
});