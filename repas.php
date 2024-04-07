<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "ifixit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from employee table
$sql_employee = "SELECT * FROM employee";
$result_employee = $conn->query($sql_employee);

// Fetch data from device table
$sql_device = "SELECT * FROM device";
$result_device = $conn->query($sql_device);

// Function to sanitize and validate input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $employee_id = sanitize_input($_POST['employee_id']);
    $device_id = sanitize_input($_POST['device_id']);
    $repair_status = sanitize_input($_POST['repair_status']);
    $repair_date = sanitize_input($_POST['repair_date']);
    $pickup_date = sanitize_input($_POST['pickup_date']);

    // Insert data into repairassignment table
    $sql_insert = "INSERT INTO repairassignment (employee_id, device_id, repair_status, repair_date, pickup_date) 
                   VALUES ('$employee_id', '$device_id', '$repair_status', '$repair_date', '$pickup_date')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<p>Data submitted successfully</p>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Assignment Form</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

h2 {
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-top: 10px;
}

select,
input[type="date"],
button {
    margin-top: 5px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

select {
    width: 100%;
}

button {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <h2>Repair Assignment Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="employee_id">Employee:</label><br>
        <select id="employee_id" name="employee_id" required>
            <option value="">Select Employee</option>
            <?php
            if ($result_employee->num_rows > 0) {
                while($row_employee = $result_employee->fetch_assoc()) {
                    echo "<option value='".$row_employee['employee_id']."'>".$row_employee['employee_name']."</option>";
                }
            }
            ?>
        </select><br>

        <label for="device_id">Device:</label><br>
        <select id="device_id" name="device_id" required>
            <option value="">Select Device</option>
            <?php
            if ($result_device->num_rows > 0) {
                while($row_device = $result_device->fetch_assoc()) {
                    echo "<option value='".$row_device['device_id']."'>".$row_device['device_name']."</option>";
                }
            }
            ?>
        </select><br>

        <label for="repair_status">Repair Status:</label><br>
        <select id="repair_status" name="repair_status" required>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
            <option value="Pending">Pending</option>
        </select><br>

        <label for="repair_date">Repair Date:</label><br>
        <input type="date" id="repair_date" name="repair_date" required><br>

        <label for="pickup_date">Pickup Date:</label><br>
        <input type="date" id="pickup_date" name="pickup_date" required><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
