<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Include your database connection

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$jobName = $data['job_name'] ?? null; // Use null coalescing operator
$jobDuration = $data['job_duration'] ?? null;
$assignedMachine = $data['assigned_machine'] ?? null; // Assume this is the machine_name

// Check if required fields are present
if (!$jobName || !$jobDuration || !$assignedMachine) {
    echo json_encode(['status' => 'error', 'message' => 'Job name, duration, and assigned machine are required']);
    exit;
}

// Prepare your SQL insert statement for the Jobs table
$sql = "INSERT INTO Jobs (job_name, job_duration, assigned_machine) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if statement prepared correctly
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}

$stmt->bind_param("sis", $jobName, $jobDuration, $assignedMachine); // Adjusted bind_param types

// Execute the statement and return a JSON response
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>