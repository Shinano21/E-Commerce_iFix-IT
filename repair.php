<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>iFixIT - Laptop Repair Form</title>
    <style>
        /* Adjust the size of the image */
        #image-section img {
            max-width: 100%;
            height: auto;
        }

        /* Style for text on top of the image */
        .image-text {
            color: white;
            font-size: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            max-width: 30%;
            margin-left: 20%;
        }

        /* Style for "Go back to Home Page" link */
        .home-link {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        /* Style for form button */
        .btn-submit {
            margin-top: 20px;
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Style for the employee table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<main>
    <div class="container-fluid">
        <!-- Image Section -->
        <section id="image-section" class="row">
            <div class="col-md-8">
                <img src="customerform.jpg" alt="Image Description" class="img-fluid" />
                <div class="image-text">
                    <h1>iFixIT</h1>
                    Our computer repair service is dedicated to providing efficient and reliable solutions for all your technical needs. With a team of experienced technicians, we strive to deliver prompt and effective repairs to keep your devices running smoothly. Trust us to restore your technology and get you back to business with minimal downtime.
                </div>
                <a href="main.html" class="home-link">Go back to Home Page</a>
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
                        $sql_customer = "INSERT INTO Customer (name, email, phone_number, address, gender) 
                                        VALUES ('$name', '$email', '$phone_number', '$address', '$gender')";

                        if ($conn->query($sql_customer) === TRUE) {
                            // Retrieve the auto-generated customer_id
                            $customer_id = $conn->insert_id;

                            // Insert data into Device table
                            $sql_device = "INSERT INTO Device (brand, issue_description, customer_id)
                                            VALUES ('$brand', '$issue_description', '$customer_id')";

                            if ($conn->query($sql_device) === TRUE) {
                                // Insert data into Appointment table
                                $sql_appointment = "INSERT INTO appointment (customer_id, customer_name, customer_email, appointment_date, appointment_time, employee_id)
                                                    VALUES ('$customer_id', '$name', '$email', '$appointment_date', '$appointment_time', '$employee_id')";

                                if ($conn->query($sql_appointment) === TRUE) {
                                    $thank_you_message = "Thank you for submitting the form!";
                                    // Redirect to a thank you page or any other page
                                    // header("Location: thank_you.php");
                                    // exit(); // Stop executing the script
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
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="color: black;">
                                    <!-- Form elements here -->
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" required/>

                                    <label for="email">Email (If Optional):</label>
                                    <input type="email" id="email" name="email"/>

                                    <label for="contact">Contact Number:</label>
                                    <input type="text" id="contact" name="contact" required/>

                                    <label for="address">Address:</label>
                                    <textarea id="address" name="address" required></textarea>

                                    <label for="device-brand">Device Brand:</label>
                                    <input type="text" id="device-brand" name="device_brand" required/>

                                    <label for="issue">Issue of the Device:</label>
                                    <textarea id="issue" name="issue_description" required></textarea>

                                    <label for="gender">Gender:</label>
                                    <input type="radio" id="male" name="gender" value="Male" required />
                                    <label for="male">Male</label>
                                    <input type="radio" id="female" name="gender" value="Female" />
                                    <label for="female">Female</label>
                                    <input type="radio" id="other" name="gender" value="Other" />
                                    <label for="other">Other</label>

                                    <!-- Appointment information -->
                                    <label for="appointment_date">Drop Off Date:</label>
                                    <input type="date" id="appointment_date" name="appointment_date" required/>

                                    <label for="appointment_time">Drop Off Time:</label>
                                    <input type="time" id="appointment_time" name="appointment_time" required/>

                                    <!-- Employee list -->
                                    <label for="employee">Select Employee:</label>
                                    <select id="employee" name="employee" required>
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
                                        ?>
                                    </select>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn-submit">Submit</button>
                                </form>
                                <p><?php echo $thank_you_message; ?></p>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </section>
    </div>
</main>
</body>
</html>
