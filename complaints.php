<?php
if (!isset($_GET['username'])) {
    echo "Username is required.";
    exit();
}

$username = $_GET['username'];

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

// Fetch complaintID from workers table for the given username
$workerQuery = "SELECT complaintID FROM workers WHERE username = ?";
$stmt = $conn->prepare($workerQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($complaintID);
$stmt->fetch();
$stmt->close();

if ($complaintID) {
    // Fetch complaints from complaints table using complaintID
    $complaintQuery = "SELECT complaintId, place, typeOfComplaint, date, deadline FROM complaints WHERE complaintId = ?";
    $stmt = $conn->prepare($complaintQuery);
    $stmt->bind_param("i", $complaintID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1>Available Complaints</h1>";
        echo "<table border='1'>
                <tr>
                    <th>Complaint ID</th>
                    <th>Place</th>
                    <th>Type of Complaint</th>
                    <th>Date</th>
                    <th>Deadline</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['complaintId']) . "</td>
                    <td>" . htmlspecialchars($row['place']) . "</td>
                    <td>" . htmlspecialchars($row['typeOfComplaint']) . "</td>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['deadline']) . "</td>
                    <td>
                        <form action='complete_complaint.php' method='POST'>
                            <input type='hidden' name='complaintId' value='" . htmlspecialchars($row['complaintId']) . "'>
                            <input type='hidden' name='username' value='" . htmlspecialchars($username) . "'>
                            <button type='submit'>Completed</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No complaints found for the given complaint ID.";
    }
    $stmt->close();
} else {
    echo "No complaint ID found for the given username.";
}

$conn->close();
?>
