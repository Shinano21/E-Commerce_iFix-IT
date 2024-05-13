<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Customer Management</title>
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
                </ul>
            </div>
        </div>
        <div class="col-md-8 mt-4">
            <div id="customer-list">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Address</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Brand</th>
                           
                            <th scope="col">Issue Description</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "ifixit";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT c.customer_id, c.name, c.email, c.phone_number, c.address, c.gender, d.brand, d.model, d.issue_description FROM customer c JOIN device d ON c.customer_id = d.customer_id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['customer_id'] . '</td>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['email'] . '</td>';
                                    echo '<td>' . $row['phone_number'] . '</td>';
                                    echo '<td>' . $row['address'] . '</td>';
                                    echo '<td>' . $row['gender'] . '</td>';
                                    echo '<td>' . $row['brand'] . '</td>';
                                    // echo '<td>' . $row['model'] . '</td>';
                                    echo '<td>' . $row['issue_description'] . '</td>';
                                    echo '<td>';
                                    echo '<div class="btn-group" role="group" aria-label="Operations">';
                                    echo '<a href="edit_customer.php?id=' . $row['customer_id'] . '" class="btn btn-secondary">Edit</a>';
                                    echo '<a href="delete_customer.php?id=' . $row['customer_id'] . '" class="btn btn-dark">Delete</a>';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo "<tr><td colspan='10'>0 results</td></tr>";
                            }
                            $conn->close();
                            ?>
                    </tbody>
                </table>
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