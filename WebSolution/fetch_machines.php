<?php
<<<<<<< Updated upstream
require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php'; // Ensure the path is correct
=======
require_once 'inc\dbconn.inc.php'; // Ensure the path is correct
>>>>>>> Stashed changes

$query = "SELECT machine_name, machine_location, date_acquired, serial_number FROM Machines";
$result = mysqli_query($conn, $query);

$machines = [];
while ($row = mysqli_fetch_assoc($result)) {
    $machines[] = $row;
}

echo json_encode($machines);
?>