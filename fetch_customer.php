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

$sql = "SELECT * FROM Customer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone Number</th><th>Address</th><th>Gender</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["customer_id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["phone_number"]. "</td><td>" . $row["address"]. "</td><td>" . $row["gender"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
