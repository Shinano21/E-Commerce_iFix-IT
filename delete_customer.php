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

// Check if customer_id is set in the URL parameter
if(isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Function to display confirmation dialog
    function confirmDelete($customer_id) {
        echo "<script>
        var result = confirm('Are you sure you want to delete this customer?');
        if (result) {
            window.location.href = 'delete_customer.php?id=$customer_id&confirmed=yes';
        } else {
            window.location.href = 'customer.php';
        }
        </script>";
    }

    // Check if confirmation is received
    if(isset($_GET['confirmed']) && $_GET['confirmed'] === 'yes') {
        // Delete associated device records first
        $sql_device = "DELETE FROM device WHERE customer_id=$customer_id";
        if ($conn->query($sql_device) === TRUE) {
            // Delete customer from Customer table
            $sql_customer = "DELETE FROM customer WHERE customer_id=$customer_id";
            if ($conn->query($sql_customer) === TRUE) {
                // Redirect back to customer.php with success message
                $log_message = "Customer and associated device deleted successfully.";
                echo "<script>alert('$log_message');</script>";
                header("Location: customer.php?message=deleted");
                exit();
            } else {
                echo "Error deleting customer record: " . $conn->error;
            }
        } else {
            echo "Error deleting associated device records: " . $conn->error;
        }
    } else {
        // Display confirmation dialog
        confirmDelete($customer_id);
    }
}
?>
