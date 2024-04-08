<?php
// Get username and password from POST request
$input_username = $_POST['username'];
$input_password = $_POST['password'];

// Database connection parameters
$database = "ifixit";

// Create connection
$conn = new mysqli('localhost', 'root', '', $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to retrieve admin record
$stmt = $conn->prepare("SELECT * FROM Admin WHERE username = ?");
$stmt->bind_param("s", $input_username);
$stmt->execute();
$result = $stmt->get_result();

// Check if admin record exists
if ($result->num_rows > 0) {
    // Admin record found, fetch row
    $admin = $result->fetch_assoc();
    // Verify password
    if ($admin['password'] == $input_password) {
        // Password matches, return success response
        echo json_encode(array("success" => true));
    } else {
        // Password does not match, return error response
        echo json_encode(array("success" => false));
    }
} else {
    // Admin record not found, return error response
    echo json_encode(array("success" => false));
}

// Close database connection
$stmt->close();
$conn->close();
?>
