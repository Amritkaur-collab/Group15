<?php
require_once 'inc\dbconn.inc.php'; // Ensure the path is correct

$query = "SELECT machine_name, machine_location, date_acquired, serial_number FROM Machines";
$result = mysqli_query($conn, $query);

$machines = [];
while ($row = mysqli_fetch_assoc($result)) {
    $machines[] = $row;
}

echo json_encode($machines);
?>