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

// Initialize variables
$search = "";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Fetch transactions based on search criteria
$sql = "SELECT c.name AS customer_name, t.repair_status FROM `transaction` t
        INNER JOIN `customer` c ON t.customer_id = c.customer_id
        WHERE c.name LIKE '%$search%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Transaction History</h1>

<form method="GET" action="">
    <input type="text" name="search" placeholder="Search by customer name...">
    <button type="submit">Search</button>
</form>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Customer Name: " . $row["customer_name"] . " - Repair Status: " . $row["repair_status"] . "</p>";
    }
} else {
    echo "<p>No transactions found.</p>";
}
?>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
