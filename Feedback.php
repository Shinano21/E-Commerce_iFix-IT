<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iFixIT - Laptop Repair Service</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            <a class="nav-link" href="aboutus.html">About us</a>
          </div>
          <a class="navbar-brand" href="#">iFixIT</a>
          <div class="navbar-nav">
            <a class="nav-link" href="Feedback.php" id="feedback">Feedback</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container">
      <h2 class="mt-5 mb-4">Feedback Form</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="feedback" class="form-label">Feedback:</label>
          <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
        </div>
        <div class="mb-3">
          <label for="rating" class="form-label">Rating:</label>
          <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Feedback</button>
      </form>
      <!-- Go back to main.html link -->
      <a href="main.html" class="btn btn-secondary mt-3">Go back</a>
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "ifixit";

          try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $stmt = $conn->prepare("INSERT INTO Feedback (name, feedback_text, rating) VALUES (:name, :feedback, :rating)");

              $stmt->bindParam(':name', $_POST['name']);
              $stmt->bindParam(':feedback', $_POST['feedback']);
              $stmt->bindParam(':rating', $_POST['rating']);

              $stmt->execute();

              echo "<p class='mt-3'>Feedback submitted successfully!</p>";
          } catch(PDOException $e) {
              echo "<p class='mt-3'>Error: " . $e->getMessage() . "</p>";
          }

          $conn = null;
      }
      ?>
    </div>

    <!-- Reviews Section -->
    <div class="container mt-5">
      <h2>Customer Reviews</h2>
      <div id="reviews">
        <?php
        // Fetch reviews from the database and display them
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ifixit";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM Feedback");
            $stmt->execute();

            // Display each review
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                echo "<p class='card-text'>" . $row['feedback_text'] . "</p>";
                echo "<p class='card-text'><strong>Rating:</strong> " . $row['rating'] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } catch(PDOException $e) {
            echo "<p class='mt-3'>Error: " . $e->getMessage() . "</p>";
        }

        $conn = null;
        ?>
      </div>
    </div>
  </main>

  <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <br />
        <div class="modal-body">
          <br />
          <form id="login-form" method="POST" action="authenticate.php">
            <!-- Change action to your PHP login processing script -->
            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" id="username" name="username" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button type="submit" style="background-color: #343a40; color: white">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const loginLink = document.getElementById("login-link");

      // Show modal when login link is clicked
      loginLink.addEventListener("click", function (event) {
        event.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById("login-modal"));
        myModal.show();
      });

      // Form submission handling
      const loginForm = document.getElementById("login-form");
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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
