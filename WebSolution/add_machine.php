<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'inc\dbconn.inc.php'; // Include your database connection

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$machineName = $data['machine_name'] ?? null; // Use null coalescing operator
$machineLocation = $data['machine_location'] ?? null;
$dateAcquired = $data['date_acquired'] ?? null;
$serialNumber = $data['serial_number'] ?? null;

// Check if required fields are present
if (!$machineName) {
    echo json_encode(['status' => 'error', 'message' => 'Machine name is required']);
    exit;
}

// Prepare your SQL insert statement
$sql = "INSERT INTO Machines (machine_name, machine_location, date_acquired, serial_number) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if statement prepared correctly
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $machineName, $machineLocation, $dateAcquired, $serialNumber);

// Execute the statement and return a JSON response
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Include your database connection

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$machineName = $data['machine_name'] ?? null; // Use null coalescing operator
$machineLocation = $data['machine_location'] ?? null;
$dateAcquired = $data['date_acquired'] ?? null;
$serialNumber = $data['serial_number'] ?? null;

// Check if required fields are present
if (!$machineName) {
    echo json_encode(['status' => 'error', 'message' => 'Machine name is required']);
    exit;
}

// Prepare your SQL insert statement
$sql = "INSERT INTO Machines (machine_name, machine_location, date_acquired, serial_number) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if statement prepared correctly
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
    exit;
}

$stmt->bind_param("ssss", $machineName, $machineLocation, $dateAcquired, $serialNumber);

// Execute the statement and return a JSON response
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>