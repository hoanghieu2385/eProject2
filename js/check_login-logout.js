document.addEventListener('DOMContentLoaded', function () {
    const userIconBtn = document.getElementById('user-icon-btn');
    const userMenu = document.getElementById('user-menu');
    const logoutBtn = document.getElementById('logout-btn');
    const loginBtn = document.getElementById('login-btn');
    const orderHistoryLink = document.getElementById('orderHistory');
    const accountDetailLink = document.getElementById('accountDetail');
    const signUpLink = document.getElementById('signUp-btn');


    function updateLoginStatus() {
        fetch('../includes/check_login_status.php') // Call a PHP script to check login status
            .then(response => response.json())
            .then(data => {
                if (data.isLoggedIn) {
                    orderHistoryLink.style.display = 'block';
                    accountDetailLink.style.display = 'block';
                    logoutBtn.style.display = 'block';
                    loginBtn.style.display = 'none';
                    signUpLink.style.display = 'none';

                } else {
                    orderHistoryLink.style.display = 'none';
                    accountDetailLink.style.display = 'none';
                    logoutBtn.style.display = 'none';
                    loginBtn.style.display = 'block';
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
