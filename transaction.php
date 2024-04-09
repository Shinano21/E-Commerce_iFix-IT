<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Transactions</title>
    <style>
      /* Body styles */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

/* Header styles */
header {
    background-color: #333;
    color: white;
    padding: 10px 20px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Navigation styles */
nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 10px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
}

nav ul li a:hover {
    background-color: #555;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}

/* Action button styles */
.action-buttons {
    display: flex;
    justify-content: space-between;
}

.action-buttons a {
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
}

.edit-button {
    background-color: #4CAF50;
    color: white;
}

.edit-button:hover {
    background-color: #45a049;
}

.delete-button {
    background-color: #f44336;
    color: white;
}

.delete-button:hover {
    background-color: #da190b;
}
/* Button styles */
button {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <header>
    <div class="header-content">
        <h1>Transactions</h1>
        <nav>
            <ul>
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="customer.php">Customers</a></li>
                <li><a href="transaction.php">Transactions</a></li>
                <li><a href="employee.php">Employees</a></li>
                <li><a href="repas.php">Repair Assignment</a></li>
                <li><button id="logout">Logout</button></li>
            </ul>
        </nav>
    </div>
</header>
    <button onclick="location.href='tran_add.php'">Add Transaction</button>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Customer Name</th>
                <th>Date Paid</th>
                <th>Payment Type</th>
                <th>Employee Name</th>
                <th>Total Amount</th>
                <th>Repair Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           <?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "ifixit");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch transactions from the database
$sql = "SELECT * FROM transaction";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['transaction_id']}</td>";
        // Fetch customer name based on customer_id
        $customer_id = $row['customer_id'];
        $customer_sql = "SELECT name FROM Customer WHERE customer_id = '$customer_id'";
        $customer_result = $conn->query($customer_sql);
        if ($customer_result->num_rows > 0) {
            $customer_row = $customer_result->fetch_assoc();
            echo "<td>{$customer_row['name']}</td>";
        } else {
            echo "<td>Unknown Customer</td>";
        }
        echo "<td>{$row['date_paid']}</td>";
        echo "<td>{$row['payment_type']}</td>";
        // Fetch employee name based on employee_id
        $employee_id = $row['employee_id'];
        $employee_sql = "SELECT CONCAT(first_name, ' ', last_name) AS employee_name FROM Employee WHERE employee_id = '$employee_id'";
        $employee_result = $conn->query($employee_sql);
        if ($employee_result->num_rows > 0) {
            $employee_row = $employee_result->fetch_assoc();
            echo "<td>{$employee_row['employee_name']}</td>";
        } else {
            echo "<td>Unknown Employee</td>";
        }
        echo "<td>{$row['total_amount']}</td>";
        echo "<td>{$row['repair_status']}</td>";
        echo "<td class='action-buttons'>";
        echo "<a href='tran_edit.php?id={$row['transaction_id']}' class='edit-button'>Edit</a>";
        echo "<a href='tran_delete.php?id={$row['transaction_id']}' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this transaction?\")'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No transactions found</td></tr>";
}

// Close the database connection
$conn->close();
?>

        </tbody>
    </table>
</body>
</html>
