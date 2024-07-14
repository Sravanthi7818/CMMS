<?php
// process_form.php

// Replace these variables with your actual database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'test1';

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $complaintId = $_POST["complaintId"];
    $place = $_POST["place"];
    $typeOfComplaint = $_POST["typeOfComplaint"];
    $description = $_POST["description"];
    $date = $_POST["date"];
  
    
    $deadline = $_POST["deadline"];
  

    // Insert data into the database (adjust the table name as needed)
    $sql = "INSERT INTO complaints(complaintId, place, typeOfComplaint, description, date, deadline)
     VALUES ('$complaintId', '$place', '$typeOfComplaint', '$description', '$date',  '$deadline')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
