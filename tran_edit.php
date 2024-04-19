<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="text"] {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[readonly] {
            background-color: #f4f4f4;
            cursor: not-allowed;
        }

        input[readonly]:hover {
            background-color: #f4f4f4;
            cursor: not-allowed;
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
    <h1>Edit Transaction</h1>
    <!-- Form to edit the selected transaction -->
    <?php
    // Retrieve transaction ID from the URL
    if (isset($_GET['id'])) {
        $transaction_id = $_GET['id'];

        // Connect to the database
        $conn = new mysqli("localhost", "root", "", "ifixit");
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch transaction details based on transaction ID
        $sql = "SELECT * FROM Transaction WHERE transaction_id=$transaction_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch transaction data
            $row = $result->fetch_assoc();
            $customer_id = $row['customer_id'];
            $employee_id = $row['employee_id'];
            $date_paid = $row['date_paid'];
            $payment_type = $row['payment_type'];
            $total_amount = $row['total_amount'];
            $repair_status = $row['repair_status'];

            // Fetch customer name
            $customer_name = "";
            $sql_customer = "SELECT name FROM Customer WHERE customer_id=$customer_id";
            $result_customer = $conn->query($sql_customer);
            if ($result_customer->num_rows > 0) {
                $row_customer = $result_customer->fetch_assoc();
                $customer_name = $row_customer['name'];
            }

            // Fetch employee name
            $employee_name = "";
            $sql_employee = "SELECT first_name, last_name FROM Employee WHERE employee_id=$employee_id";
            $result_employee = $conn->query($sql_employee);
            if ($result_employee->num_rows > 0) {
                $row_employee = $result_employee->fetch_assoc();
                $employee_name = $row_employee['first_name'] . " " . $row_employee['last_name'];
            }
        } else {
            echo "Transaction not found";
            exit();
        }

        $conn->close();
    } else {
        echo "Transaction ID not provided";
        exit();
    }
    ?>
    <form action="tran_save.php" method="POST">
        <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
        
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" readonly><br>
        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>"><br>
        
        <label for="date_paid">Date Paid:</label>
        <input type="date" name="date_paid" value="<?php echo $date_paid; ?>"><br>
        
       <label for="payment_type">Payment Type:</label>
<select name="payment_type">
    <option value="Cash" <?php if($payment_type == "Cash") echo "selected"; ?>>Cash</option>
    <option value="Credit" <?php if($payment_type == "Credit") echo "selected"; ?>>Credit</option>
    <option value="Debit" <?php if($payment_type == "Debit") echo "selected"; ?>>Debit</option>
    <option value="E-Cash" <?php if($payment_type == "E-Cash") echo "selected"; ?>>E-Cash</option>
</select><br>

        
        <label for="employee_name">Employee Name:</label>
        <input type="text" name="employee_name" value="<?php echo $employee_name; ?>" readonly><br>
        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>"><br>
        
        <label for="total_amount">Total Amount:</label>
        <input type="text" name="total_amount" value="<?php echo $total_amount; ?>"><br>
        
        <label for="repair_status">Repair Status:</label>
        <select name="repair_status">
            <option value="Pending" <?php if($repair_status == "Pending") echo "selected"; ?>>Pending</option>
            <option value="In Progress" <?php if($repair_status == "In Progress") echo "selected"; ?>>In Progress</option>
            <option value="Completed" <?php if($repair_status == "Completed") echo "selected"; ?>>Completed</option>
        </select><br>
        
        <input type="submit" value="Update">
        <button onclick="location.href='transaction.php'">Go back</button>
    </form>
</body>
</html>
