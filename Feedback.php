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

    /* Review image CSS */
    .review-image {
      max-width: 100%;
      height: auto;
      max-height: 150px;
      display: block;
      margin: 10px 0;
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
      <h2 class="mb-4">Feedback Form</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
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

        <div class="mb-3">
          <label for="image" class="form-label">Upload Image:</label>
          <input type="file" class="form-control" id="image" name="image">
        </div>
       
        <button type="submit" style="background-color: #343a40; color: white;">Submit Feedback</button>
      </form>
      <!-- Go back to main.html link -->
      <div class="d-flex justify-content-center">
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

              $stmt = $conn->prepare("INSERT INTO Feedback (name, feedback_text, rating, image_name, image_type, image_data) VALUES (:name, :feedback, :rating, :image_name, :image_type, :image_data)");

              $name = $_POST['name'];
              $feedback = $_POST['feedback'];
              $rating = $_POST['rate'];

              $image_name = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
              $image_type = isset($_FILES['image']['type']) ? $_FILES['image']['type'] : null;
              $image_data = isset($_FILES['image']['tmp_name']) ? file_get_contents($_FILES['image']['tmp_name']) : null;

              $stmt->bindParam(':name', $name);
              $stmt->bindParam(':feedback', $feedback);
              $stmt->bindParam(':rating', $rating);
              $stmt->bindParam(':image_name', $image_name);
              $stmt->bindParam(':image_type', $image_type);
              $stmt->bindParam(':image_data', $image_data, PDO::PARAM_LOB);

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
    <div class="container mt-5 " >
      <h2 style="color:white;">Customer Reviews</h2>
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
                echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
                echo "<p class='card-text'>" . htmlspecialchars($row['feedback_text']) . "</p>";
                echo "<p class='card-text'><strong>Rating:</strong> " . htmlspecialchars($row['rating']) . "</p>";
                if (!empty($row['image_data'])) {
                    $imageData = base64_encode($row['image_data']);
                    echo "<img src='data:" . htmlspecialchars($row['image_type']) . ";base64," . $imageData . "' class='img-fluid review-image' />";
                }
                echo "</div>";
                echo "</div>";
            }
        } catch(PDOException $e) {
            echo "<p class='mt-3'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }

        $conn = null;
        ?>
      </div>
    </div>
  </main>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background-color: #e3f2fd;">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Log in</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="email" class="form-label">Email address:</label>
              <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Log in</button>
          </form>
        </div>
        <div class="modal-footer">
          <p>Don't have an account? <a href="#">Register here</a></p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
