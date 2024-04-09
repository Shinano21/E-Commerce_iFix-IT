<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "ifixit"; // Replace with your database name
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from form
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check user credentials
$sql = "SELECT * FROM Admin WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User authenticated, set session variable
    $_SESSION['username'] = $username;
    // Return JSON response indicating success
    echo json_encode(["success" => true]);
} else {
    // Authentication failed, return JSON response indicating failure
    echo json_encode(["success" => false]);
}

$conn->close();
?>
