<?php
// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $transaction_id = $_POST['transaction_id'];
    $date_paid = $_POST['date_paid'];
    $payment_type = $_POST['payment_type'];
    $total_amount = $_POST['total_amount'];
    $repair_status = $_POST['repair_status'];

    // Validate data (you may need more comprehensive validation)
    if (empty($transaction_id) || empty($date_paid) || empty($payment_type) || empty($total_amount) || empty($repair_status)) {
        echo "Please fill in all fields";
        exit();
    }

    // Perform database operations (update)
    $conn = new mysqli("localhost", "root", "", "ifixit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update transaction
    $sql = "UPDATE Transaction SET date_paid='$date_paid', payment_type='$payment_type', total_amount='$total_amount', repair_status='$repair_status' WHERE transaction_id='$transaction_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the main page after successful operation
        header("Location: transaction.php");
        exit();
    } else {
        echo "Error updating transaction: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirect to the transaction listing page if accessed directly
    header("Location: transaction.php");
    exit();
}
?>
