<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="emp_edit_styles.css">
</head>
<body>
<header>
    <div class="header-content">
        <h1>Edit Employee</h1>
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
    echo "<p class='error-message'>Employee ID is missing.</p>";
} else {
    $employee_id = $_GET['id'];

    // Fetch employee data from the database
    $sql = "SELECT * FROM employee WHERE employee_id = $employee_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <!-- Form for editing employee -->
        <form id="edit-employee-form" method="post">
            <input type="hidden" name="employee-id" value="<?php echo $row['employee_id']; ?>">
            <label for="employee-first-name">First Name:</label>
            <input type="text" id="employee-first-name" name="employee-first-name" value="<?php echo $row['first_name']; ?>" required>
            <label for="employee-last-name">Last Name:</label>
            <input type="text" id="employee-last-name" name="employee-last-name" value="<?php echo $row['last_name']; ?>" required>
            <label for="employee-email">Email:</label>
            <input type="email" id="employee-email" name="employee-email" value="<?php echo $row['email']; ?>" required>
            <label for="employee-phone-number">Phone Number:</label>
            <input type="text" id="employee-phone-number" name="employee-phone-number" value="<?php echo $row['phone_number']; ?>">
            <label for="employee-address">Address:</label>
            <input type="text" id="employee-address" name="employee-address" value="<?php echo $row['address']; ?>">
            <label for="employee-date-of-birth">Date of Birth:</label>
            <input type="date" id="employee-date-of-birth" name="employee-date-of-birth" value="<?php echo $row['date_of_birth']; ?>">
            <label for="employee-position-id">Position ID:</label>
            <input type="text" id="employee-position-id" name="employee-position-id" value="<?php echo $row['position_id']; ?>">
            <label for="employee-schedule-id">Schedule ID:</label>
            <input type="text" id="employee-schedule-id" name="employee-schedule-id" value="<?php echo $row['schedule_id']; ?>">
            <button type="submit" name="submit">Save</button>
            <a href="employee.php" class="button">Cancel</a>
        </form>
<?php
    } else {
        echo "<p class='error-message'>Employee not found.</p>";
    }
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $employee_id = $_POST['employee-id'];
    $first_name = $_POST['employee-first-name'];
    $last_name = $_POST['employee-last-name'];
    $email = $_POST['employee-email'];
    $phone_number = $_POST['employee-phone-number'];
    $address = $_POST['employee-address'];
    $date_of_birth = $_POST['employee-date-of-birth'];
    $position_id = $_POST['employee-position-id'];
    $schedule_id = $_POST['employee-schedule-id'];

    // Update employee data in the database
    $sql = "UPDATE employee SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            email = '$email', 
            phone_number = '$phone_number', 
            address = '$address', 
            date_of_birth = '$date_of_birth', 
            position_id = '$position_id', 
            schedule_id = '$schedule_id' 
            WHERE employee_id = $employee_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to employee.php after successful update
        header("Location: employee.php");
        exit();
    } else {
        echo "<p class='error-message'>Error updating employee: " . $conn->error . "</p>";
    }
}

// Close database connection
$conn->close();
?>

</body>
</html>
