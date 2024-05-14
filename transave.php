<?php
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];
    $date_paid = $_POST['date_paid'];
    $payment_type = $_POST['payment_type'];
    $total_amount = $_POST['total_amount'];
    $repair_status = $_POST['repair_status'];

    // Validate data (you may need more comprehensive validation)
    if (empty($customer_id) || empty($employee_id) || empty($date_paid) || empty($payment_type) || empty($total_amount) || empty($repair_status)) {
        echo "Please fill in all fields";
        exit();
    }

    // Perform database operations (insert)
    $conn = new mysqli("localhost", "root", "", "ifixit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new transaction
    $sql = "INSERT INTO Transaction (customer_id, employee_id, date_paid, payment_type, total_amount, repair_status) VALUES ('$customer_id', '$employee_id', '$date_paid', '$payment_type', '$total_amount', '$repair_status')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the main page after successful operation
        header("Location: transaction.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Redirect to the transaction listing page if accessed directly
    header("Location: transaction.php");
    exit();
}
?>