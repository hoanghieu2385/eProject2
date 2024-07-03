function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.querySelector(".eye-icon");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}

window.onload = function() {
    if (document.cookie.indexOf("username") != -1) {
        document.getElementById("username").value = getCookie("username");
        document.getElementById("password").value = getCookie("password");
        document.getElementById("remember").checked = true;
    }
};

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

function showNotification(message) {
    var notification = document.getElementById("notification");
    notification.innerText = message;
    notification.classList.add("show");
    setTimeout(function() {
        notification.classList.remove("show");
    }, 5000);
}
