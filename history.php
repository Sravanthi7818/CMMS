<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Display</title>
</head>
<body>

<h2>Complaints List</h2>

<table border=1>
    <tr>
        <th>Complaint ID</th>
        <th>Place</th>
        <th>Type of Complaint</th>
        
        <th>assigned Date</th>
        <th>Completed Date</th>
    </tr>

    <?php
    // Assuming you have a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the database
    $sql = "SELECT complaintId, place, typeofComplaint, assignedDate,completedDate FROM history";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            //$deadlineColor = strtotime($row['deadline']) < strtotime(date('Y-m-d')) ? 'color: red;' : '';

            echo "<tr>
                    <td>{$row['complaintId']}</td>
                    <td>{$row['place']}</td>
                    <td>{$row['typeofComplaint']}</td>
                    
                    <td>{$row['assignedDate']}</td>
                    <td>{$row['completedDate']}</td>
                    
                  </tr>";
                  //echo "<p><strong>Deadline Exceeded IDs:</strong> <span style=\"$deadlineColor\">{$row['complaintId']}</span></p>";

        }
    } else {
        echo "<tr><td colspan='6'>No complaints found</td></tr>";
    }

    $conn->close();
    ?>

</table>


</body>
</html>
