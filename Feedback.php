<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            display: inline-block;
            position: relative;
            color: gold;
        }

        .rating > span {
            display: inline-block;
            position: relative;
            width: 1.1em;
        }

        .rating > span:hover:before,
        .rating > span:hover ~ span:before {
            content: "\2605";
            position: absolute;
        }
    </style>
</head>
<body>
    <header>
      <nav
        class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body"
      >
        <div class="container-fluid">
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="collapse navbar-collapse justify-content-between"
            id="navbarNavAltMarkup"
          >
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
              <a class="nav-link" href="aboutus.html">About us</a>
            </div>
            <a class="navbar-brand" href="#">iFixIT</a>
            <div class="navbar-nav">
              <a class="nav-link" href="#" id="login-link">Log in</a>
              <a class="nav-link" href="Feedback.php" id="login-link"
                >Feedback</a
              >
            </div>
          </div>
        </div>
      </nav>
    </header>
    <div class="container">
        <h2>Feedback Form</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="feedback">Feedback:</label><br>
            <textarea id="feedback" name="feedback" rows="4" required></textarea><br>
            <label for="rating">Rating:</label><br>
            <div class="rating">
                <span><input type="radio" id="rating" name="rating" value="5" required></span>
                <span><input type="radio" id="rating" name="rating" value="4"></span>
                <span><input type="radio" id="rating" name="rating" value="3"></span>
                <span><input type="radio" id="rating" name="rating" value="2"></span>
                <span><input type="radio" id="rating" name="rating" value="1"></span>
            </div><br>
            <button type="submit" name="submit">Submit Feedback</button>
             <a class="button" href="main.html" id="go back"
                >Go Back</a
              >
        </form>
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

                echo "<p>Feedback submitted successfully!</p>";
            } catch(PDOException $e) {
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }

            $conn = null;
        }
        ?>
    </div>
</body>
</html>
