<?php
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

// Check if form is submitted
if (isset($_POST['submit'])) {
    $employee_id = $_POST['employee-id'];
    $first_name = $_POST['employee-first-name'];
    $last_name = $_POST['employee-last-name'];
    $email = $_POST['employee-email'];
    $phone_number = $_POST['employee-phone-number'];
    $address = $_POST['employee-address'];
    $date_of_birth = $_POST['employee-date-of-birth'];
    $schedule_time = $_POST['employee-schedule-time'];
    $schedule_days = implode(',', $_POST['schedule-days']); // Convert the array to a string

    // Update employee data in the database
    $sql = "UPDATE employee SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            email = '$email', 
            phone_number = '$phone_number', 
            address = '$address', 
            date_of_birth = '$date_of_birth', 
            schedule_time = '$schedule_time', 
            schedule_days = '$schedule_days' 
            WHERE employee_id = $employee_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to employee.php after successful update
        header("Location: employee.php");
        exit();
    } else {
        echo "<p class='alert alert-danger'>Error updating employee: " . $conn->error . "</p>";
    }
}

// Fetch employee data from the database
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $employee_id = $_GET['id'];
    $sql = "SELECT * FROM employee WHERE employee_id = $employee_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $schedule_days = explode(',', $row['schedule_days']); // Convert the stored string to an array
    } else {
        echo "<p class='alert alert-danger'>Employee not found.</p>";
        exit();
    }
} else {
    echo "<p class='alert alert-danger'>Employee ID is missing.</p>";
    exit();
}

// Close database connection
$conn->close();
?>

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
            <!-- Right Column for Address, Date of Birth, Schedule Time, and Schedule Days -->
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
                    <label for="employee-schedule-time" class="form-label">Schedule Time:</label>
                    <input type="text" id="employee-schedule-time" name="employee-schedule-time" value="<?php echo $row['schedule_time']; ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Availability:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Monday" id="monday-available" name="schedule-days[]" <?php echo in_array('Monday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="monday-available">Monday</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Tuesday" id="tuesday-available" name="schedule-days[]" <?php echo in_array('Tuesday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="tuesday-available">Tuesday</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Wednesday" id="wednesday-available" name="schedule-days[]" <?php echo in_array('Wednesday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="wednesday-available">Wednesday</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Thursday" id="thursday-available" name="schedule-days[]" <?php echo in_array('Thursday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="thursday-available">Thursday</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Friday" id="friday-available" name="schedule-days[]" <?php echo in_array('Friday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="friday-available">Friday</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Saturday" id="saturday-available" name="schedule-days[]" <?php echo in_array('Saturday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="saturday-available">Saturday</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Sunday" id="sunday-available" name="schedule-days[]" <?php echo in_array('Sunday', $schedule_days) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="sunday-available">Sunday</label>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary mt-3" style="background-color: #343a40; color: white;">Save</button>
        <a href="employee.php" class="btn btn-secondary">Go back</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
