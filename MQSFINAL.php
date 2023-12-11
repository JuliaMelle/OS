<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/MQStry.css" />
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <title>Scheduling Simulation</title>
    
</head>

<body style="background-color: black;">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">OS GROUP 8</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="Priority_NP.php">Prio (NP)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="MQSFINAL.php">MQS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="SCAN.php">SCAN</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container">
            <h2>MQS Scheduling Simulation</h2>
        <div class="mb-3">
            <form method="post" action="">
                <label for="arrival_time">Arrival Time:</label>
                <input type="text" name="arrival_time" class="form-control" required>
        </div>

        <div class="mb-3">
                <label for="burst_time">Burst Time:</label>
                <input type="text" name="burst_time" class="form-control" required>
        </div>

        <div class="mb-3">
                <label for="queue">Queue:</label>
                <input type="text" name="queue" class="form-control" required>
        </div>
                <br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
</br></br>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $arrivalTimes = isset($_POST['arrival_time']) ? explode(' ', trim($_POST['arrival_time'])) : [];
        $burstTimes = isset($_POST['burst_time']) ? explode(' ', trim($_POST['burst_time'])) : [];
        $queues = isset($_POST['queue']) ? explode(' ', trim($_POST['queue'])) : [];


        // FCFS Scheduling Algorithm
        $n = count($arrivalTimes);


        $waitingTimes = array_fill(0, $n, 0);
        $turnaroundTimes = array_fill(0, $n, 0);


        $completionTime = 0;


        for ($i = 0; $i < $n; $i++) {
            // If the process has not arrived yet, wait
            if ($completionTime < $arrivalTimes[$i]) {
                $completionTime = $arrivalTimes[$i];
            }


            // Calculate waiting time for the current process
            $waitingTimes[$i] = $completionTime - $arrivalTimes[$i];


            // Calculate turnaround time for the current process
            $turnaroundTimes[$i] = $waitingTimes[$i] + $burstTimes[$i];


            // Update completion time for the next process
            $completionTime += $burstTimes[$i];
        }


        // Calculate average waiting time
        $averageWaitingTime = $n > 0 ? array_sum($waitingTimes) / $n : 0;


        // Calculate average turnaround time
        $averageTurnaroundTime = $n > 0 ? array_sum($turnaroundTimes) / $n : 0;


        // Display Gantt chart and table
        // echo '<h3>Gantt Chart</h3>';
        // echo '<div>';
        // for ($i = 0; $i < $n; $i++) {
        //     echo 'P' . ($i + 1) . ' | ';
        //}
        //echo '</div>';
        
        echo '<br>';

        echo '<h3>Table</h3>';
        echo '<table>';
        echo '<tr><th>Process</th><th>Arrival Time</th><th>Burst Time</th><th>Waiting Time</th><th>Turnaround Time</th></tr>';
        for ($i = 0; $i < $n; $i++) {
            echo '<tr>';
            echo '<td>P' . ($i + 1) . '</td>';
            echo '<td>' . $arrivalTimes[$i] . '</td>';
            echo '<td>' . $burstTimes[$i] . '</td>';
            echo '<td>' . $waitingTimes[$i] . '</td>';
            echo '<td>' . $turnaroundTimes[$i] . '</td>';
            echo '</tr>';
        }
        echo '</table>';


        echo '<p>Average Waiting Time: ' . $averageWaitingTime . '</p>';
        echo '<p>Average Turnaround Time: ' . $averageTurnaroundTime . '</p>';
    }
    ?>
 
    </div>
</body>
</html>
