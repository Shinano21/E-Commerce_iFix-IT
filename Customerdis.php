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
    <link rel="stylesheet" href="styles.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
 
   <style>

        .container {
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px;
            margin-top: 50px; /* Adjust as needed */
        }
        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mt-3">Customer Information</h2>

    <!-- Search bar -->
    <form method="GET" class="search-form">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search by customer name" value="<?php echo $search_query; ?>">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Repair Status</th>
            <th>Pickup Date</th>
            <th>Employee In Charge</th>
        </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>
    
</div>
<a href="main.html" style=" background-color: white; color: black;" class="home-link">Go back to Home Page</a>
<?php
$conn->close();
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
