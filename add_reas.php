<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Repair Assignment</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
}

form {
    width: 50%;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"], input[type="date"], select, textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <h1>Add Repair Assignment</h1>
    
    <?php
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

    // Add repair assignment
    // Add repair assignment
if (isset($_POST['add'])) {
    // Extract data from the form
    $employee_id = $_POST['employee_id'];
    $device_id = $_POST['device_id'];
    $repair_status = $_POST['repair_status']; // This line is crucial for retrieving repair status
    $repair_date = $_POST['repair_date'];
    $pickup_date = $_POST['pickup_date'];
    $notes = $_POST['notes'];

    // Prepare and execute the SQL statement to insert data
    $sql = "INSERT INTO RepairAssignment (emp_first_name, emp_last_name, device_id, repair_status, repair_date, pickup_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissis", $emp_first_name, $emp_last_name, $device_id, $repair_status, $repair_date, $pickup_date, $notes);

    // Get the employee's first and last name based on employee_id
    $query_employee = "SELECT first_name, last_name FROM Employee WHERE employee_id = ?";
    $stmt_employee = $conn->prepare($query_employee);
    $stmt_employee->bind_param("i", $employee_id);
    $stmt_employee->execute();
    $result_employee = $stmt_employee->get_result();
    $row_employee = $result_employee->fetch_assoc();
    $emp_first_name = $row_employee['first_name'];
    $emp_last_name = $row_employee['last_name'];

    if ($stmt->execute()) {
        // Close prepared statements
        $stmt->close();
        $stmt_employee->close();
        // Redirect to main.php
        header("Location: repas.php");
        exit();
    } else {
        echo "<p>Error adding repair assignment: " . $conn->error . "</p>";
    }

    // Close prepared statements
    $stmt->close();
    $stmt_employee->close();
}
    ?>

    <form method="post">
        <?php
        // Fetch available employees
        $sql_employee = "SELECT employee_id, first_name, last_name FROM Employee";
        $result_employee = $conn->query($sql_employee);
        
        if ($result_employee->num_rows > 0) {
            echo "<label>Employee:</label> <select name='employee_id'>";
            while ($row_employee = $result_employee->fetch_assoc()) {
                echo "<option value='" . $row_employee["employee_id"] . "'>" . $row_employee["last_name"] . ", " . $row_employee["first_name"] . "</option>";
            }
            echo "</select><br>";
        } else {
            echo "<p>No employees available</p>";
        }

        // Fetch available device IDs
        $sql_device = "SELECT device_id FROM Device";
        $result_device = $conn->query($sql_device);
        
        if ($result_device->num_rows > 0) {
            echo "<label>Device ID:</label> <select name='device_id'>";
            while ($row_device = $result_device->fetch_assoc()) {
                echo "<option value='" . $row_device["device_id"] . "'>" . $row_device["device_id"] . "</option>";
            }
            echo "</select><br>";
        } else {
            echo "<p>No devices available</p>";
        }
        ?>
        <label>Repair Status:</label> 
        <select name="repair_status">
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
            <option value="Pending">Pending</option>
        </select><br>
        <label>Repair Date:</label> <input type="date" name="repair_date"><br>
        <label>Pickup Date:</label> <input type="date" name="pickup_date"><br>
        <label>Notes:</label> <textarea name="notes"></textarea><br>
        <input type="submit" name="add" value="Add Repair Assignment">
    </form>

    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>
