document.addEventListener('DOMContentLoaded', function () {
    const userIcon = document.querySelector('.user-icon');
    const userMenu = document.getElementById('user-menu');

    let isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

    function updateUserMenu(isLoggedIn) {
        userMenu.innerHTML = isLoggedIn
        ? `
            <li><a href="../my_account.php">Orders</a></li>
            <li><a href="../my_account.php?section=accountDetail">Account Detail</a></li>
            <li><a href="../login/logout.php" id="logout-btn">Logout</a></li>`
        : `
            <li><a href="../login/login.php">Login</a></li>
            <li><a href="../login/sign_up.php">Sign Up</a></li>`;
            if (isLoggedIn) {
                document.getElementById('logout-btn').addEventListener('click', handleLogout);
            }
        }
    
        function handleLogout(e) {
            e.preventDefault();
            isLoggedIn = false;
            localStorage.removeItem('isLoggedIn');
            updateUserMenu();
        }

    function showUserMenu() {
        userMenu.classList.add('show');
    }

    function hideUserMenu() {
        userMenu.classList.remove('show');
    }

    userIcon.addEventListener('mouseenter', showUserMenu);
    userIcon.addEventListener('mouseleave', function() {
        setTimeout(hideUserMenu, 300);
    });

    userMenu.addEventListener('mouseenter', function() {
        clearTimeout(hideUserMenu);
    });
    userMenu.addEventListener('mouseleave', hideUserMenu);

    document.getElementById('logout-btn').addEventListener('click', handleLogout);

    updateUserMenu();
});
