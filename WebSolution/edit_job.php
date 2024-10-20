<?php
// Include the database connection
require_once 'inc\dbconn.inc.php';

// Get the JSON data sent from the client
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize the input data
$jobId = mysqli_real_escape_string($conn, $data['job_id']);
$jobName = mysqli_real_escape_string($conn, $data['job_name']);
$jobDuration = mysqli_real_escape_string($conn, $data['job_duration']);
$machineName = mysqli_real_escape_string($conn, $data['machine_name']); // Assuming machine_name is sent

// Prepare the SQL UPDATE statement
$query = "UPDATE Jobs SET 
            job_name = '$jobName', 
            job_duration = '$jobDuration', 
            machine_name = '$machineName' 
          WHERE job_id = '$jobId'";

// Execute the query and check if it was successful
if (mysqli_query($conn, $query)) {
    // If the update was successful, return a success status
    echo json_encode(['status' => 'success']);
} else {
    // If there was an error, return an error message
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}

// Close the database connection
mysqli_close($conn);
?>