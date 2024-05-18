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
<br><br>
<div class="container" style="background-color: rgba(255, 255, 255, 0.5); width:500px;">
   
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
        $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, email, phone_number, address, date_of_birth, schedule_time, schedule_days) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $phone_number, $address, $date_of_birth, $schedule_time, $schedule_days);

        // Set parameters and execute the statement
        $first_name = $_POST["first-name"];
        $last_name = $_POST["last-name"];
        $email = $_POST["email"];
        $phone_number = $_POST["phone-number"];
        $address = $_POST["address"];
        $date_of_birth = $_POST["date-of-birth"];
        $schedule_time = $_POST["schedule-time"];
        $schedule_days = implode(", ", $_POST["schedule-days"]);

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
        <h2 class="text-center">Add New Employee</h2>
        <div class="row mb-3">
            <div class="col">
                <label for="first-name" class="form-label">First Name:</label>
                <input type="text" id="first-name" name="first-name" class="form-control" required>
            </div>
            <div class="col">
                <label for="last-name" class="form-label">Last Name:</label>
                <input type="text" id="last-name" name="last-name" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="col">
                <label for="phone-number" class="form-label">Phone Number:</label>
                <input type="text" id="phone-number" name="phone-number" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input type="text" id="address" name="address" class="form-control">
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="date-of-birth" class="form-label">Date of Birth:</label>
                <input type="date" id="date-of-birth" name="date-of-birth" class="form-control">
            </div>
            <div class="col">
                <label for="schedule-time" class="form-label">Schedule Time:</label>
                <input type="text" id="schedule-time" name="schedule-time" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Availability:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Monday" id="monday-available" name="schedule-days[]">
                <label class="form-check-label" for="monday-available">Monday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Tuesday" id="tuesday-available" name="schedule-days[]">
                <label class="form-check-label" for="tuesday-available">Tuesday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Wednesday" id="wednesday-available" name="schedule-days[]">
                <label class="form-check-label" for="wednesday-available">Wednesday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Thursday" id="thursday-available" name="schedule-days[]">
                <label class="form-check-label" for="thursday-available">Thursday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Friday" id="friday-available" name="schedule-days[]">
                <label class="form-check-label" for="friday-available">Friday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Saturday" id="saturday-available" name="schedule-days[]">
                <label class="form-check-label" for="saturday-available">Saturday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Sunday" id="sunday-available" name="schedule-days[]">
                <label class="form-check-label" for="sunday-available">Sunday</label>
            </div>
        </div>
        <button type="submit" style=" background-color: #343a40; color: white;">Add Employee</button>
        <div class="text-end">
            <button onclick="location.href='employee.php'" class="btn btn-secondary">Go back</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>