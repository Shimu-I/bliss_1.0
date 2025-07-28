"use strict";

// Cache DOM elements
const loginBtn = document.getElementById("login-btn");
const loginForm = document.querySelector(".login-form");

// Debounce function to limit rapid clicks
const debounce = (func, wait) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func(...args), wait);
    };
};

// Toggle login form visibility
const toggleLoginForm = debounce(() => {
    loginForm.classList.toggle("active");
}, 200);

// Event listener for login button
loginBtn.addEventListener("click", toggleLoginForm);

// Go back function
function goBack() {
    window.history.back();
}

// Simulated auto-refresh by checking a timestamp in localStorage
let lastUpdate = localStorage.getItem("lastUpdate") || Date.now();

function checkForChanges() {
    const storedTime = localStorage.getItem("lastUpdate") || Date.now();
    if (parseInt(storedTime) > parseInt(lastUpdate)) {
        window.location.reload();
    }
}

// Poll every second for changes
setInterval(checkForChanges, 1000);

// Simulate a change for demo (e.g., update timestamp after 5 seconds)
window.addEventListener("load", () => {
    setTimeout(() => {
        localStorage.setItem("lastUpdate", Date.now());
    }, 5000);
});