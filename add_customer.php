<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "ifixit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// hhhh
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$gender = $_POST['gender'];

$sql = "INSERT INTO Customer (name, email, phone_number, address, gender) VALUES ('$customer_name', '$customer_email', '$phone_number', '$address', '$gender')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
