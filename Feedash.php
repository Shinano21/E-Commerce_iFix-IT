<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Feedback Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Feedback</th>
                    <th>Rating</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "ifixit";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT name, feedback_text, rating, created_at FROM Feedback ORDER BY created_at DESC");
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['feedback_text'] . "</td>";
                        echo "<td>" . $row['rating'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                } catch(PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }

                $conn = null;
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
