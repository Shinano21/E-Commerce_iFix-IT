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
    const formData = new FormData(loginForm);

    // Send login credentials to server for authentication
    fetch("login.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Redirect to admin page after successful login
          window.location.href = "admin.html";
        } else {
          // Show error message if login fails
          alert("Invalid username or password. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
});
