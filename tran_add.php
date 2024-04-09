<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Add Transaction</h1>
    <!-- Form to add a new transaction -->
    <form action="tran_save.php" method="POST">
        <!-- Include input fields for transaction details -->
        <?php
        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "ifixit");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch customers from the Customer table
        $sql = "SELECT customer_id, name FROM Customer";
        $result = $conn->query($sql);
        ?>
        <label for="customer_id">Customer:</label>
        <select name="customer_id" id="customer_id">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['customer_id'] . "'>" . $row['name'] . "</option>";
                }
            }
            ?>
        </select><br>
        <?php
        // Fetch employees from the Employee table
        $sql = "SELECT employee_id, first_name, last_name FROM Employee";
        $result = $conn->query($sql);
        ?>
        <label for="employee_id">Employee:</label>
        <select name="employee_id" id="employee_id">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['employee_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                }
            }
            ?>
        </select><br>
        <?php
        // Close the database connection
        $conn->close();
        ?>

        <label for="date_paid">Date Paid:</label>
        <input type="date" name="date_paid" id="date_paid"><br>

        <label for="payment_type">Payment Type:</label>
        <select name="payment_type" id="payment_type">
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="Online Payment">Online Payment</option>
        </select><br>

        <label for="total_amount">Total Amount:</label>
        <input type="text" name="total_amount" id="total_amount"><br>

        <label for="repair_status">Repair Status:</label>
        <select name="repair_status" id="repair_status">
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
            <option value="Pending">Pending</option>
        </select><br>

        <input type="submit" value="Submit">
    </form>
    <button onclick="location.href='transaction.php'">Go back</button>
</body>
</html>
