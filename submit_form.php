<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // this is the default password
$dbname = "ifixit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data for insertion
$name = $_POST['name'];
$email = isset($_POST['email']) ? $_POST['email'] : "";
$phone_number = $_POST['contact'];
$address = $_POST['address'];
$brand = $_POST['device_brand'];
$issue_description = $_POST['issue_description'];

// Insert data into Customer table
$sql_customer = "INSERT INTO Customer (name, email, phone_number, address)
        VALUES ('$name', '$email', '$phone_number', '$address')";

if ($conn->query($sql_customer) === TRUE) {
    // Retrieve the auto-generated customer_id
    $customer_id = $conn->insert_id;
    
    // Insert data into Device table
    $sql_device = "INSERT INTO Device (brand, issue_description, customer_id)
        VALUES ('$brand', '$issue_description', '$customer_id')";
    
    if ($conn->query($sql_device) === TRUE) {
        echo "New records created successfully";
    } else {
        echo "Error: " . $sql_device . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_customer . "<br>" . $conn->error;
}

$conn->close();
?>
