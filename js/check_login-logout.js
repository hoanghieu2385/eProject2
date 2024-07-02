document.addEventListener('DOMContentLoaded', function () {
    const userIconBtn = document.getElementById('user-icon-btn');
    const userMenu = document.getElementById('user-menu');
    const loginLogoutBtn = document.getElementById('login-logout-btn');
    const orderHistoryLink = document.getElementById('orderHistory');
    const accountDetailLink = document.getElementById('accountDetail');
    const signUpLink = document.getElementById('signUp');


    function updateLoginStatus() {
        fetch('../includes/check_login_status.php') // Call a PHP script to check login status
            .then(response => response.json())
            .then(data => {
                if (data.isLoggedIn) {
                    loginLogoutBtn.textContent = 'Logout';
                    loginLogoutBtn.href = '../login/logout.php';
                    orderHistoryLink.style.display = 'block';
                    accountDetailLink.style.display = 'block';
                    signUpLink.style.display = 'none';

                } else {
                    loginLogoutBtn.textContent = 'Login';
                    loginLogoutBtn.href = '../login/login.php';
                    orderHistoryLink.style.display = 'none';
                    accountDetailLink.style.display = 'none';
                    signUpLink.style.display = 'block';

                }
            });
    }
    
    userIconBtn.addEventListener('mouseenter', function () { // Use mouseenter
        userMenu.classList.add('show'); // Add 'show' class
        updateLoginStatus(); // Update menu on hover
    });

    userIconBtn.addEventListener('mouseleave', function () { // Use mouseleave
        userMenu.classList.remove('show'); // Remove 'show' class
    });


    // Initial update when the page loads
    updateLoginStatus();

});
