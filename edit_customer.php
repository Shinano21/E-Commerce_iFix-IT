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
    // Retrieve data from the form
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $phone_number = $_POST['contact'];
    $address = $_POST['address'];
    $brand = $_POST['device_brand'];
    $issue_description = $_POST['issue_description'];
    $gender = $_POST['gender'];

    // Update Customer table
    $sql_customer = "UPDATE customer SET name='$name', email='$email', phone_number='$phone_number', address='$address', gender='$gender' WHERE customer_id=$customer_id";

    if ($conn->query($sql_customer) === TRUE) {
        // Update Device table if necessary
        $sql_device = "UPDATE device SET brand='$brand', issue_description='$issue_description' WHERE customer_id=$customer_id";
        $conn->query($sql_device); // Assuming there's only one device per customer

        // Display success message
        $log_message = "Customer details updated successfully.";
        echo "<script>alert('$log_message');</script>";
        header("Location: customer.php?message=updated");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Retrieve customer ID from URL parameter
if(isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    // Fetch customer data from database
    $sql = "SELECT * FROM customer WHERE customer_id=$customer_id";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error executing query: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
        
        // Fetch device data associated with the customer
        $sql_device = "SELECT * FROM device WHERE customer_id=$customer_id";
        $result_device = $conn->query($sql_device);
        if ($result_device === false) {
            echo "Error executing device query: " . $conn->error;
        } elseif ($result_device->num_rows > 0) {
            $device = $result_device->fetch_assoc();
        }
    } else {
        echo "Customer not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>iFixIT - Edit Customer</title>
    <link rel="stylesheet" href="styles.css"/>
<<<<<<< OtherBranch
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
</head>
<body>
<header>
    <div class="header-content text-white">
        
=======
</head>
<body>
<header>
    <div class="header-content">
        <h1>iFixIT - Edit Customer</h1>
>>>>>>> main
        <!-- Navigation links -->
    </div>
</header>
<main>
<<<<<<< OtherBranch
    <div class="container" style="background-color: rgba(255, 255, 255, 0.5); width:500px; display:flex; justify-content:center;">
        <section id="edit-customer-form">
            <?php if(isset($_GET['message']) && $_GET['message'] === 'updated'): ?>
            <p class="alert alert-success">Customer details updated successfully.</p>
            <?php endif; ?>

            <h2 class="text-black">Edit Customer</h2>
            <?php if(isset($customer) && $customer !== null): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
                <div class="mb-3">
                    <label for="name" class="form-label text-black">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($customer['name']) ? $customer['name'] : ''; ?>" class="form-control" style="width: 300px; required/>
                </div>

                <!-- Other form fields -->
                <div class="mb-3">
                    <label for="email" class="form-label text-black">Email (If Optional):</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($customer['email']) ? $customer['email'] : ''; ?>" class="form-control" style="width: 300px;"/>
                </div>

                <div class="mb-3">
                    <label for="contact" class="form-label text-black">Contact Number:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo isset($customer['phone_number']) ? $customer['phone_number'] : ''; ?>" class="form-control" style="width: 300px;" required/>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label text-black">Address:</label>
                    <textarea id="address" name="address" class="form-control" style="width: 300px;" required><?php echo isset($customer['address']) ? $customer['address'] : ''; ?></textarea>
                </div>

                <!-- Device form fields -->
                <div class="mb-3">
                    <label for="device-brand" class="form-label text-black">Device Brand:</label>
                    <input type="text" id="device-brand" name="device_brand" value="<?php echo isset($device['brand']) ? $device['brand'] : ''; ?>" class="form-control" style="width: 300px;" required/>
                </div>

                <div class="mb-3">
                    <label for="issue" class="form-label text-black">Issue of the Device:</label>
                    <textarea id="issue" name="issue_description" class="form-control" style="width: 300px;" required><?php echo isset($device['issue_description']) ? $device['issue_description'] : ''; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label text-black">Gender:</label><br />
                    <input type="radio" id="male" name="gender" value="Male" <?php if(isset($customer['gender']) && $customer['gender'] === "Male") echo "checked"; ?> class="form-check-input" required />
                    <label for="male" class="form-check-label text-black">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" <?php if(isset($customer['gender']) && $customer['gender'] === "Female") echo "checked"; ?> class="form-check-input" />
                    <label for="female" class="form-check-label text-black">Female</label>
                    <input type="radio" id="other" name="gender" value="Other" <?php if(isset($customer['gender']) && $customer['gender'] === "Other") echo "checked"; ?> class="form-check-input" />
                    <label for="other" class="form-check-label text-black">Other</label>
                </div>

                <button type="submit" style=" background-color: #343a40; color: white;">Update</button>
=======
    <div class="container">
        <section id="edit-customer-form">
            <?php if(isset($_GET['message']) && $_GET['message'] === 'updated'): ?>
            <p class="success-message">Customer details updated successfully.</p>
            <?php endif; ?>

            <h2>Edit Customer</h2>
            <?php if(isset($customer) && $customer !== null): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
                <label for="name">Name:</label><br/>
                <input type="text" id="name" name="name" value="<?php echo isset($customer['name']) ? $customer['name'] : ''; ?>" required/><br/>

                <!-- Other form fields -->
                <label for="email">Email (If Optional):</label><br/>
                <input type="email" id="email" name="email" value="<?php echo isset($customer['email']) ? $customer['email'] : ''; ?>"/><br/>

                <label for="contact">Contact Number:</label><br/>
                <input type="text" id="contact" name="contact" value="<?php echo isset($customer['phone_number']) ? $customer['phone_number'] : ''; ?>" required/><br/>

                <label for="address">Address:</label><br/>
                <textarea id="address" name="address" required><?php echo isset($customer['address']) ? $customer['address'] : ''; ?></textarea><br/>

                <!-- Device form fields -->
                <label for="device-brand">Device Brand:</label><br/>
                <input type="text" id="device-brand" name="device_brand" value="<?php echo isset($device['brand']) ? $device['brand'] : ''; ?>" required/><br/>

                <label for="issue">Issue of the Device:</label><br/>
                <textarea id="issue" name="issue_description" required><?php echo isset($device['issue_description']) ? $device['issue_description'] : ''; ?></textarea><br/>

                <label for="gender">Gender:</label><br />
                <input type="radio" id="male" name="gender" value="Male" <?php if(isset($customer['gender']) && $customer['gender'] === "Male") echo "checked"; ?> required />
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="Female" <?php if(isset($customer['gender']) && $customer['gender'] === "Female") echo "checked"; ?> />
                <label for="female">Female</label>
                <input type="radio" id="other" name="gender" value="Other" <?php if(isset($customer['gender']) && $customer['gender'] === "Other") echo "checked"; ?> />
                <label for="other">Other</label>
                <br />

                <button type="submit">Update</button>
>>>>>>> main
            </form>
            <?php else: ?>
            <p>Customer not found.</p>
            <?php endif; ?>
        </section>
    </div>
<<<<<<< OtherBranch
    <div class="text-end">
    <a href="customer.php" class="btn btn-secondary">Go back to Customer Page</a>
    </div>
    
</main>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
=======
    <a href="customer.php">Go back to Customer Page</a>
</main>
>>>>>>> main
</body>
</html>
