document.addEventListener("DOMContentLoaded", function () {
  const loginLink = document.getElementById("login-link");
  const loginModal = document.getElementById("login-modal");
  const loginClose = document.querySelector(".close");
  const loginForm = document.getElementById("login-form");

  // Show modal when login link is clicked
  loginLink.addEventListener("click", function (event) {
    event.preventDefault();
    loginModal.style.display = "block";
  });

  // Close modal when close button is clicked
  loginClose.addEventListener("click", function () {
    loginModal.style.display = "none";
  });

  // Close modal when user clicks outside of the modal
  window.addEventListener("click", function (event) {
    if (event.target == loginModal) {
      loginModal.style.display = "none";
    }
  });

  // Form submission handling
  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();
    // You can add your authentication logic here
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Example of checking credentials (replace with your actual logic)
    if (username === "admin" && password === "admin") {
      alert("Login successful!");
      // Redirect to admin.html
      window.location.href = "admin.html";
    } else {
      alert("Invalid username or password. Please try again.");
    }
  });
});
