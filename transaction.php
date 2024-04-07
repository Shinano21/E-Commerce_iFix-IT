<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management</title>
</head>
<body>
<header>
    <div class="header-content">
        <h1>Transaction Management</h1>
        <nav>
            <ul>
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="customer.php">Customers</a></li>
                <li><a href="transaction.php">Transactions</a></li>
                <li><a href="employee.php">Employees</a></li>
                <li><button id="logout">Logout</button></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Placeholder for displaying transaction data -->
<div id="transaction-list">
    <?php
    // Database connection parameters
    $servername = "localhost"; // Change this if your MySQL server is running on a different host
    $username = "root"; // Change this if your MySQL username is different
    $password = ""; // Change this if your MySQL password is different
    $database = "ifixit"; // Change this to your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Add Transaction
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['customer_id']) && isset($_POST['date_paid']) && isset($_POST['payment_type']) && isset($_POST['employee_id']) && isset($_POST['total_amount']) && isset($_POST['repair_status'])){
            $customer_id = $_POST['customer_id'];
            $date_paid = $_POST['date_paid'];
            $payment_type = $_POST['payment_type'];
            $employee_id = $_POST['employee_id'];
            $total_amount = $_POST['total_amount'];
            $repair_status = $_POST['repair_status'];
            
            $sql = "INSERT INTO Transaction (customer_id, date_paid, payment_type, employee_id, total_amount, repair_status) VALUES ('$customer_id', '$date_paid', '$payment_type', '$employee_id', '$total_amount', '$repair_status')";
            if ($conn->query($sql) === TRUE) {
                // Generate receipt
                echo "<div class='receipt'>";
                echo "<h2>Transaction Receipt</h2>";
                echo "<p><strong>Customer ID:</strong> $customer_id</p>";
                echo "<p><strong>Date Paid:</strong> $date_paid</p>";
                echo "<p><strong>Payment Type:</strong> $payment_type</p>";
                echo "<p><strong>Employee ID:</strong> $employee_id</p>";
                echo "<p><strong>Total Amount:</strong> $total_amount</p>";
                echo "<p><strong>Repair Status:</strong> $repair_status</p>";
                echo "</div>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Delete Transaction
        if(isset($_POST['delete-transaction-id'])){
            $transaction_id = $_POST['delete-transaction-id'];
            $sql = "DELETE FROM Transaction WHERE transaction_id=$transaction_id";
            if ($conn->query($sql) === TRUE) {
                echo "Transaction deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    }

    // SQL query to retrieve transaction data
    $sql = "SELECT * FROM Transaction";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<div id='transaction-" . $row["transaction_id"] . "'>";
            echo "<p>";
            echo "Transaction ID: " . $row["transaction_id"] . "<br>";
            echo "Customer ID: " . $row["customer_id"] . "<br>";
            echo "Date Paid: " . $row["date_paid"] . "<br>";
            echo "Payment Type: " . $row["payment_type"] . "<br>";
            echo "Employee ID: " . $row["employee_id"] . "<br>";
            echo "Total Amount: " . $row["total_amount"] . "<br>";
            echo "Repair Status: " . $row["repair_status"] . "<br>";
            echo "<form method='post' style='display:inline;'><input type='hidden' name='delete-transaction-id' value='" . $row["transaction_id"] . "'><button type='submit'>Delete</button></form>";
            echo "</p>";
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
</div>
<!-- Form for adding new transactions -->
<form id="add-transaction-form" method="post">
    <h2>Add New Transaction</h2>
    <label for="customer-id">Customer ID:</label>
    <input type="number" id="customer-id" name="customer_id" required />
    <label for="date-paid">Date Paid:</label>
    <input type="date" id="date-paid" name="date_paid" required />
    <label for="payment-type">Payment Type:</label>
    <select id="payment-type" name="payment_type" required>
        <option value="Cash">Cash</option>
        <option value="Credit Card">Credit Card</option>
        <option value="Debit Card">Debit Card</option>
        <option value="Online Payment">Online Payment</option>
    </select>
    <label for="employee-id">Employee ID:</label>
    <input type="number" id="employee-id" name="employee_id" required />
    <label for="total-amount">Total Amount:</label>
    <input type="number" step="0.01" id="total-amount" name="total_amount" required />
    <label for="repair-status">Repair Status:</label>
    <select id="repair-status" name="repair_status" required>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
        <option value="Pending">Pending</option>
    </select>
    <button type="submit">Add Transaction</button>
</form>
</body>
</html>
