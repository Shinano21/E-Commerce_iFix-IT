<?php
// Retrieve transaction ID from the URL
$transaction_id = $_GET['id'];

// Delete the transaction from the database
$conn = new mysqli("localhost", "root", "", "ifixit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare a delete statement
$sql = "DELETE FROM transaction WHERE transaction_id=$transaction_id";

if ($conn->query($sql) === TRUE) {
    echo "Transaction deleted successfully";
} else {
    echo "Error deleting transaction: " . $conn->error;
}

// Close the database connection
$conn->close();

// Redirect back to the list of transactions
header("Location: list_transactions.php");
exit();
?>
