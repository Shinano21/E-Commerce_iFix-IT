<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
</head>
<body>
<div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.5); width:600px;">
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
        echo "<p class='alert alert-danger'>Employee ID is missing.</p>";
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
                <h2 class="text-center mb-4">Edit Employee</h2>
                <input type="hidden" name="employee-id" value="<?php echo $row['employee_id']; ?>">

                <div class="row">
                    <!-- Left Column for Personal Information -->
                    <div class="col">
                        <div class="mb-3">
                            <label for="employee-first-name" class="form-label">First Name:</label>
                            <input type="text" id="employee-first-name" name="employee-first-name" value="<?php echo $row['first_name']; ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee-last-name" class="form-label">Last Name:</label>
                            <input type="text" id="employee-last-name" name="employee-last-name" value="<?php echo $row['last_name']; ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee-email" class="form-label">Email:</label>
                            <input type="email" id="employee-email" name="employee-email" value="<?php echo $row['email']; ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="employee-phone-number" class="form-label">Phone Number:</label>
                            <input type="text" id="employee-phone-number" name="employee-phone-number" value="<?php echo $row['phone_number']; ?>" class="form-control">
                        </div>
                    </div>
                    <!-- Right Column for Address, Date of Birth, Position ID, and Schedule ID -->
                    <div class="col">
                        <div class="mb-3">
                            <label for="employee-address" class="form-label">Address:</label>
                            <input type="text" id="employee-address" name="employee-address" value="<?php echo $row['address']; ?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="employee-date-of-birth" class="form-label">Date of Birth:</label>
                            <input type="date" id="employee-date-of-birth" name="employee-date-of-birth" value="<?php echo $row['date_of_birth']; ?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="employee-position-id" class="form-label">Position ID:</label>
                            <input type="text" id="employee-position-id" name="employee-position-id" value="<?php echo $row['position_id']; ?>" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="employee-schedule-id" class="form-label">Schedule ID:</label>
                            <input type="text" id="employee-schedule-id" name="employee-schedule-id" value="<?php echo $row['schedule_id']; ?>" class="form-control">
                        </div>
                    </div>
                </div>

                    <button type="submit" name="submit" class="btn btn-primary mt-3" style=" background-color: #343a40; color: white;">Save</button>
                    <a href="employee.php" class="btn btn-secondary">Go back</a>
            
            </form>
            
    <?php
        } else {
            echo "<p class='alert alert-danger'>Employee not found.</p>";
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
            echo "<p class='alert alert-danger'>Error updating employee: " . $conn->error . "</p>";
        }
    }

    // Close database connection
    $conn->close();
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
