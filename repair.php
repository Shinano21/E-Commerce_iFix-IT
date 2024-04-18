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
    <style>
        /* Adjust form size */
        #repair-form {
            width: 100%; /* Adjust the width as per your requirement */
            height:100%
         
        }
        /* Adjust the size of the image */
        #image-section {
            position: relative; /* Make the container a positioning context for absolute positioning */
         
        }
        #image-section img {
            max-width: 100%; /* Make the image responsive */
            height: 695px; /* Maintain the aspect ratio of the image */
        }
        /* Media query for smaller screens */
@media (max-width: 768px) {
    #image-section img {
        height: auto; /* Reset the height to auto for smaller screens */
    }
}
    
        /* Style for text on top of the image */
        .image-text {
            position: absolute; /* Position the text absolutely within the container */
            top: 50%; /* Position the text vertically centered */
            left: 20%; /* Position the text horizontally centered */
            transform: translate(-50%, -50%); /* Center the text precisely */
            color: white; /* Text color */
            font-size: 15px; /* Font size */
            font-weight:light; /* Font weight */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add a shadow effect to improve readability */
            max-width: 30%;
          
        }
        @media screen and (max-width: 768px) {
            .image-text {
                font-size: 7px; /* Decrease font size for smaller screens */
                max-width: 45%; /* Adjust the width of the text for smaller screens */
                top: 15%; /* Adjust the top position for smaller screens */
                left:30%;
            }
        }
            /* Style for "Go back to Home Page" link */
            .home-link {
            position: absolute;
                top:90%;
                left:53%;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        @media screen and (max-width: 768px) {
            .home-link {
                font-size: 12px; /* Decrease font size for smaller screens */
               
                top: 25%; /* Adjust the top position for smaller screens */
                left:67%;
            }
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

                                    <button  class="btn btn-dark">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </section>
    </div>
    
</main>
<script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB
