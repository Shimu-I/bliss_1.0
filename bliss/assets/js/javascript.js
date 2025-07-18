// Toggle login form visibility when login button is clicked
const loginBtn = document.getElementById("login-btn");
const loginForm = document.querySelector(".login-form");

loginBtn.addEventListener("click", function() {
    loginForm.classList.toggle("active");
});

// JavaScript function to go back to the previous page in history
function goBack() {
    window.history.back();
}
