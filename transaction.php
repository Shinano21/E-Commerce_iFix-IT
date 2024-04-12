<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Transactions</title>
    <link rel="stylesheet" href="styles.css">

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"
</head>
<body>
<header>
      <nav
        class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body"
      >
        <div class="container-fluid">
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="collapse navbar-collapse justify-content-between"
            id="navbarNavAltMarkup"
          >
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
              <a class="nav-link" href="#">About us</a>
            </div>
            <a class="navbar-brand" href="#">iFixIT</a>
            <div class="navbar-nav">
              <a id="logout" class="nav-link" href="#">Logout</a>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div id="sidebar" class="bg-dark">
                <div class="sidebar-header">
                    <h3>Admin</h3>
                </div>
                <ul class="list-unstyled components">
                    <li><a href="admin.html">Dashboard</a></li>
                    <li><a href="customer.php">Customers</a></li>
                    <li><a href="transaction.php">Transactions</a></li>
                    <li><a href="employee.php">Employees</a></li>
                    <li><a href="repas.php">Repair Assignment</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <button class="btn btn-light mb-2" onclick="location.href='tran_add.php'">Add Transaction</button>
            <table class="table">
                <thead class="thead-dark">
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
                            echo '<td>';
echo '<div class="btn-group" role="group" aria-label="Actions">';
echo '<a href="tran_edit.php?id=' . $row['transaction_id'] . '" class="btn btn-secondary">Edit</a>';
echo '<a href="tran_delete.php?id=' . $row['transaction_id'] . '" class="btn btn-dark" onclick="return confirm(\'Are you sure you want to delete this transaction?\')">Delete</a>';
echo '</div>';
echo '</td>';

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
        </div>
    </div>
</div>
<script>
      document.getElementById("logout").addEventListener("click", function () {
        // Redirect to the login page or perform logout actions
        window.location.href = "main.html";
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>
