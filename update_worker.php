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

// Get parameters from URL
if (isset($_GET['username']) && isset($_GET['complaintId'])) {
    $username = $_GET['username'];
    $complaintID = $_GET['complaintId'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE workers SET complaintID = ?, AvlComplaints = AvlComplaints + 1 WHERE username = ?");

    $stmt->bind_param("is", $complaintID, $username);

    // Execute the query
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Username and ComplaintID are required";
}

// Close connection
$conn->close();
?>
