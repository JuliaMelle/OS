<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/scan.css">
    <title>Disk Scheduling Solver</title>
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

<div class="d-flex justify-content-center align-items-center">
   <div class="form form-container table-border mt-5" style="width: 50%;">
       <h2 >Disk Scheduling Solver</h2>
       <form id="diskForm" method="post" class="container">
   <div class="mb-3">
       <label for="currentPosition" class="form-label">Current Position:</label>
       <input type="number" name="currentPosition" class="form-control" required>
   </div>

   <div class="mb-3">
       <label for="trackSize" class="form-label">Track Size:</label>
       <input type="number" name="trackSize" class="form-control" required>
   </div>

   <div class="mb-3">
       <label for="seekRate" class="form-label">Seek Rate:</label>
       <input type="number" name="seekRate" class="form-control" required>
   </div>

   <div class="mb-3">
       <label for="requests" class="form-label">Requests:</label>
       <input type="text" name="requests" class="form-control" required>
   </div>
   <input type="submit" name="calculate" class="btn btn-primary">
</form>
</div>
</div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
        $currentPosition = isset($_POST["currentPosition"]) ? (int)$_POST["currentPosition"] : 0;
        $trackSize = isset($_POST["trackSize"]) ? (int)$_POST["trackSize"] : 0;
        $seekRate = isset($_POST["seekRate"]) ? (int)$_POST["seekRate"] : 0;
        $requestsString = isset($_POST["requests"]) ? $_POST["requests"] : '';

        // Parse requests from the input string
        $requests = preg_split('/[\s,]+/', $requestsString, -1, PREG_SPLIT_NO_EMPTY);
        $requests = array_map('intval', $requests);

        // Perform SCAN algorithm calculation
        function SCAN($arr, $head, $direction) {
            $seek_count = 0;
            $distance = 0;
            $cur_track = 0;
            $left = [];
            $right = [];        
            $seek_sequence = [];

            // Appending end values
            // which has to be visited
            // before reversing the direction
            if ($direction == "left") {
                array_push($left, 0);
            } elseif ($direction == "right") {
                array_push($right, $GLOBALS['trackSize'] - 1);
            }

            for ($i = 0; $i < count($arr); $i++) {
                if ($arr[$i] < $head) {
                    array_push($left, $arr[$i]);
                }
                if ($arr[$i] > $head) {
                    array_push($right, $arr[$i]);
                }
            }

            // Sorting left and right vectors
            sort($left);
            sort($right);

            // Run the while loop two times.
            // One by one scanning right
            // and left of the head
            $run = 2;
            while ($run-- > 0) {
                if ($direction == "left") {
                    for ($i = count($left) - 1; $i >= 0; $i--) {
                        $cur_track = $left[$i];

                        // Appending current track to seek sequence
                        array_push($seek_sequence, $cur_track);

                        // Calculate absolute distance
                        $distance = abs($cur_track - $head);

                        // Increase the total count
                        $seek_count += $distance;

                        // Accessed track is now the new head
                        $head = $cur_track;
                    }
                    $direction = "right";
                } elseif ($direction == "right") {
                    for ($i = 0; $i < count($right); $i++) {
                        $cur_track = $right[$i];

                        // Appending current track to seek sequence
                        array_push($seek_sequence, $cur_track);

                        // Calculate absolute distance
                        $distance = abs($cur_track - $head);

                        // Increase the total count
                        $seek_count += $distance;

                        // Accessed track is now new head
                        $head = $cur_track;
                    }
                    $direction = "left";
                }
            }

            // Calculate total head movement and seek time
            $totalHeadMovement = $seek_count;
            $seekTime = $totalHeadMovement / $GLOBALS['seekRate'];
?>
            
            <div class="form container w-50 m-4 h-90" >
   <div class="row">
       <div class="col">
           <p>Total number of seek operations</p>
           <h2><?php echo $seek_count; ?></h2>
       </div>

       <div class="col">
           <p>Total head movement</p>
           <h2><?php echo $totalHeadMovement; ?></h2>
       </div>

       <div class="col">
           <p>Seek time</p>
           <h2><?php echo $seekTime; ?></h2>
       </div>
   </div>

            
           <p >Seek Sequence is: </p>
<?php
            for ($i = 0; $i < count($seek_sequence); $i++) {
                echo '<div>' . $seek_sequence[$i]. '</div>';
            }
            // echo '</div>';

            // end container
            echo '</div>';

            // end main div
            echo '</div>'; 
        }

        // Display results
        SCAN($requests, $currentPosition, "left");
    }
    ?></div>
  
</body>
</html>
