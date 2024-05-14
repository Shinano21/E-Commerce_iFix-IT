<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iFixIT - Laptop Repair Service</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    /* Star rating CSS */
    .rate {
      float: left;
      height: 46px;
      padding: 0 10px;
    }
    .rate:not(:checked) > input {
      position: absolute;
      top: -9999px;
    }
    .rate:not(:checked) > label {
      float: right;
      width: 1em;
      overflow: hidden;
      white-space: nowrap;
      cursor: pointer;
      font-size: 50px;
      color: #ccc;
    }
    .rate:not(:checked) > label:before {
      content: '★ ';
    }
    .rate > input:checked ~ label {
      color: #ffc700;
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
      color: #deb217;
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
      color: #c59b08;
    }
  </style>
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
            <a class="nav-link" href="#" id="login-link">Log in</a>
            <a class="nav-link" href="Feedback.php" id="login-link">Feedback</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.5); width:600px;">
      <h2 class=" mb-4">Feedback Form</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3 d-flex justify-content-center align-items-center">
    
          <label for="rating" class="form-label mt-5">Rating:</label>
          
          <div class="rate">
            <input type="radio" id="star5" name="rate" value="5" />
            <label for="star5" title="text">5 stars</label>
            <input type="radio" id="star4" name="rate" value="4" />
            <label for="star4" title="text">4 stars</label>
            <input type="radio" id="star3" name="rate" value="3" />
            <label for="star3" title="text">3 stars</label>
            <input type="radio" id="star2" name="rate" value="2" />
            <label for="star2" title="text">2 stars</label>
            <input type="radio" id="star1" name="rate" value="1" />
            <label for="star1" title="text">1 star</label>
          </div>
        </div>
        <div class="mb-3">
          <label for="feedback" class="form-label">Feedback:</label>
          <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
        </div>
        
       
        <button type="submit" style=" background-color: #343a40; color: white;">Submit Feedback</button>
      </form>
      <!-- Go back to main.html link -->
      <div class="d-flex justify-content-center ">
        <a href="main.html" class="btn btn-light">Go back</a>
      </div>
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
              $stmt->bindParam(':rating', $_POST['rate']);  // Adjusted to capture star rating

              $stmt->execute();

              echo "<p class='mt-3'>Feedback submitted successfully!</p>";
          } catch(PDOException $e) {
              echo "<p class='mt-3'>Error: " . $e->getMessage() . "</p>";
          }

          $conn = null;
      }
      ?>
    </div>
  </main>

  <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="login-form" method="POST" action="authenticate.php">
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

      loginLink.addEventListener("click", function (event) {
        event.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById("login-modal"));
        myModal.show();
      });

      const loginForm = document.getElementById("login-form");
      loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(loginForm);

        fetch("login.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              window.location.href = "admin.html";
            } else {
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
