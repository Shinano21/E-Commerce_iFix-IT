<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Repair Assignment</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <style>
        /* Custom styles for grid layout */
        .form-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: 1fr 1fr;
        }
    </style>
</head>
<body>
    <div class="container" style="background-color: rgba(255, 255, 255, 0.5); width:500px;">
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
                echo "<p class='alert alert-danger'>Error adding repair assignment: " . $conn->error . "</p>";
            }

            // Close prepared statements
            $stmt->close();
            $stmt_employee->close();
        }
        ?>

        <!-- Form for adding repair assignment -->
        <form method="post" class="form-grid mx-auto" style="max-width: 400px;">
            <h2>Add Repair Assignment</h2>

            <!-- Employee select -->
            <div class="mb-3">
                <label for='employee_id' class='form-label'>Employee:</label>
                <select name='employee_id' class='form-select'>
                    <?php
                    // Fetch available employees
                    $sql_employee = "SELECT employee_id, first_name, last_name FROM Employee";
                    $result_employee = $conn->query($sql_employee);

                    if ($result_employee->num_rows > 0) {
                        while ($row_employee = $result_employee->fetch_assoc()) {
                            echo "<option value='" . $row_employee["employee_id"] . "'>" . $row_employee["last_name"] . ", " . $row_employee["first_name"] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No employees available</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Device ID select -->
            <div class="mb-3">
                <label for='device_id' class='form-label'>Device ID:</label>
                <select name='device_id' class='form-select'>
                    <?php
                    // Fetch available device IDs
                    $sql_device = "SELECT device_id FROM Device";
                    $result_device = $conn->query($sql_device);

                    if ($result_device->num_rows > 0) {
                        while ($row_device = $result_device->fetch_assoc()) {
                            echo "<option value='" . $row_device["device_id"] . "'>" . $row_device["device_id"] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No devices available</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Repair Status -->
            <div class="mb-3">
                <label for="repair_status" class="form-label">Repair Status:</label>
                <select name="repair_status" id="repair_status" class="form-select">
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <!-- Repair Date -->
            <div class="mb-3">
                <label for="repair_date" class="form-label">Repair Date:</label>
                <input type="date" name="repair_date" class="form-control">
            </div>

            <!-- Pickup Date -->
            <div class="mb-3">
                <label for="pickup_date" class="form-label">Pickup Date:</label>
                <input type="date" name="pickup_date" class="form-control">
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label for="notes" class="form-label">Notes:</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" name="add" class="btn btn-primary">Add Repair Assignment</button>
            </div>
        </form>
    </div>

    <!-- Go back button -->
    <div class="text-end">
        <button onclick="location.href='repas.php'" class="btn btn-secondary">Go back</button>
    </div>

    <!-- Bootstrap JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>
