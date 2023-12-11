<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
   // Retrieve data from the POST request
   $arrivalTimeInput = isset($_POST['arrivalTimeInput']) ? $_POST['arrivalTimeInput'] : '';
   $burstTimeInput = isset($_POST['burstTimeInput']) ? $_POST['burstTimeInput'] : '';
   $queueInput = isset($_POST['queueInput']) ? $_POST['queueInput'] : '';

   // Validate the inputs (you might need more robust validation)
   if (!validateString($arrivalTimeInput) || !validateString($burstTimeInput)) {
       echo "Invalid input!";
       exit;
   }

   // Split input strings into arrays
   $arrivalTimes = explode(" ", $arrivalTimeInput);
   $burstTimes = explode(" ", $burstTimeInput);
   $queues = explode(" ", $queueInput);

   // Initialize waitingTimes and completionTimes arrays
   $waitingTimes = [];
   $completionTimes = [];

   // Your scheduling logic here (you'll need to implement classes/functions similar to the Vue.js code)

   // Example: Calculate average waiting time and turnaround time
   $averageWaitingTime = count($waitingTimes) > 0 ? array_sum($waitingTimes) / count($waitingTimes) : 0;
   $averageTurnaroundTime = count($completionTimes) > 0 ? array_sum($completionTimes) / count($completionTimes) : 0;

   // Return the results as JSON or HTML, depending on your requirements
   $results = [
       'averageWaitingTime' => $averageWaitingTime,
       'averageTurnaroundTime' => $averageTurnaroundTime,
       // Add other results as needed
   ];

   echo json_encode($results);
   exit;
}

// Function to validate input strings (similar to Vue.js function)
function validateString($string) {
   $regExp = '/[a-z]/i';
   return !preg_match($regExp, $string);
}
?>

<!-- Your HTML form here (similar to Vue.js template) -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Multilevel Queue Scheduling</title>
</head>
<body>

<form method="post" action="">
   <!-- Your form fields here (similar to Vue.js template) -->
   <label for="arrivalTimeInput">Arrival Time</label>
   <input type="text" name="arrivalTimeInput" placeholder="0 1 2 3">

   <label for="burstTimeInput">Burst Time</label>
   <input type="text" name="burstTimeInput" placeholder="15 10 20 6">

   <label for="queueInput">Queue</label>
   <input type="text" name="queueInput" placeholder="0 1 0 1">

   <button type="submit" name="submit">Run</button>
</form>

<!-- Display results here (similar to Vue.js template) -->
<div>
   <p>Average Waiting Time: <?php echo $results['averageWaitingTime'] ?? ''; ?></p>
   <p>Average Turnaround Time: <?php echo $results['averageTurnaroundTime'] ?? ''; ?></p>
</div>

</body>
</html>
