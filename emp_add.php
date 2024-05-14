<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
</head>
<body>
<!-- Form for adding new employee -->
<div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.5); width:600px;">
   
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
            echo "<p class='alert alert-success'>Employee added successfully!</p>";
        } else {
            echo "<p class='alert alert-danger'>Error: " . $stmt->error . "</p>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h2 class="text-center mb-4">Add New Employee</h2>
        <div class="row">
            <!-- Left Column for Personal Information -->
            <div class="col">
                <div class="mb-3">
                    <label for="first-name" class="form-label">First Name:</label>
                    <input type="text" id="first-name" name="first-name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="last-name" class="form-label">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone-number" class="form-label">Phone Number:</label>
                    <input type="text" id="phone-number" name="phone-number" class="form-control">
                </div>
            </div>
            <!-- Right Column for Address, Date of Birth, Position ID, and Schedule ID -->
            <div class="col">
                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" id="address" name="address" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="date-of-birth" class="form-label">Date of Birth:</label>
                    <input type="date" id="date-of-birth" name="date-of-birth" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="position-id" class="form-label">Position ID:</label>
                    <input type="text" id="position-id" name="position-id" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="schedule-id" class="form-label">Schedule ID:</label>
                    <input type="text" id="schedule-id" name="schedule-id" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" style="background-color: #343a40; color: white;" class="btn">Add Employee</button>
        <button onclick="location.href='employee.php'" class="btn btn-secondary">Go back</button>
    </form>
     
</div>

    


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
