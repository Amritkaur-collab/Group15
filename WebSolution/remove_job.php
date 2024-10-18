<?php
<<<<<<< Updated upstream
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Include database connection

$data = json_decode(file_get_contents('php://input'), true);
$jobId = $data['job_id'] ?? null;

=======
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'inc\dbconn.inc.php'; // Include your database connection

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$jobId = $data['job_id'] ?? null; // Get job_id from the request

// Check if job_id is provided
>>>>>>> Stashed changes
if (!$jobId) {
    echo json_encode(['status' => 'error', 'message' => 'Job ID is required']);
    exit;
}

<<<<<<< Updated upstream
$sql = "DELETE FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jobId);

=======
// Prepare your SQL delete statement for the jobs table
$sql = "DELETE FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($sql);

// Check if statement prepared correctly
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}

// Bind the job ID parameter
$stmt->bind_param("i", $jobId);

// Execute the statement and return a JSON response
>>>>>>> Stashed changes
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>