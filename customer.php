<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cus_styles.css">
    <title>Customer Management</title>
   
</head>
<body>
<header>
    <div class="header-content">
        <h1>Customer Management</h1>
        <nav>
            <ul>
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="customer.php">Customers</a></li>
                <li><a href="transaction.php">Transactions</a></li>
                <li><a href="employee.php">Employees</a></li>
                <li><a href="repas.php">Repair Assignment</a></li>
                <li><button id="logout">Logout</button></li>
            </ul>
        </nav>
    </div>
</header>

<div id="customer-list">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Address</th>
            <th scope="col">Gender</th>
            <th scope="col">Brand</th>
            <th scope="col">Model</th>
            <th scope="col">Issue Description</th>
            <th scope="col">Operations</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ifixit";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT c.customer_id, c.name, c.email, c.phone_number, c.address, c.gender, d.brand, d.issue_description FROM customer c JOIN device d ON c.customer_id = d.customer_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['customer_id'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['phone_number'] . '</td>';
                echo '<td>' . $row['address'] . '</td>';
                echo '<td>' . $row['gender'] . '</td>';
                echo '<td>' . $row['brand'] . '</td>';
                  echo '<td>';
                echo '<td>' . $row['issue_description'] . '</td>';
                echo '<td>';
                  echo '<td>';
                echo '<button class="btn btn-primary" id="btn-edit"><a href="edit_customer.php?id=' . $row['customer_id'] . '" class="text-light">Edit</a></button>';
                echo '<button class="btn btn-danger" ><a href="delete_customer.php?id=' . $row['customer_id'] . '" class="text-light">Delete</a></button>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='10'>0 results</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
    <script>
    document.getElementById('logout').addEventListener('click', function() {
        var confirmLogout = confirm('Do you want to logout?');
        if (confirmLogout) {
            window.location.href = 'main.html';
        }
    });
</script>
</div>
</body>
</html>
