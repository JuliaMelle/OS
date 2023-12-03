<?php
class Process {
  public $processId;
  public $arrivalTime;
  public $burstTime;
  public $priority;
  public $completionTime;

  public function __construct($processId, $arrivalTime, $burstTime, $priority) {
      $this->processId = $processId;
      $this->arrivalTime = $arrivalTime;
      $this->burstTime = $burstTime;
      $this->priority = $priority;
  }
}

function calculateWaitingTime($processes, $n, $bt) {
  $wt = array();
  $wt[0] = 0;
  for ($i = 1; $i < $n; $i++) {
      $wt[$i] = 0;
      for ($j = 0; $j < $i; $j++)
          $wt[$i] += $bt[$j];
  }
  return $wt;
}
function calculateCompletionTime2($processes, $n, $bt) {
    $ct2 = array();
    for ($i = 0; $i < $n; $i++)
        $ct2[$i] = $processes[$i]->arrivalTime + $bt[$i];
    return $ct2;
  }
function calculateTurnAroundTime($processes, $n, $ct) {
    $tat = array();
    for ($i = 0; $i < $n; $i++)
      $tat[$i] = $ct[$i] - $processes[$i]->arrivalTime;
    return $tat;
   }
function calculateAverageTime($processes, $n, $bt) {

    for ($i = 0; $i < $n; $i++) {
        echo "Process " . $processes[$i]->processId . " arrival time: " . $processes[$i]->arrivalTime . "<br>";
      }

    $wt = calculateWaitingTime($processes, $n, $bt);
  
    $ct = calculateCompletionTime($processes, $n, $bt, $wt);
    $tat = calculateTurnAroundTime($processes, $n, $ct);
    $ct2=calculateCompletionTime2($processes, $n, $bt);

    echo "Turnaround time array: ";
    print_r($tat);
    echo "<br>";
    echo "Completion time array: ";
    print_r($ct);
    echo "<br>";
    $total_wt = array_sum($wt);
    $total_tat = array_sum($tat);
    $avg_wt = $total_wt / $n;
    $avg_tat = $total_tat / $n;
    echo "Average waiting time = " . $avg_wt;
    echo "<br>";
    echo "Average turn around time = " . $avg_tat;
   }

   function printGanttChart($processes, $n, $ct) {
    for ($i = 0; $i < $n; $i++) {
     echo "Process " . $processes[$i]->processId . " completes at time: " . $ct[$i] . "<br>";
    }
   }
   

function printWaitingTime($wt) {
    echo "Waiting time array: ";
    print_r($wt);
    echo "<br>";
   }

function priorityNonPreemptive($processes, $n) {
    $bt = array();
    for ($i = 0; $i < $n; $i++)
    $bt[$i] = $processes[$i]->burstTime;
    $arrivalTime = array();
    for ($i = 0; $i < $n; $i++)
    $arrivalTime[$i] = $processes[$i]->arrivalTime;
    $processes = sortByArrivalTime($processes, $n);
    $wt = calculateWaitingTime($processes, $n, $bt);
    $ct = calculateCompletionTime($processes, $n, $bt, $wt);
    $tat = calculateTurnAroundTime($processes, $n, $ct, $arrivalTime);
    $wt = calculateWaitingTime($processes, $n, $ct, $bt);

    calculateAverageTime($processes, $n, $bt);

    
   }
   
   
   

function sortByArrivalTime($processes, $n) {
  for ($i = 0; $i < $n; $i++)
      for ($j = 0; $j < $n - $i - 1; $j++)
          if ($processes[$j]->arrivalTime > $processes[$j + 1]->arrivalTime) {
              $temp = $processes[$j];
              $processes[$j] = $processes[$j + 1];
              $processes[$j + 1] = $temp;
          }
  return $processes;
}

function sortByPriority($processes, $n) {
  for ($i = 0; $i < $n; $i++)
      for ($j = 0; $j < $n - $i - 1; $j++)
          if ($processes[$j]->priority < $processes[$j + 1]->priority) {
              $temp = $processes[$j];
              $processes[$j] = $processes[$j + 1];
              $processes[$j + 1] = $temp;
          }
  return $processes;
}

function createGanttChart($processes, $n) {
  $ganttChart = array();
  for ($i = 0; $i < $n; $i++) {
      $ganttChart[$i] = $processes[$i]->processId;
  }
  print_r($ganttChart);
}

function calculateCompletionTime($processes, $n, $bt, $wt) {
  $ct = array();
  for ($i = 0; $i < $n; $i++)
      $ct[$i] = $wt[$i] + $bt[$i];
  return $ct;
}

function calculateTotalTime($processes, $n, $bt) {
  $total_bt = 0;
  for ($i = 0; $i < $n; $i++)
      $total_bt += $bt[$i];
  return $total_bt;
}



// Example usage
$processes = array(
   new Process(1, 0, 10, 2),
   new Process(2, 2, 5, 0),
   new Process(3, 3, 2, 1),
   new Process(4, 5, 20, 3)

);
$n = count($processes);
priorityNonPreemptive($processes, $n);
?>
