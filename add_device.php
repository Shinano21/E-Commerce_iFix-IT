<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "ifixit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$device_brand = $_POST['device_brand'];
$device_model = $_POST['device_model'];
$device_issue = $_POST['device_issue'];

$sql = "INSERT INTO Device (brand, model, issue_description) VALUES ('$device_brand', '$device_model', '$device_issue')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
