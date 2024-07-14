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

$sql = "SELECT DATE_FORMAT(date, '%Y-%m') AS complaint_month, COUNT(*) AS complaint_count FROM complaints GROUP BY complaint_month ORDER BY complaint_month";
$result = $conn->query($sql);

$months = [];
$counts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $months[] = $row['complaint_month'];
        $counts[] = $row['complaint_count'];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complaints Per Month</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 75%; margin: auto;">
        <canvas id="complaintsChart"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('complaintsChart').getContext('2d');
        var complaintsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Number of Complaints',
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
