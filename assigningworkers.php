\<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Details</title>
</head>
<body>

<?php
// Assuming you have a database connection
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "test1";

$conn = new mysqli($servername, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get complaintId from the URL parameter
$complaintId = isset($_GET['complaintId']) ? $_GET['complaintId'] : null;


// Query to fetch worker details
$sql = "SELECT username, email, phone, AvlComplaints, ComplaintsSolved FROM workers";
$result = $conn->query($sql);

// Fetch worker details based on the complaintId
if ($complaintId) {
    $sql = "SELECT * FROM workers ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>All Workers Details</h2>";
        echo "<table border='1'>";
        echo "<tr>
                
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                
                <th>AvlComplaints</th>
                <th>Complaints Solved</th>
              </tr>";
    
        while ($worker = $result->fetch_assoc()) {
            echo "<tr>
                    
                    <td>{$worker['username']}</td>
                    <td>{$worker['email']}</td>
                    <td>{$worker['phone']}</td>
                    
                    <td>{$worker['AvlComplaints']}</td>
                    <td>{$worker['ComplaintsSolved']}</td>
                    <td><button onclick=\"assignWorkers('{$complaintId}','{$worker['username']}')\">Assign a Worker</button></td>                    
                  </tr>";
        }
    
        echo "</table>";
        
    } else {
        echo "<p>No worker details found.</p>";
    }
} else {
    echo "<p>Invalid or missing Complaint ID in the URL</p>";
}

$conn->close();
?>
<script>
 function assignWorkers(complaintId, username) {
        // You can add your logic for assigning a worker here
        window.location.href = "update_worker.php?complaintId=" + complaintId + "&username=" + username;
    }
    </script>


</body>
</html>
