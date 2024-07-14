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
        <th>Description</th>
        <th>Date</th>
        <th>Deadline</th>
        <th>Action</th>
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
    $sql = "SELECT complaintId, place, typeOfComplaint, description, date,deadline FROM complaints";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $deadlineColor = strtotime($row['deadline']) < strtotime(date('Y-m-d')) ? 'color: red;' : '';

            echo "<tr>
                    <td style=\"$deadlineColor\">{$row['complaintId']}</td>
                    <td>{$row['place']}</td>
                    <td>{$row['typeOfComplaint']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['deadline']}</td>
                    <td><button onclick=\"assignWorker({$row['complaintId']})\">Assign a Worker</button></td>
                  </tr>";
                  //echo "<p><strong>Deadline Exceeded IDs:</strong> <span style=\"$deadlineColor\">{$row['complaintId']}</span></p>";

        }
    } else {
        echo "<tr><td colspan='6'>No complaints found</td></tr>";
    }

    $conn->close();
    ?>

</table>

<script>
    function assignWorker(complaintId) {
        // You can add your logic for assigning a worker here
        window.location.href = "assigningworkers.php?complaintId=" + complaintId;
    }
</script>
 
</body>
</html>
