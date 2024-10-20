<?php
require_once 'inc/dbconn.inc.php';

$query = "SELECT Jobs.job_id, Jobs.job_name, Jobs.job_duration, Jobs.machine_name 
          FROM Jobs";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
}

$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = [
        'job_id' => $row['job_id'],
        'job_name' => $row['job_name'],
        'job_duration' => $row['job_duration'],
        'machine_name' => $row['machine_name']
    ];
}

header('Content-Type: application/json');
echo json_encode($jobs);
?>