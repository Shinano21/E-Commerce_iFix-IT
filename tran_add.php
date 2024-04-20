<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link rel="stylesheet" href="styles.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
   
</head>
<body>
    <div class="container" style="background-color: rgba(255, 255, 255, 0.5); width:500px; display:flex; justify-content:center;">
    
    
    <!-- Form to add a new transaction -->
    <form action="tran_save.php" method="POST">
    <h2 class="text-center mb-4">Add Transaction</h2>
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
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer:</label>
            <select name="customer_id" id="customer_id" class="form-select">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['customer_id'] . "'>" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <?php
        // Fetch employees from the Employee table
        $sql = "SELECT employee_id, first_name, last_name FROM Employee";
        $result = $conn->query($sql);
        ?>
        <div class="mb-3">
            <label for="employee_id" class="form-label">Employee:</label>
            <select name="employee_id" id="employee_id" class="form-select">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['employee_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <?php
        // Close the database connection
        $conn->close();
        ?>

        <div class="mb-3">
            <label for="date_paid" class="form-label">Date Paid:</label>
            <input type="date" name="date_paid" id="date_paid" class="form-control">
        </div>

        <div class="mb-3">
            <label for="payment_type" class="form-label">Payment Type:</label>
            <select name="payment_type" id="payment_type" class="form-select">
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="Online Payment">Online Payment</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount:</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control">
        </div>

        <div class="mb-3">
            <label for="repair_status" class="form-label">Repair Status:</label>
            <select name="repair_status" id="repair_status" class="form-select">
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select>
        </div>

        <input type="submit" value="Submit" class="btn btn-dark">
    </form>
    </div>
    <div class="text-end">
    <button onclick="location.href='transaction.php'" class="btn btn-secondary mt-3">Go back</button>
    </div>
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>

