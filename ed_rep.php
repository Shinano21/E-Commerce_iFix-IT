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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve repair assignment details based on ID passed through URL
    if (isset($_GET['id'])) {
        $repair_id = $_GET['id'];
        $sql = "SELECT * FROM RepairAssignment WHERE repair_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $repair_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $emp_first_name = $row['emp_first_name'];
            $emp_last_name = $row['emp_last_name'];
            $device_id = $row['device_id'];
            $repair_status = $row['repair_status'];
            $repair_date = $row['repair_date'];
            $pickup_date = $row['pickup_date'];
            $notes = $row['notes'];
        } else {
            echo "No repair assignment found with ID: " . $repair_id;
            exit;
        }
    } else {
        echo "No repair assignment ID provided";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $repair_id = $_POST['repair_id'];
    $emp_first_name = $_POST['emp_first_name'];
    $emp_last_name = $_POST['emp_last_name'];
    $device_id = $_POST['device_id'];
    $repair_status = $_POST['repair_status']; // Ensure repair_status is properly retrieved
    $repair_date = $_POST['repair_date'];
    $pickup_date = $_POST['pickup_date'];
    $notes = $_POST['notes'];

    // Update repair assignment in the database
    $sql = "UPDATE RepairAssignment SET 
            emp_first_name = ?, 
            emp_last_name = ?, 
            device_id = ?, 
            repair_status = ?, 
            repair_date = ?, 
            pickup_date = ?, 
            notes = ? 
            WHERE repair_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssi", $emp_first_name, $emp_last_name, $device_id, $repair_status, $repair_date, $pickup_date, $notes, $repair_id);
    
    if ($stmt->execute()) {
        // Redirect to main.php
        header("Location: repas.php");
        exit();
    } else {
        echo "Error updating repair assignment: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Repair Assignment</title>
    <style>
        /* Add your CSS styles here */
        /* Example styles */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Repair Assignment</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="repair_id" value="<?php echo $repair_id; ?>">
            
            <label for="emp_first_name">Employee First Name:</label>
            <input type="text" name="emp_first_name" value="<?php echo $emp_first_name; ?>">

            <label for="emp_last_name">Employee Last Name:</label>
            <input type="text" name="emp_last_name" value="<?php echo $emp_last_name; ?>">

            <label for="device_id">Device ID:</label>
            <input type="text" name="device_id" value="<?php echo $device_id; ?>">

            <label for="repair_status">Repair Status:</label>
            <select name="repair_status" id="repair_status">
                <option value="In Progress" <?php if ($repair_status == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Completed" <?php if ($repair_status == 'Completed') echo 'selected'; ?>>Completed</option>
                <option value="Pending" <?php if ($repair_status == 'Pending') echo 'selected'; ?>>Pending</option>
            </select>

            <label for="repair_date">Repair Date:</label>
            <input type="date" name="repair_date" value="<?php echo $repair_date; ?>">

            <label for="pickup_date">Pickup Date:</label>
            <input type="date" name="pickup_date" value="<?php echo $pickup_date; ?>">

            <label for="notes">Notes:</label>
            <textarea name="notes"><?php echo $notes; ?></textarea>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
