document.addEventListener('DOMContentLoaded', function () {
    const userIconBtn = document.getElementById('user-icon-btn');
    const userMenu = document.getElementById('user-menu');
    const loginLogoutBtn = document.getElementById('login-logout-btn');
    const manageAccount = document.getElementById('manage-account');

    // Kiểm tra trạng thái đăng nhập từ localStorage
    let isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

    function toggleUserMenu(show) {
        userMenu.classList.toggle('show', show);
    }

    function updateUI() {
        loginLogoutBtn.textContent = isLoggedIn ? 'Logout' : 'Login';
        manageAccount.style.display = isLoggedIn ? 'block' : 'none';

        loginLogoutBtn.href = isLoggedIn ? '#' : '../login/login.php';
    }

    // check login/logout 
    function handleLoginLogout(e) {
        if (isLoggedIn) {
            e.preventDefault();
            isLoggedIn = false;
            localStorage.removeItem('isLoggedIn'); // Xóa trạng thái đăng nhập từ localStorage
            updateUI();
            toggleUserMenu(false);
        } else {
            // Giả sử đăng nhập thành công
            // Trong thực tế, bạn sẽ xử lý đăng nhập ở trang login.php
            // và đặt isLoggedIn = 'true' trong localStorage khi đăng nhập thành công
            console.log('Chuyển hướng đến trang login.php');
        }
    }

    // hover icon user    userIconBtn.addEventListener('mouseenter', function() {
        toggleUserMenu(true);
    });

    userIconBtn.addEventListener('mouseleave', function() {
        setTimeout(function() {
            if (!userMenu.matches(':hover')) {
                toggleUserMenu(false);
            }
        }, 200);
    });

    userMenu.addEventListener('mouseleave', function() {
        setTimeout(function() {
            if (!userIconBtn.matches(':hover')) {
                toggleUserMenu(false);
            }
        }, 200);
    });

    loginLogoutBtn.addEventListener('click', handleLoginLogout);

    updateUI();
});
