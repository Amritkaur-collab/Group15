<?php
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Ensure the path is correct

// Query to select job details
$query = "SELECT job_id, job_name, job_duration, machine_name FROM Jobs INNER JOIN Machines ON Jobs.machine_id = Machines.machine_id";
$result = mysqli_query($conn, $query);

// Initialize an array to hold job data
$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row; // Add each row of job data to the jobs array
}

// Return the jobs array as a JSON response
echo json_encode($jobs);
?>