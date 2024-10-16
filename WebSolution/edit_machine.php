<?php
include 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php';

// Get the data from the request
$data = json_decode(file_get_contents("php://input"), true);

$machineName = $data['machine_name'];
$machineLocation = $data['machine_location'];
$dateAcquired = $data['date_acquired'];
$serialNumber = $data['serial_number'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Machines SET machine_location = ?, date_acquired = ?, serial_number = ? WHERE machine_name = ?");
$stmt->bind_param("ssss", $machineLocation, $dateAcquired, $serialNumber, $machineName);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>