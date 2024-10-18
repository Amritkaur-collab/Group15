<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
<<<<<<< Updated upstream
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Include your database connection
=======
require_once 'inc\dbconn.inc.php'; // Include your database connection
>>>>>>> Stashed changes

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$machineName = $data['machine_name'] ?? null; // Use null coalescing operator

// Check if machine name is provided
if (!$machineName) {
    echo json_encode(['status' => 'error', 'message' => 'Machine name is required']);
    exit;
}

// Prepare your SQL delete statement
$sql = "DELETE FROM Machines WHERE machine_name = ?";
$stmt = $conn->prepare($sql);

// Check if statement prepared correctly
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}

$stmt->bind_param("s", $machineName);

// Execute the statement and return a JSON response
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>