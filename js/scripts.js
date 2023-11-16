// JavaScript Document
var registerBtn = document.getElementById('register-btn');
registerBtn.addEventListener('click', function () {
    var registerForm = document.getElementById('register-form');
    if (registerForm.classList.contains("hidden")) {
        console.log("YES");
        registerForm.classList.remove("hidden")
    } else {
        console.log("NO");
        registerForm.classList.add("hidden")
    }
}, false);

var loginBtn = document.getElementById('login-btn');
loginBtn.addEventListener('click', function () {
    var loginForm = document.getElementById('login-form');
    if (loginForm.classList.contains("hidden")) {
        console.log("YES");
        loginForm.classList.remove("hidden")
    } else {
        console.log("NO");
        loginForm.classList.add("hidden")
    }
}, false);


