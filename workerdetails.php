<?php
session_start();

// Assuming the username is stored in a session variable upon login
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$loggedInUsername = $_SESSION['username'];

$servername = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbname = "test1";

// Create connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch worker details
$workerQuery = "SELECT username, email, phone, AvlComplaints, ComplaintsSolved FROM workers WHERE username = ?";
$stmt = $conn->prepare($workerQuery);
$stmt->bind_param("s", $loggedInUsername);
$stmt->execute();
$result = $stmt->get_result();
$worker = $result->fetch_assoc();
$stmt->close();

if ($worker) {
    echo "<h1>Worker Details</h1>";
    echo "<p>Username: " . htmlspecialchars($worker['username']) . "</p>";
    echo "<p>Email: " . htmlspecialchars($worker['email']) . "</p>";
    echo "<p>Phone: " . htmlspecialchars($worker['phone']) . "</p>";
    echo "<p>Available Complaints: " . htmlspecialchars($worker['AvlComplaints']) . "</p>";
    echo "<p>Complaints Solved: " . htmlspecialchars($worker['ComplaintsSolved']) . "</p>";

    // Button to redirect to complaints.php with username in URL
    echo "<form action='complaints.php' method='GET'>
            <input type='hidden' name='username' value='" . htmlspecialchars($worker['username']) . "'>
            <button type='submit'>Show Available Complaints</button>
          </form>";
} else {
    echo "Worker not found.";
}

$conn->close();
?>
