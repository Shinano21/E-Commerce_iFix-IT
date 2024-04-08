<?php
// Check if repair ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect or display an error message
    exit("Invalid repair ID");
}

$repair_id = $_GET['id'];

// Database connection details
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$database = "ifixit"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the repair assignment from the database
$sql = "DELETE FROM RepairAssignment WHERE repair_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $repair_id);
$stmt->execute();

// Check if the deletion was successful
if ($stmt->affected_rows > 0) {
    // Redirect back to main.php
    header("Location: repas.php");
    exit(); // Ensure script execution stops after redirection
} else {
    echo "Error deleting repair assignment: " . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
