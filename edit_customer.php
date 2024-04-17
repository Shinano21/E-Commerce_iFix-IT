<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $brand = $_POST['brand']; // Add this line to retrieve brand
    $issue_description = $_POST['issue_description']; // Add this line to retrieve issue description

    // Perform validation on the form data as needed

    // Update the customer record in the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ifixit";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to update customer details
    $sql_customer = "UPDATE customer SET name=?, email=?, phone_number=?, address=?, gender=? WHERE customer_id=?";
    $stmt_customer = $conn->prepare($sql_customer);

    // Bind parameters for customer update
    $stmt_customer->bind_param("sssssi", $name, $email, $phone_number, $address, $gender, $customer_id);

    // Execute the customer update statement
    $stmt_customer->execute();

    // Prepare SQL statement to update device details
    $sql_device = "UPDATE device SET brand=?, issue_description=? WHERE customer_id=?";
    $stmt_device = $conn->prepare($sql_device);

    // Bind parameters for device update
    $stmt_device->bind_param("ssi", $brand, $issue_description, $customer_id);

    // Execute the device update statement
    $stmt_device->execute();

    // Check for errors
    if ($stmt_customer->error || $stmt_device->error) {
        echo "Error: " . $stmt_customer->error . $stmt_device->error;
    } else {
        echo "Customer and device updated successfully.";
    }

    // Close statements and connection
    $stmt_customer->close();
    $stmt_device->close();
    $conn->close();
} else {
    // Display the form for editing customer and device details
    // Retrieve the customer ID from the URL parameter
    $customer_id = $_GET['id'];

    // Fetch the customer details from the database based on the ID
    // Perform your SQL query to fetch the details of the customer with the provided ID

    // Fetch the device details from the database based on the ID
    // Perform your SQL query to fetch the device details associated with the customer

    // Display a form with the fetched customer and device details for editing
    // You can use the fetched data to pre-fill the form fields
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Customer</title>
    </head>
    <body>
        <h2>Edit Customer</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <!-- Include input fields for editing customer details -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br><br>

            <!-- Include input fields for other customer details -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br><br>
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>"><br><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>"><br><br>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male" <?php if ($gender == 'Male') echo 'selected="selected"'; ?>>Male</option>
                <option value="Female" <?php if ($gender == 'Female') echo 'selected="selected"'; ?>>Female</option>
                <option value="Other" <?php if ($gender == 'Other') echo 'selected="selected"'; ?>>Other</option>
            </select><br><br>

            <!-- Include input fields for editing device details -->
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" value="<?php echo $brand; ?>"><br><br>
            <label for="issue_description">Issue Description:</label>
            <textarea id="issue_description" name="issue_description"><?php echo $issue_description; ?></textarea><br><br>

            <input type="submit" value="Submit">
        </form>
        <a href="customer.php">Go Back</a> <!-- Go back button -->
    </body>
    </html>
<?php
}
?>
