<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container {
            background-color: rgba(255, 255, 255, 0.5);
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <div class="container">
        <!-- Form to add a new transaction -->
        <form action="transave.php" method="POST">
            <h2 class="text-center mb-4">Add Transaction</h2>
            <div class="mb-3">
                <label for="customer_id" class="form-label">Customer:</label>
                <select name="customer_id" id="customer_id" class="form-select">
                    <?php
                    // PHP code to fetch customers from the database
                    $conn = new mysqli("localhost", "root", "", "ifixit");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT customer_id, name FROM Customer";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['customer_id'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee:</label>
                <select name="employee_id" id="employee_id" class="form-select">
                    <?php
                    // PHP code to fetch employees from the database
                    $conn = new mysqli("localhost", "root", "", "ifixit");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT employee_id, first_name, last_name FROM Employee";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['employee_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
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
            <button type="submit" style=" background-color: #343a40; color: white;">Submit</button>
            <button type="button" onclick="location.href='transaction.php'" class="btn btn-secondary">Go back</button>
        </form>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>