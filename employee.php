<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
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

<!-- Placeholder for displaying employee data -->
<div id="employee-list">
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

    // Add Employee
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['employee-name']) && isset($_POST['employee-email'])){
            $name = $_POST['employee-name'];
            $email = $_POST['employee-email'];
            
            $sql = "INSERT INTO Employee (first_name, email) VALUES ('$name', '$email')";
            if ($conn->query($sql) === TRUE) {
                echo "New employee added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Delete Employee
        if(isset($_POST['delete-employee-id'])){
            $employee_id = $_POST['delete-employee-id'];
            $sql = "DELETE FROM Employee WHERE employee_id=$employee_id";
            if ($conn->query($sql) === TRUE) {
                echo "Employee deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }

    // SQL query to retrieve employee data
    $sql = "SELECT * FROM Employee";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<div id='employee-" . $row["employee_id"] . "'>";
            echo "<p>";
            echo "Employee ID: " . $row["employee_id"] . "<br>";
            echo "Name: " . $row["first_name"] . "<br>";
            echo "Email: " . $row["email"] . "<br>";
            echo "<form method='post' style='display:inline;'><input type='hidden' name='delete-employee-id' value='" . $row["employee_id"] . "'><button type='submit'>Delete</button></form>";
            echo "</p>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
</div>
<!-- Form for adding new employees -->
<form id="add-employee-form" method="post">
    <h2>Add New Employee</h2>
    <label for="employee-name">Name:</label>
    <input type="text" id="employee-name" name="employee-name" required />
    <label for="employee-email">Email:</label>
    <input type="email" id="employee-email" name="employee-email" required />
    <button type="submit">Add Employee</button>
</form>
</body>
</html>
