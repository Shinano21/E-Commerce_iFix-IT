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

// Fetch customer data
$sql = "SELECT customer_id, name, email, phone_number, address FROM customer"; // Adjusted table name to lowercase
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>List of Customers</h2>";
    echo "<ul>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<li><strong>Customer ID:</strong> " . $row["customer_id"]. "</li>";
        echo "<li><strong>Name:</strong> " . $row["name"]. "</li>";
        echo "<li><strong>Email:</strong> " . $row["email"]. "</li>";
        echo "<li><strong>Phone Number:</strong> " . $row["phone_number"]. "</li>";
        echo "<li><strong>Address:</strong> " . $row["address"]. "</li>";
        echo "<hr>";
    }
    echo "</ul>";
} else {
    echo "0 results";
}
$conn->close();
?>
