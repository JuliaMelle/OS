<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/priority_non_preemptive.css">
    <title>Priority Scheduling [NON-PREEMPTIVE]</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


</head>

<body style="background-color: black;" >

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

<div class="d-flex justify-content-center align-items-center flex-column m-2 mt-5 pt-5"> 
    <div class=" form container" style="height: 100%;width:50%">

        <form method="post"  class="d-flex flex-column" style="width:100%">
            <div class="mb-3">
                <label for="arrival_times" class="form-label">Arrival Times:</label>
                <input type="text" name="arrival_times" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="burst_times" class="form-label">Burst Times:</label>
                <input type="text" name="burst_times" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="priorities" class="form-label">Priorities:</label>
                <input type="text" name="priorities" class="form-control">
            </div>

            <input type="submit" value="Submit" class="btn btn-dark">
        </form>
    </div>
    </div>

</body>

</html>
<?php

function priorityScheduling($process)
{
    $n = count($process);

    // Sort process by priority and then by arrival time
    usort($process, function ($a, $b) {
        if ($a['priority'] == $b['priority']) {
            return $a['arrivalTime'] - $b['arrivalTime'];
        }
        return $a['priority'] - $b['priority'];
    });

    $finishTime = array_fill(0, $n, 0);
    $turnaroundTime = array_fill(0, $n, 0);
    $waitingTime = array_fill(0, $n, 0);

    $finishTime[0] = $process[0]['arrivalTime'] + $process[0]['burstTime'];
    $turnaroundTime[0] = $finishTime[0] - $process[0]['arrivalTime'];
    $waitingTime[0] = $turnaroundTime[0] - $process[0]['burstTime'];

    for ($i = 1; $i < $n; $i++) {
        $finishTime[$i] = max($process[$i]['arrivalTime'], $finishTime[$i - 1]) + $process[$i]['burstTime'];
        $turnaroundTime[$i] = $finishTime[$i] - $process[$i]['arrivalTime'];
        $waitingTime[$i] = $turnaroundTime[$i] - $process[$i]['burstTime'];
        $waitingTime[$i] = max(0, $waitingTime[$i]);
    }

    // Calculate averages
    $averageTurnaroundTime = array_sum($turnaroundTime) / $n;
    $averageWaitingTime = array_sum($waitingTime) / $n;
?>
<div class="d-flex justify-content-center align-items-center flex-column m-2 table-responsive"> 
    <div class=" form" style="height: 100%;width:50%">

        <h1>Non-Preemptive Priority</h1>
        <div class="table-container table-border">

            <table>
                <tr>
                    <th class='p-3'>PriorityID</th>
                    <th class='p-3'>Arrival Time</th>
                    <th class='p-3'>Burst Time</th>
    
                    <th class='p-3'>Priority</th>
                    <th class='p-3'>Turnaround Time</th>
                    <th class='p-3'>Waiting Time</th>
     
                </tr>
                <?php
                for ($i = 0; $i < $n; $i++) {
                    echo "<tr>
                    <td class='p-3'>{$process[$i]['PriorityID']}</td>
                    <td class='p-3'>{$process[$i]['arrivalTime']}</td>
                    <td class='p-3'>{$process[$i]['burstTime']}</td>

                    <td class='p-3'>{$process[$i]['priority']}</td>
                    <td class='p-3'>{$turnaroundTime[$i]}</td>
                    <td class='p-3'>{$waitingTime[$i]}</td></tr>";
                
                
                
                }
                ?>

            </table>



            <p class="muted h5 mt-5">Average Turnaround Time: <?php echo $averageTurnaroundTime ?></p>
            <p class="muted h5">Average Waiting Time: <?php echo $averageWaitingTime ?> </p>
        </div>
    </div>
    <?php // Return finish times
    return $finishTime;
}
    ?>
    </div>
    <?php
    function printGanttChart($process, $n, $finishTime)
    {
        for ($i = 0; $i < $n; $i++) {
            echo "Process " . $process[$i]->PriorityID . " completes at time: " . $finishTime[$i] . "<br>";
        }
    }

    // Validate and process the form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $AT = $_POST['arrival_times'];
        $BT = $_POST['burst_times'];
        $priorities = $_POST['priorities'];


        $AT = preg_split("/[\s,]+/", $AT);
        $BT = preg_split("/[\s,]+/", $BT);


        if (empty($priorities)) {
            $priorities = array_fill(0, count($AT), 1);
        } else {
            $priorities = preg_split("/[\s,]+/", $priorities);
        }

        // Validate input counts
        if (count($AT) == count($BT) && count($BT) == count($priorities)) {
            $process = [];
            $n = count($AT);

            for ($i = 0; $i < $n; $i++) {
                $process[] = [
                    'PriorityID' => $i + 1, // Convert to numbers starting from 1
                    'arrivalTime' => intval($AT[$i]),
                    'burstTime' => intval($BT[$i]),
                    'priority' => intval($priorities[$i]),
                ];
            }

            // Call the scheduling function
            priorityScheduling($process);
        } else {
            echo "Error: The number of arrival times, burst times, and priorities must be the same.";
        }
    }


    ?>