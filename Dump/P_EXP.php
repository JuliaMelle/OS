<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="global.css">
  <link rel="stylesheet" href="reset.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <title>Priority Scheduling</title>
</head>
<body>
 <div class="container">
    <div class="row">
       <div class="col-12 col-md-6">
        <?php  $self = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL)?>
          <form method="post" action="<?php echo $self;
 ?>">
             <div class="form-group">
                <label for="arrival_times">Arrival Times:</label>
                <input type="text" name="arrival_times" class="form-control" required><br>
             </div>
             <div class="form-group">
                <label for="burst_times">Burst Times:</label>
                <input type="text" name="burst_times" class="form-control" required><br>
             </div>
             <div class="form-group">
                <label for="priorities">Priorities:</label>
                <input type="text" name="priorities" class="form-control"><br>
             </div>
             <input type="submit" value="Submit" class="btn btn-primary">
          </form>
       </div>
    </div>
 </div>
</body>
</html>

<?php
function handleForm() {
   $arrival_times = $_POST['arrival_times'];
   $burstTimes = $_POST['burst_times'];
   $priorities = $_POST['priorities'];

   // Convert input strings to arrays
   $arrival_times = preg_split("/[\s,]+/", $arrival_times);
   $burstTimes = preg_split("/[\s,]+/", $burstTimes);
   
   // If priorities input is empty, assume default values of 1 for all priorities
   if (empty($priorities)) {
       $priorities = array_fill(0, count($arrival_times), 1);
   } else {
       $priorities = preg_split("/[\s,]+/", $priorities);
   }

   // Validate input counts
   if (count($arrival_times) == count($burstTimes) && count($burstTimes) == count($priorities)) {
       $jobs = [];
       $n = count($arrival_times);

       for ($i = 0; $i < $n; $i++) {
           $jobs[] = [
               'job' => chr(65 + $i), // Convert to letters A, B, C
               'arrival_time' => intval($arrival_times[$i]),
               'burstTime' => intval($burstTimes[$i]),
               'priority' => intval($priorities[$i]),
           ];
       }

       // Call the scheduling function
       scheduleJobs($jobs);
   } else {
       echo "Error: The number of arrival times, burst times, and priorities must be the same.";
   }
}

function scheduleJobs($jobs) {
   $n = count($jobs);

   // Sort jobs by priority and then by arrival time
   usort($jobs, function ($a, $b) {
       if ($a['priority'] == $b['priority']) {
           return $a['arrival_time'] - $b['arrival_time'];
       }
       return $a['priority'] - $b['priority'];
   });

   $finishTime = array_fill(0, $n, 0);
   $turnaround_time = array_fill(0, $n, 0);
   $waiting_time = array_fill(0, $n, 0);

   $finishTime[0] = $jobs[0]['arrival_time'] + $jobs[0]['burstTime'];
   $turnaround_time[0] = $finishTime[0] - $jobs[0]['arrival_time'];
   $waiting_time[0] = $turnaround_time[0] - $jobs[0]['burstTime'];

   for ($i = 1; $i < $n; $i++) {
       $finishTime[$i] = max($jobs[$i]['arrival_time'], $finishTime[$i - 1]) + $jobs[$i]['burstTime'];
       $turnaround_time[$i] = $finishTime[$i] - $jobs[$i]['arrival_time'];
       $waiting_time[$i] = $turnaround_time[$i] - $jobs[$i]['burstTime'];
       $waiting_time[$i] = max(0, $waiting_time[$i]);
   }

   // Calculate averages
   $averageturnaround_time = array_sum($turnaround_time) / $n;
   $averagewaiting_time = array_sum($waiting_time) / $n;

   // Output the table
   echo '<div class="table-container table-border">';
   echo "<h1>Priority [Non-Preemptive] </h1>";
   echo "<table>";
   echo "<tr><th>Job</th><th>Arrival Time</th><th>Burst Time</th><th>Finish Time</th><th>Turnaround Time</th><th>Waiting Time</th><th>Priority</th></tr>";
   for ($i = 0; $i < $n; $i++) {
       echo "<tr><td>{$jobs[$i]['job']}</td><td>{$jobs[$i]['arrival_time']}</td><td>{$jobs[$i]['burstTime']}</td><td>{$finishTime[$i]}</td><td>{$turnaround_time[$i]}</td><td>{$waiting_time[$i]}</td><td>{$jobs[$i]['priority']}</td></tr>";
   }
   echo "</table>";

    // Output averages
   echo '<p class="muted">Average Turnaround Time: ' . htmlspecialchars($averageturnaround_time) . '</p>' ;
   echo '<p class="muted">Average Waiting Time: ' . htmlspecialchars($averagewaiting_time) . '</p>' ;
   echo "</div>";
}

// Validate and process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   handleForm();
}
?>
