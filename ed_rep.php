<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Repair Assignment</title>
    <link rel="stylesheet" href="styles.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
</head>
<body>
    <div class="container" style="background-color: rgba(255, 255, 255, 0.5); width:500px; display:flex; justify-content:center;">
        
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
                    echo "<p class='alert alert-danger'>No repair assignment found with ID: " . $repair_id . "</p>";
                    exit;
                }
            } else {
                echo "<p class='alert alert-danger'>No repair assignment ID provided</p>";
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
                echo "<p class='alert alert-danger'>Error updating repair assignment: " . $conn->error . "</p>";
            }
        }

        // Close connection
        $conn->close();
        ?>

         <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2>Edit Repair Assignment</h2>
            <input type="hidden" name="repair_id" value="<?php echo $repair_id; ?>">

            <label for="emp_first_name">Employee First Name:</label>
            <input type="text" name="emp_first_name" value="<?php echo $emp_first_name; ?>" class="form-control">

            <label for="emp_last_name">Employee Last Name:</label>
            <input type="text" name="emp_last_name" value="<?php echo $emp_last_name; ?>" class="form-control">

            <label for="device_id">Device ID:</label>
            <input type="text" name="device_id" value="<?php echo $device_id; ?>" class="form-control">

            <label for="repair_status">Repair Status:</label>
            <select name="repair_status" id="repair_status" class="form-select">
                <option value="In Progress" <?php if ($repair_status == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Completed" <?php if ($repair_status == 'Completed') echo 'selected'; ?>>Completed</option>
                <option value="Pending" <?php if ($repair_status == 'Pending') echo 'selected'; ?>>Pending</option>
            </select>

            <label for="repair_date">Repair Date:</label>
            <input type="date" name="repair_date" value="<?php echo $repair_date; ?>" class="form-control">

            <label for="pickup_date">Pickup Date:</label>
            <input type="date" name="pickup_date" value="<?php echo $pickup_date; ?>" class="form-control">

            <label for="notes">Notes:</label>
            <textarea name="notes" class="form-control"><?php echo $notes; ?></textarea>
<br>
            <button type="submit">Update</button>
        </form>
    </div>
   
 
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
     <div class="text-end">
    <button onclick="location.href='repas.php'" class="btn btn-secondary">Go back</button>
    </div>
</body>
</html>
