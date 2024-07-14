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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complaintId']) && isset($_POST['username'])) {
    $complaintId = $_POST['complaintId'];
    $username = $_POST['username'];

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Delete the complaint from complaints table
        $completeQuery = "INSERT INTO history (complaintId, place, typeofComplaint, assignedDate, completedDate)
SELECT complaintId, place, typeofComplaint, date, CURDATE()
FROM complaints where complaintId=$complaintId;";
        $stmt = $conn->prepare($completeQuery);
        

        if (!$stmt->execute()) {
            throw new Exception("Error deleting complaint: " . $stmt->error);
        }
        $stmt->close();
        $upquery="UPDATE workers SET AvlComplaints = AvlComplaints - 1 WHERE username = ?";
        $stmt = $conn->prepare($upquery);
        $stmt->bind_param("i", $username);

        if (!$stmt->execute()) {
            throw new Exception("Error updating avlcomplaints: " . $stmt->error);
        }
        $stmt->close();

        // Update the ComplaintsSolved field in workers table
        $updateQuery = "UPDATE workers SET ComplaintsSolved = ComplaintsSolved + 1 WHERE username = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("s", $username);

        if (!$stmt->execute()) {
            throw new Exception("Error updating ComplaintsSolved: " . $stmt->error);
        }
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        echo "Complaint marked as completed successfully.";
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $conn->rollback();
        echo $e->getMessage();
    }
} else {
    echo "Invalid request.";
}

// Close connection
$conn->close();
?>
