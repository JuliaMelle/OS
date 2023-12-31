<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling Simulation</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h2>Scheduling Simulation</h2>

    <form method="post" action="">
        <label for="arrival_time">Arrival Time:</label>
        <input type="text" name="arrival_time[]">

        <label for="burst_time">Burst Time:</label>
        <input type="text" name="burst_time[]">

        <label for="queue">Queue:</label>
        <input type="text" name="queue[]">

        <button type="button" onclick="addProcess()">Add Process</button>

        <br><br>

        <input type="submit" name="submit" value="Simulate">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $arrivalTimes = $_POST['arrival_time'];
        $burstTimes = $_POST['burst_time'];
        $queues = $_POST['queue'];

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
        $averageWaitingTime = array_sum($waitingTimes) / $n;

        // Calculate average turnaround time
        $averageTurnaroundTime = array_sum($turnaroundTimes) / $n;

        // Display Gantt chart and table
        echo '<h3>Gantt Chart</h3>';
        echo '<div>';
        for ($i = 0; $i < $n; $i++) {
            echo 'P' . ($i + 1) . ' | ';
        }
        echo '</div>';

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

    <script>
        let processCount = 1;

        function addProcess() {
            processCount++;

            const form = document.querySelector('form');

            const arrivalInput = document.createElement('input');
            arrivalInput.type = 'text';
            arrivalInput.name = 'arrival_time[]';
            form.appendChild(arrivalInput);

            const burstInput = document.createElement('input');
            burstInput.type = 'text';
            burstInput.name = 'burst_time[]';
            form.appendChild(burstInput);

            const queueInput = document.createElement('input');
            queueInput.type = 'text';
            queueInput.name = 'queue[]';
            form.appendChild(queueInput);
        }
    </script>
</body>
</html>