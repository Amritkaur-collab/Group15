<?php
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
?>