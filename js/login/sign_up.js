function togglePasswordVisibility(fieldId) {
    var passwordField = document.getElementById(fieldId);
    var eyeIcon = passwordField.nextElementSibling;

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

function checkEmailAvailability() {
    var email = document.getElementById('email').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            if (response.exists) {
                document.getElementById('email-error').innerText = 'This email is already registered.';
            } else {
                document.getElementById('email-error').innerText = '';
            }
        }
    };
    xhr.open("GET", "check_email.php?email=" + email, true);
    xhr.send();
}