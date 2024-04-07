<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="emp_styles.css">
</head>
<body>
<header>
    <div class="header-content">
        <h1>Employee Management</h1>
        <nav>
            <ul>
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="customer.php">Customers</a></li>
                <li><a href="transaction.php">Transactions</a></li>
                <li><a href="employee.php">Employees</a></li>
                <li><button id="logout">Logout</button></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Search bar for filtering employees by first name and last name -->
<div id="search-bar">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <label for="search">Search by Name:</label>
        <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" placeholder="Enter first name or last name">
        <button type="submit">Search</button>
    </form>
</div>

<!-- Table for displaying employee data -->
<div id="employee-table">
    <h2>Employee List</h2>
    <table>
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Date of Birth</th>
            <th>Position ID</th>
            <th>Schedule ID</th>
            <th>Action</th>
        </tr>
        <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ifixit";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch and display filtered employee data in table rows
        $sql = "SELECT * FROM employee";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql .= " WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%'";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['employee_id']."</td>";
                echo "<td>".$row['first_name']."</td>";
                echo "<td>".$row['last_name']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['phone_number']."</td>";
                echo "<td>".$row['address']."</td>";
                echo "<td>".$row['date_of_birth']."</td>";
                echo "<td>".$row['position_id']."</td>";
                echo "<td>".$row['schedule_id']."</td>";
                echo "<td>";
                echo "<a href='emp_edit.php?id=".$row['employee_id']."' class='edit-button'>Edit</a>";
                echo "<form action='delete_employee.php' method='post' style='display: inline; margin-left: 10px;'>";
                echo "<input type='hidden' name='employee_id' value='".$row['employee_id']."'>";
                echo "<button type='submit' class='delete-button'>Delete</button>";
                echo "</form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No employees found</td></tr>";
        }

        // Close database connection
        $conn->close();
        ?>
    </table>
</div>

<!-- Button to add new employee -->
<div id="add-employee-button">
    <a href="emp_add.php" class="button">Add Employee</a>
</div>

</body>
</html>
