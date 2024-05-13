<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Navigation bar -->
        <nav>
            <ul>
                <li><a href="main.html">Home</a></li>
                <li><a href="repair.php">Repair Form</a></li>
                <li><a href="feedback.php">Feedback Form</a></li>
                <!-- Add more links as needed -->
            </ul>
        </nav>

        <h2>Feedback Form</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="feedback">Feedback:</label><br>
            <textarea id="feedback" name="feedback" rows="4" required></textarea><br>
            <label for="rating">Rating:</label><br>
            <input type="number" id="rating" name="rating" min="1" max="5" required><br>
            <button type="submit" name="submit">Submit Feedback</button>
        </form>
        <!-- Go back to main.html link -->
        <a href="main.html">Go back to main.html</a>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "username";
            $password = "password";
            $dbname = "your_database_name";

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
