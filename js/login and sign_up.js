function sign_up(e) {
    event.preventDefault();
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
    event.preventDefault();
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