<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iFixIT - Laptop Repair Service</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    /* Add your custom styles here */
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
            <a class="nav-link" href="#feedback" id="feedback-link">Feedback</a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container">
      <h2 class="mt-5 mb-4">Feedback Form</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
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
        <div class="mb-3">
          <label for="image" class="form-label">Upload Image:</label>
          <input type="file" class="form-control" id="image" name="image">
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

              $stmt = $conn->prepare("INSERT INTO Feedback (name, feedback_text, rating, image_name, image_type, image_data) VALUES (:name, :feedback, :rating, :image_name, :image_type, :image_data)");

              $name = $_POST['name'];
              $feedback = $_POST['feedback'];
              $rating = $_POST['rating'];

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
                if (!empty($row['image_data'])) {
                    $imageData = base64_encode($row['image_data']);
                    echo "<img src='data:" . $row['image_type'] . ";base64," . $imageData . "' class='img-fluid' />";
                }
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
