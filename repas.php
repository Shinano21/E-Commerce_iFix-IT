<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Assignment</title>
    <style>
     /* Reset default browser styles */
body, h1, h2, h3, h4, h5, h6, p, ul, ol, li, form, fieldset, legend, input, textarea, button, table, td, th {
    margin: 0;
    padding: 0;
    border: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 8px;
    border: 1px solid #ddd;
}

table th {
    background-color: #f2f2f2;
}

table td {
    background-color: #fff;
}

.actions {
    text-align: center;
    margin-top: 20px;
}

.actions a {
    display: inline-block;
    padding: 8px 16px;
    margin-right: 10px;
    text-decoration: none;
    color: #333;
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.actions a:hover {
    background-color: #e2e2e2;
}

    </style>
</head>
<body>
    <h1>Repair Assignments</h1>
    <table>
        <thead>
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
                    echo "<a href='ed_rep.php?id=" . $row["repair_id"] . "'>Edit</a>";
                    echo "<a href='del_rep.php?id=" . $row["repair_id"] . "'>Delete</a>";
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
    <div class="add-button">
            <a href="add_reas.php">Add Repair Assignment</a>
        </div>
</body>
</html>
