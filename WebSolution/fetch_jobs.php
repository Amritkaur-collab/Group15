<?php
<<<<<<< Updated upstream
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Ensure the path is correct

// Query to select job details
$query = "SELECT job_id, job_name, job_duration, machine_name FROM Jobs INNER JOIN Machines ON Jobs.machine_id = Machines.machine_id";
$result = mysqli_query($conn, $query);

=======
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

>>>>>>> Stashed changes
// Initialize an array to hold job data
$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row; // Add each row of job data to the jobs array
}

// Return the jobs array as a JSON response
echo json_encode($jobs);
?>