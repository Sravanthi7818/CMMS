<?php
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

// SQL query to get the count of each type of complaint
$sql = "SELECT typeOfComplaint, COUNT(typeOfComplaint) as complaintCount FROM complaints GROUP BY typeOfComplaint";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

// Return the data in JSON format
header('Content-Type: application/json');
echo json_encode($data);
?>
