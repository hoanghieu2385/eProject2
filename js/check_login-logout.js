document.addEventListener('DOMContentLoaded', function () {
    const userIcon = document.querySelector('.user-icon');
    const userMenu = document.getElementById('user-menu');

    let hideTimeout;

    function checkLoginStatus() {
        const isLoggedInLocal = localStorage.getItem('isLoggedIn') === 'true';
        
        fetch('../includes/check_login_status.php', { 
            method: 'GET',
            credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {
            const isLoggedInServer = data.isLoggedIn;
            updateUserMenu(isLoggedInLocal && isLoggedInServer);
        })
        .catch(error => {
            console.error('Error:', error);
            updateUserMenu(isLoggedInLocal);
        });
    }

    function updateUserMenu(isLoggedIn) {
        userMenu.innerHTML = isLoggedIn
            ? `
                <li><a href="../my_account.php">Orders</a></li>
                <li><a href="../my_account.php?section=accountDetail">Account Detail</a></li>
                <li><a href="#" id="logout-btn">Logout</a></li>`
            : `
                <li><a href="../login/login.php">Login</a></li>
                <li><a href="../login/sign_up.php">Sign Up</a></li>`;

        if (isLoggedIn) {
            document.getElementById('logout-btn').addEventListener('click', handleLogout);
        }
    }

    function handleLogout(e) {
        e.preventDefault();
        fetch('../login/logout.php', { 
            method: 'POST',
            credentials: 'include'
        })
        .then(() => {
            localStorage.removeItem('isLoggedIn');
            checkLoginStatus();
        })
        .catch(error => console.error('Error:', error));
    }

    function showUserMenu() {
        clearTimeout(hideTimeout);
        userMenu.classList.add('show');
    }

    function hideUserMenu() {
        hideTimeout = setTimeout(() => {
            userMenu.classList.remove('show');
        }, 300);
    }

    userIcon.addEventListener('mouseenter', showUserMenu);
    userIcon.addEventListener('mouseleave', hideUserMenu);
    userMenu.addEventListener('mouseenter', showUserMenu);
    userMenu.addEventListener('mouseleave', hideUserMenu);

    checkLoginStatus();
});
