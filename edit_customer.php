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
</head>
<body>
<header>
    <div class="header-content">
        <h1>iFixIT - Edit Customer</h1>
        <!-- Navigation links -->
    </div>
</header>
<main>
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
            </form>
            <?php else: ?>
            <p>Customer not found.</p>
            <?php endif; ?>
        </section>
    </div>
    <a href="customer.php">Go back to Customer Page</a>
</main>
</body>
</html>
