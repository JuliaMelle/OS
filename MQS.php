<?php
class Process {
   public $id;
   public $burstTime;
   public $priority;

   public function __construct($id, $burstTime, $priority) {
       $this->id = $id;
       $this->burstTime = $burstTime;
       $this->priority = $priority;
   }
}

function calculateWaitingTime($processes, $n, $queue) {
   $wt = array();
   $wt[0] = 0;

   for ($i = 1; $i < $n; $i++) {
       $wt[$i] = $wt[$i - 1] + $processes[$i - 1]->burstTime;
   }

   return $wt;
}

function calculateTurnaroundTime($processes, $n, $wt) {
   $tt = array();

   for ($i = 0; $i < $n; $i++) {
       $tt[$i] = $processes[$i]->burstTime + $wt[$i];
   }

   return $tt;
}

function calculateAverageTime($processes, $n) {
   $wt = calculateWaitingTime($processes, $n, 0);
   $tt = calculateTurnaroundTime($processes, $n, $wt);

   $totalWt = array_sum($wt);
   $totalTt = array_sum($tt);

   $avgWt = $totalWt / $n;
   $avgTt = $totalTt / $n;

   echo "Average waiting time = " . $avgWt . "<br>";
   echo "Average turnaround time = " . $avgTt . "<br>";
}

$processes = array(
   new Process(1, 6, 1),
   new Process(2, 8, 0),
   new Process(3, 7, 1),
   new Process(4, 3, 0)
);

$n = count($processes);

calculateAverageTime($processes, $n);
?>
