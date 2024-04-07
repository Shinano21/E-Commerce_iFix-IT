<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "ifixit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch device data
$sql = "SELECT d.device_id, d.brand, d.model, d.issue_description, c.name AS customer_name
        FROM Device d
        INNER JOIN Customer c ON d.customer_id = c.customer_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Device Table</h2>";
    echo "<table border='1'><tr><th>Device ID</th><th>Brand</th><th>Model</th><th>Issue Description</th><th>Customer Name</th></tr>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["device_id"]. "</td><td>" . $row["brand"]. "</td><td>" . $row["model"]. "</td><td>" . $row["issue_description"]. "</td><td>" . $row["customer_name"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
