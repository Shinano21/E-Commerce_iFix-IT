<?php
// Database connection parameters
$servername = "localhost"; // Change this if your MySQL server is running on a different host
$username = "root"; // Change this if your MySQL username is different
$password = ""; // Change this if your MySQL password is different
$database = "ifixit"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if employee ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p class='alert alert-danger'>Employee ID is missing.</p>";
} else {
    $employee_id = $_GET['id'];

    // Validate if the provided ID is numeric
    if (!is_numeric($employee_id)) {
        echo "<p class='alert alert-danger'>Invalid employee ID.</p>";
    } else {
        // Delete employee from the database
        $sql = "DELETE FROM employee WHERE employee_id = $employee_id";

        if ($conn->query($sql) === TRUE) {
            // Redirect to employee.php after successful delete
            header("Location: employee.php");
            exit();
        } else {
            // Check if the error is related to foreign key constraint
            if (strpos($conn->error, 'foreign key constraint fails') !== false) {
                echo "<p class='alert alert-danger'>Error deleting employee: Cannot delete or update a parent row: a foreign key constraint fails</p>";
            } else {
                // Display generic error message
                echo "<p class='alert alert-danger'>Error deleting employee: " . $conn->error . "</p>";
            }
        }
    }
}

// Close database connection
$conn->close();
?>