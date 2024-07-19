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