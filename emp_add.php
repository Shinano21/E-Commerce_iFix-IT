<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="emp_add_styles.css">
</head>
<body>
<header>
    <div class="header-content">
        <h1>Add Employee</h1>
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

<!-- Form for adding new employee -->
<div id="add-employee-form">
    <h2>Add New Employee</h2>
    <?php
    // Check if the form is submitted and display success message
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ifixit";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the INSERT statement
        $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, email, phone_number, address, date_of_birth, position_id, schedule_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssii", $first_name, $last_name, $email, $phone_number, $address, $date_of_birth, $position_id, $schedule_id);

        // Set parameters and execute the statement
        $first_name = $_POST["first-name"];
        $last_name = $_POST["last-name"];
        $email = $_POST["email"];
        $phone_number = $_POST["phone-number"];
        $address = $_POST["address"];
        $date_of_birth = $_POST["date-of-birth"];
        $position_id = $_POST["position-id"];
        $schedule_id = $_POST["schedule-id"];

        if ($stmt->execute()) {
            echo "<p class='success-message'>Employee added successfully!</p>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" name="first-name" required>
        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" name="last-name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="phone-number">Phone Number:</label>
        <input type="text" id="phone-number" name="phone-number">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address">
        <label for="date-of-birth">Date of Birth:</label>
        <input type="date" id="date-of-birth" name="date-of-birth">
        <label for="position-id">Position ID:</label>
        <input type="text" id="position-id" name="position-id">
        <label for="schedule-id">Schedule ID:</label>
        <input type="text" id="schedule-id" name="schedule-id">
        <button type="submit">Add Employee</button>
    </form>
</div>

</body>
</html>
