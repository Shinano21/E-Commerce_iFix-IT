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

<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Repair Status</th>
        </tr>
    </thead>
    <tbody>
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

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["customer_name"] . "</td>";
                echo "<td>" . $row["repair_status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No transactions found.</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>
