<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
</head>
<style>
    .btn.btn-primary {
    background-color: grey;
    color: white; /* Adjust text color if needed */
    border-color: white; /* Optionally, if you want to remove border color */
}

</style>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
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

<div class="container-fluid ">
    <div class="row">
        <!-- Sidebar -->
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
                    <li><a href="Feedash.php">Feedbacks</a></li>
                </ul>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-8 mt-4">
            <!-- Search bar for filtering employees by first name and last name -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="d-flex">
                        <label for="search" class="me-2 text-light">Search by Name:</label>
                        <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="form-control me-2" placeholder="Enter first name or last name">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <!-- Table for displaying employee data -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-light">Employee List</h2>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Employee ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Date of Birth</th>
                                <th>Schedule Time</th>
                                <th>Schedule Days</th>
                        
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Connect to the database
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "ifixit";

                            $conn = new mysqli($servername, $username, $password, $database);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch and display filtered employee data in table rows
                            $sql = "SELECT * FROM employee";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = $_GET['search'];
                                $sql .= " WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%'";
                            }
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['employee_id']."</td>";
                                    echo "<td>".$row['first_name']."</td>";
                                    echo "<td>".$row['last_name']."</td>";
                                    echo "<td>".$row['email']."</td>";
                                    echo "<td>".$row['phone_number']."</td>";
                                    echo "<td>".$row['address']."</td>";
                                    echo "<td>".$row['date_of_birth']."</td>";
                                    echo "<td>".$row['schedule_time']."</td>";
                                    echo "<td>".$row['schedule_days']."</td>";
                                    
                                    echo "<td>";
                                    echo "<div class='btn-group' role='group' aria-label='Operations'>";
                                    echo "<a href='emp_edit.php?id=" . $row['employee_id'] . "' class='btn btn-secondary'>Edit</a>";
                                    echo "<a href='delete_employee.php?id=" . $row['employee_id'] . "' class='btn btn-dark'>Delete</a>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11'>No employees found</td></tr>";
                            }

                            // Close database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Button to add new employee -->
            <div class="row">
                <div class="col-md-12">
                    <div id="add-employee-button">
                        <a href="emp_add.php" class="btn btn-light">Add Employee</a>
                    </div>
                </div>
            </div>
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