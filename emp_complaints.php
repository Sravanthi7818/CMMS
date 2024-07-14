<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Form</title>
</head>
<body>
    <?php
    // Define a variable to track whether complaints are displayed
    $complaintsDisplayed = false;

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assuming you have a MySQL database named 'your_database' with a table named 'complaints'
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

        // Get user ID from the form
        $userId = $_POST['userId'];

        // Fetch all fields for the given user ID from the database
        $sql = "SELECT * FROM complaints WHERE userId = '$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Set the variable to true if complaints are displayed
            $complaintsDisplayed = true;

            // Display complaints
            echo "<h3>Complaints for User ID: $userId</h3>";
            while ($row = $result->fetch_assoc()) {
                // Check if the deadline has passed
                $deadlineColor = strtotime($row['deadline']) < strtotime(date('Y-m-d')) ? 'color: red;' : '';

                // Display complaint ID with style attribute
                echo "<p><strong>Complaint ID:</strong> <span style=\"$deadlineColor\">{$row['complaintId']}</span></p>";
                // Display other details as before...
                echo "<p><strong>Complaint ID:</strong> {$row['complaintId']}</p>";
                echo "<p><strong>Place:</strong> {$row['place']}</p>";
                echo "<p><strong>Type of Complaint:</strong> {$row['typeOfComplaint']}</p>";
                echo "<p><strong>Description:</strong> {$row['description']}</p>";
                echo "<p><strong>Date:</strong> {$row['date']}</p>";
                echo "<p><strong>Deadline:</strong> {$row['deadline']}</p>";
                echo "<hr>";
            }
        } else {
            // No complaints found
            echo "<p>No complaints found for User ID: $userId</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>

    <?php
    // Display the form only if complaints are not displayed
    if (!$complaintsDisplayed) {
    ?>
    <h2>Complaints Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="userId">User ID:</label>
        <input type="text" name="userId" required>
        <button type="submit">Submit</button>
    </form>
    <?php
    }
    ?>
</body>
</html>
