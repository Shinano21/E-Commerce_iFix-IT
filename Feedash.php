<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
</head>
<style>
    .btn.btn-primary {
        background-color: grey;
        color: white;
        border-color: white;
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
            <!-- Table for displaying feedback data -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-light">Feedback List</h2>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Feedback</th>
                                <th>Rating</th>
                                <th>Date</th>
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

                            // Fetch feedback data from the database
                            $sql = "SELECT * FROM feedback";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td>".$row['feedback_text']."</td>";
                                    echo "<td>".$row['rating']."</td>";
                                    echo "<td>".$row['created_at']."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No feedback found</td></tr>";
                            }

                            // Close database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
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