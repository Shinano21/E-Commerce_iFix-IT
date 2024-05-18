<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>iFixIT - Laptop Repair Form</title>
    <link rel="stylesheet" href="styles.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <style>
      body {
    font-family: Arial, sans-serif;
}

#image-section {
    margin-top: 20px;
}

.image-wrapper {
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
}

.image-wrapper h1,
.image-wrapper p {
    margin: 10px 0;
}

.home-link {
    display: block;
    margin-top: 20px;
    width: 200px; /* Adjust the width as needed */
    text-align: center;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
}

.home-link:hover {
    background-color: #0056b3;
}

#repair-form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
    width: 600px;
}

.btn-submit {
    margin-top: 20px;
}

.container .row {
    margin-top: 20px;
}

    </style>
</head>
<body>
<main>
    <div class="container">
        <!-- Image Section -->
        <section id="image-section" class="row">
            <div class="col-md-6 position-relative">
                <img src="customerform.jpg" alt="Image Description" class="img-fluid rounded"/>
                <div class="image-wrapper">
                    <h1>iFixIT</h1>
                    <p>Our computer repair service is dedicated to providing efficient and reliable solutions for all your technical needs. With a team of experienced technicians, we strive to deliver prompt and effective repairs to keep your devices running smoothly. Trust us to restore your technology and get you back to business with minimal downtime.</p>
                 
                </div>
                <div class="image-wrapper">
                    <h1>Additional Info</h1>
                    <p>Our computer repair service is dedicated to providing efficient and reliable solutions for all your technical needs. With a team of experienced technicians, we strive to deliver prompt and effective repairs to keep your devices running smoothly. Trust us to restore your technology and get you back to business with minimal downtime.</p>
                    <a href="main.html" style=" background-color: white; color: black;" class="home-link">Go back to Home Page</a>
                </div>
            </div>
            <div class="col-md-4">
               <section id="repair-form">
    <h2>Repair Form</h2>
    <?php
    $thank_you_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection
        $servername = "localhost";
        $username = "root"; // Your MySQL username
        $password = ""; // this is the default password
        $dbname = "ifixit";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare data for insertion
        // Prepare data for insertion
            $name = $_POST['name'];
            $email = isset($_POST['email']) ? $_POST['email'] : "";
            $phone_number = $_POST['contact'];
            $address = $_POST['address'];
            $brand = $_POST['device_brand'];
            $issue_description = $_POST['issue_description'];
            $gender = $_POST['gender'];
            $appointment_date = $_POST['appointment_date'];
            $appointment_time = $_POST['appointment_time'];
            $employee_id = $_POST['employee']; // Get the selected employee ID

            // Insert data into Customer table
            $sql_customer = "INSERT INTO customer (name, email, phone_number, address, gender, employee_id) 
                            VALUES ('$name', '$email', '$phone_number', '$address', '$gender', '$employee_id')";

        if ($conn->query($sql_customer) === TRUE) {
            // Retrieve the auto-generated customer_id
            $customer_id = $conn->insert_id;

            // Insert data into Device table
            $sql_device = "INSERT INTO device (brand, issue_description, customer_id)
                            VALUES ('$brand', '$issue_description', '$customer_id')";

            if ($conn->query($sql_device) === TRUE) {
                // Insert data into Appointment table
                $sql_appointment = "INSERT INTO appointment (customer_id, customer_name, customer_email, appointment_date, appointment_time, employee_id)
                                    VALUES ('$customer_id', '$name', '$email', '$appointment_date', '$appointment_time', '$employee_id')";

                if ($conn->query($sql_appointment) === TRUE) {
                    $thank_you_message = "Thank you for submitting the form!";
                } else {
                    $thank_you_message = "Error: " . $sql_appointment . "<br>" . $conn->error;
                }
            } else {
                $thank_you_message = "Error: " . $sql_device . "<br>" . $conn->error;
            }
        } else {
            $thank_you_message = "Error: " . $sql_customer . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Form fields -->
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required/>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email (Optional):</label>
                <input type="email" id="email" name="email" class="form-control"/>
            </div>
            <!-- Contact Number -->
            <div class="mb-3">
                <label for="contact" class="form-label">Contact Number:</label>
                <input type="text" id="contact" name="contact" class="form-control" required/>
            </div>
            <!-- Address -->
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
            </div>
            <!-- Device Brand -->
            <div class="mb-3">
                <label for="device-brand" class="form-label">Device Brand:</label>
                <input type="text" id="device-brand" name="device_brand" class="form-control" required/>
            </div>
            <!-- Issue Description -->
            <div class="mb-3">
                <label for="issue" class="form-label">Issue of the Device:</label>
                <textarea id="issue" name="issue_description" class="form-control" required></textarea>
            </div>
            <!-- Gender -->
            <div class="mb-3">
                <label for="gender" class="form-label">Gender:</label>
                <div>
                    <input type="radio" id="male" name="gender" value="Male" required />
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" />
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="Other" />
                    <label for="other">Other</label>
                </div>
            </div>
            <!-- Appointment Date -->
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Drop Off Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" class="form-control" required/>
            </div>
            <!-- Appointment Time -->
            <div class="mb-3">
                <label for="appointment_time" class="form-label">Drop Off Time:</label>
                <input type="time" id="appointment_time" name="appointment_time" class="form-control" required/>
            </div>
            <!-- Select Employee -->
            <div class="mb-3">
                <label for="employee" class="form-label">Select Employee:</label>
              <select id="employee" name="employee" class="form-select" required>
    <option value="">Select an employee</option>
    <?php
    // Fetch employees from the database
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = ""; // this is the default password
    $dbname = "ifixit";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_employees = "SELECT * FROM employee";
    $result_employees = $conn->query($sql_employees);
    if ($result_employees->num_rows > 0) {
        while ($row = $result_employees->fetch_assoc()) {
            // Combine schedule time and days
            $schedule_info = $row["schedule_time"] . " (" . $row["schedule_days"] . ")";
            // Output employee name, schedule, and time as an option
            echo "<option value='" . $row["employee_id"] . "'>" . $row["first_name"] . " " . $row["last_name"] . " - " . $schedule_info . "</option>";
        }
    }
    $conn->close();
    ?>
</select>

                            </div>
                            <button type="submit" style=" background-color: #343a40; color: white;" class="btn btn-primary btn-submit">Submit</button>
                        </form>
                        <p class="mt-3"><?php echo $thank_you_message; ?></p>
                    </div>
                </section>
            </div>
        </section>
    </div>
</main>
<script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>
