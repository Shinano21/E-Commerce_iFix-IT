<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>iFixIT - Laptop Repair Form</title>
    <link rel="stylesheet" href="styles.css"/>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
</head>
<body>


<main>
    <div class="container-sm">
        <section id="repair-form">
            <h2>Repair Form</h2>
            <?php
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

            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Prepare data for insertion
                $name = $_POST['name'];
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $phone_number = $_POST['contact'];
                $address = $_POST['address'];
                $brand = $_POST['device_brand'];
                $issue_description = $_POST['issue_description'];
                $gender = $_POST['gender'];

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
                        echo "<script>alert('Submitted successfully');</script>";
                    } else {
                        echo "Error: " . $sql_device . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $sql_customer . "<br>" . $conn->error;
                }
            }
            ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="color: black;">
                <!-- Form elements here -->
                <label for="name">Name:</label><br/>
                <input type="text" id="name" name="name" required/><br/>

                <label for="email">Email (If Optional):</label><br/>
                <input type="email" id="email" name="email"/><br/>

                <label for="contact">Contact Number:</label><br/>
                <input type="text" id="contact" name="contact" required/><br/>

                <label for="address">Address:</label><br/>
                <textarea id="address" name="address" required></textarea><br/>

                <label for="device-brand">Device Brand:</label><br/>
                <input
                        type="text"
                        id="device-brand"
                        name="device_brand"
                        required
                /><br/>

                <label for="issue">Issue of the Device:</label><br/>
                <textarea id="issue" name="issue_description" required></textarea><br/>

                <label for="gender">Gender:</label><br />
<input type="radio" id="male" name="gender" value="Male" required />
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="Female" />
<label for="female">Female</label>
<input type="radio" id="other" name="gender" value="Other" />
<label for="other">Other</label>
<br />

                <button type="submit">Submit</button>
            </form>
        </section>
    </div>
    <a href="main.html">Go back to Home Page</a>
            </form>
        </div>
    </div>
</div>

           
               
</main>
<script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>
