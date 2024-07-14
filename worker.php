<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Worker Details</h2>

    <?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch worker details
    $sql = "SELECT username, email, phone, AvlComplaints, ComplaintsSolved FROM workers";
    $result = $conn->query($sql);

    // Display data in a table
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Username</th><th>Email</th><th>Phone</th><th>AvlComplaints</th><th>ComplaintsSolved</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["username"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["phone"]."</td>";
            echo "<td>".$row["AvlComplaints"]."</td>";
            echo "<td>".$row["ComplaintsSolved"]."</td>";
            
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No workers found";
    }

    // Close connection
    $conn->close();
    ?>

</body>
</html>
