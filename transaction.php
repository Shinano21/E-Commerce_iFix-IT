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
                <li><a href="transaction.html">Transactions</a></li>
                <li><a href="employee.html">Employees</a></li>
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
        // Add transaction handling here
    }

    // SQL query to retrieve customer IDs
    $sql = "SELECT customer_id FROM Customer";

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output data of each row
        echo "<form id='add-transaction-form' method='post'>";
        echo "<h2>Add New Transaction</h2>";
        echo "<label for='customer-id'>Customer ID:</label>";
        echo "<select id='customer-id' name='customer_id' required>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["customer_id"] . "'>" . $row["customer_id"] . "</option>";
        }
        echo "</select>";
        echo "<label for='date-paid'>Date Paid:</label>";
        echo "<input type='date' id='date-paid' name='date_paid' required />";
        echo "<label for='payment-type'>Payment Type:</label>";
        echo "<select id='payment-type' name='payment_type' required>";
        echo "<option value='Cash'>Cash</option>";
        echo "<option value='Credit Card'>Credit Card</option>";
        echo "<option value='Debit Card'>Debit Card</option>";
        echo "<option value='Online Payment'>Online Payment</option>";
        echo "</select>";
        echo "<label for='employee-id'>Employee ID:</label>";
        echo "<input type='number' id='employee-id' name='employee_id' required />";
        echo "<label for='total-amount'>Total Amount:</label>";
        echo "<input type='number' step='0.01' id='total-amount' name='total_amount' required />";
        echo "<label for='repair-status'>Repair Status:</label>";
        echo "<select id='repair-status' name='repair_status' required>";
        echo "<option value='In Progress'>In Progress</option>";
        echo "<option value='Completed'>Completed</option>";
        echo "<option value='Pending'>Pending</option>";
        echo "</select>";
        echo "<button type='submit'>Add Transaction</button>";
        echo "</form>";
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
</div>
</body>
</html>
