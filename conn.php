<?php 

$username = "root";
$password = "";
$database = "test1";

try {
  $pdo = new PDO("mysql:host=localhost;database=$database", $username, $password);
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
  die("ERROR: Could not connect. " . $e->getMessage());
}

?>

<html>
    <head>
        <title>chartjs</title>
        <style>
            .chartBox{
                width:700px;
            }
        </style>

</head>
<body>
<?php 
// Attempt select query execution
try{
  $sql = "SELECT * FROM test1.complaints";   
  $result = $pdo->query($sql);
  if($result->rowCount() > 0) {
    $complaintId=array();

    while($row = $result->fetch()) {
        $complaintId[] = $row["complaintId"];
    }

  unset($result);
  } else {
    echo "No records matching your query were found.";
  }
} catch(PDOException $e){
  die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
 
// Close connection
unset($pdo);
?>


<div class="chartBox">
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    //setup block
    
    const complaintId = <?php echo json_encode($complaintId); ?>;
    const data={
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
      datasets: [{
        label: '# of Votes',
        data: complaintId,
        borderWidth: 1
      }]
    }
    //config block
    const config={
       
    type: 'bar',
    data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  };
  //render block

  const myChart=new Chart(
    document.getElementById('myChart'),
    config
  );

    
</script>


</body>
</html>
