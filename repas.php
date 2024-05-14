<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Assignment</title>
    <link rel="stylesheet" href="styles.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />

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
                    <li><a href="Feedash.php">Feedbacks</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="container">
                <h1 class="mt-4 mb-4 text-light">Repair Assignments</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Repair ID</th>
                            <th>Employee Name</th>
                            <th>Device ID</th>
                            <th>Repair Status</th>
                            <th>Repair Date</th>
                            <th>Pickup Date</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Database connection details
                        $servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
                        $username = "root"; // Your MySQL username
                        $password = ""; // Your MySQL password
                        $database = "ifixit"; // Your MySQL database name

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Retrieve repair assignments from the database and display them in rows
                        $sql = "SELECT * FROM RepairAssignment";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["repair_id"] . "</td>";
                                echo "<td>" . $row["emp_first_name"] . " " . $row["emp_last_name"] . "</td>";
                                echo "<td>" . $row["device_id"] . "</td>";
                                echo "<td>" . $row["repair_status"] . "</td>";
                                echo "<td>" . $row["repair_date"] . "</td>";
                                echo "<td>" . $row["pickup_date"] . "</td>";
                                echo "<td>" . $row["notes"] . "</td>";
                                echo "<td>";
                                echo "<div class='btn-group' role='group' aria-label='Operations'>";
                                echo "<a href='ed_rep.php?id=" . $row['repair_id'] . "' class='btn btn-secondary'>Edit</a>";
                                echo "<a href='del_rep.php?id=" . $row['repair_id'] . "' class='btn btn-dark'>Delete</a>";
                                echo "</div>";
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No repair assignments found</td></tr>";
                        }

                        // Close connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="add-button mb-4">
                    <a href="add_reas.php" class="btn btn-light">Add Repair Assignment</a>
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

        <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
</body>
</html>
