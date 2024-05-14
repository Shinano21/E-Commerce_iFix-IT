<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Repair Assignment</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
</head>
<body>
    <div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.5); width:600px;">
        
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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2>Edit Repair Assignment</h2>
            <input type="hidden" name="repair_id" value="<?php echo $repair_id; ?>">
            
            <div class="row">
                <!-- Left Column for Employee First Name, Employee Last Name, and Device ID -->
                <div class="col">
                    <div class="mb-3">
                        <label for="emp_first_name" class="form-label">Employee First Name:</label>
                        <input type="text" name="emp_first_name" value="<?php echo $emp_first_name; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="emp_last_name" class="form-label">Employee Last Name:</label>
                        <input type="text" name="emp_last_name" value="<?php echo $emp_last_name; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="device_id" class="form-label">Device ID:</label>
                        <input type="text" name="device_id" value="<?php echo $device_id; ?>" class="form-control">
                    </div>
                </div>
                <!-- Right Column for Repair Status, Repair Date, and Pickup Date -->
                <div class="col">
                    <div class="mb-3">
                        <label for="repair_status" class="form-label">Repair Status:</label>
                        <select name="repair_status" id="repair_status" class="form-select">
                            <option value="In Progress" <?php if ($repair_status == 'In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Completed" <?php if ($repair_status == 'Completed') echo 'selected'; ?>>Completed</option>
                            <option value="Pending" <?php if ($repair_status == 'Pending') echo 'selected'; ?>>Pending</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="repair_date" class="form-label">Repair Date:</label>
                        <input type="date" name="repair_date" value="<?php echo $repair_date; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="pickup_date" class="form-label">Pickup Date:</label>
                        <input type="date" name="pickup_date" value="<?php echo $pickup_date; ?>" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="mb-3">
                <label for="notes" class="form-label">Notes:</label>
                <textarea name="notes" class="form-control"><?php echo $notes; ?></textarea>
            </div>

            <button type="submit" style="background-color: #343a40; color: white;" class="btn">Update</button>
            <button onclick="location.href='repas.php'" class="btn btn-secondary">Go back</button>
        </form>

    </div>
    
        
    
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
