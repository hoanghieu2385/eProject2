function sign_up(e) {
    e.preventDefault();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var user = {
        username: username,
        password: password,
    };
    var json = JSON.stringify(user);
    localStorage.setItem(username, json);
    alert("Dang ki thanh cong");
}

function login(e) {
    e.preventDefault();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var user = localStorage.getItem(username);
    var data = JSON.parse(user);
    if(user == null) {
        alert("Vui long nhap lai tai khoan mat khau")
    }
    else if(username == data.username && password == data.password) {
        alert("Dang nhap thanh cong")
        window.location.href="index.php"
    }
    else {
        alert("Dang nhap that bai")
    }
}

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
