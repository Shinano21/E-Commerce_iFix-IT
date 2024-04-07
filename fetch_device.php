<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "ifixit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Device";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Devices</h2><table border='1'><tr><th>ID</th><th>Brand</th><th>Model</th><th>Issue Description</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["device_id"]. "</td><td>" . $row["brand"]. "</td><td>" . $row["model"]. "</td><td>" . $row["issue_description"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
