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
            alert('Đã đăng xuất');
            updateUI();
            toggleUserMenu(false);
        } else {
            // Giả sử đăng nhập thành công
            // Trong thực tế, bạn sẽ xử lý đăng nhập ở trang login.php
            // và đặt isLoggedIn = 'true' trong localStorage khi đăng nhập thành công
            console.log('Chuyển hướng đến trang login.php');
        }
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