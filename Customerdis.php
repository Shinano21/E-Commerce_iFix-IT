<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ifixit";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$search_query = "";
$sql = "SELECT c.name, r.repair_status, r.pickup_date, CONCAT(e.first_name, ' ', e.last_name) AS employee_name
        FROM customer c
        LEFT JOIN device d ON c.customer_id = d.customer_id
        LEFT JOIN repairassignment r ON d.device_id = r.device_id
        LEFT JOIN employee e ON r.emp_first_name = e.first_name AND r.emp_last_name = e.last_name
        ORDER BY c.name";

// Handle search
if(isset($_GET['search'])){
    $search_query = $_GET['search'];
    $sql = "SELECT c.name, r.repair_status, r.pickup_date, CONCAT(e.first_name, ' ', e.last_name) AS employee_name
            FROM customer c
            LEFT JOIN device d ON c.customer_id = d.customer_id
            LEFT JOIN repairassignment r ON d.device_id = r.device_id
            LEFT JOIN employee e ON r.emp_first_name = e.first_name AND r.emp_last_name = e.last_name
            WHERE c.name LIKE '%$search_query%'
            ORDER BY c.name";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Display</title>
</head>
<body>

<h2>Customer Information</h2>

<!-- Search bar -->
<form method="GET">
    <input type="text" name="search" placeholder="Search by customer name" value="<?php echo $search_query; ?>">
    <input type="submit" value="Search">
</form>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Repair Status</th>
        <th>Pickup Date</th>
        <th>Employee In Charge</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['repair_status'] . "</td>";
            echo "<td>" . $row['pickup_date'] . "</td>";
            echo "<td>" . $row['employee_name'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found</td></tr>";
    }
    ?>
</table>

<?php
$conn->close();
?>

</body>
</html>
