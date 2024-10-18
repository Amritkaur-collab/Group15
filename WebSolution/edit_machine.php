<?php
<<<<<<< Updated upstream
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
=======
require_once 'inc\dbconn.inc.php'; // Ensure the path is correct

$data = json_decode(file_get_contents("php://input"), true);

$machineName = mysqli_real_escape_string($conn, $data['machine_name']);
$machineLocation = mysqli_real_escape_string($conn, $data['machine_location']);
$dateAcquired = mysqli_real_escape_string($conn, $data['date_acquired']);
$serialNumber = mysqli_real_escape_string($conn, $data['serial_number']);

$query = "UPDATE Machines SET 
            machine_location = '$machineLocation',
            date_acquired = '$dateAcquired',
            serial_number = '$serialNumber' 
          WHERE machine_name = '$machineName'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
}
>>>>>>> Stashed changes
?>