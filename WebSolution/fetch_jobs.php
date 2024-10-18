<?php
require_once 'inc\dbconn.inc.php'; // Ensure the path is correct

// Query to select job details
$query = "SELECT Jobs.job_id, Jobs.job_name, Jobs.job_duration, Machines.machine_name 
          FROM jobs 
          INNER JOIN Machines ON jobs.machine_name = Machines.machine_name";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
}

// Initialize an array to hold job data
$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row; // Add each row of job data to the jobs array
}

// Return the jobs array as a JSON response
echo json_encode($jobs);
?>