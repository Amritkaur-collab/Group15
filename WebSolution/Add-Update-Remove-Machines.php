<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Group 15" />
    <meta name="description" content="Add-Update-Remove-Jobs/Machines" />
    <title>Manage Machines</title>
    <link rel="stylesheet" href="styles/machinestyle.css">
    <?php
    session_start();
    if(!isset($_SESSION['exists'])) {
        session_unset();
        session_destroy();
        header('Location: login.php');
    }
    
    // Include the database connection
    include 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php';

    // Fetch machines from the database
    $machines = [];
    $result = $conn->query("SELECT * FROM Machines");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $machines[] = $row;
        }
    }
    ?>
</head>
<body>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
    <?php require_once "inc/dbheader.inc.php"; ?>

    <div class="container">
        <h1>Manage Machines</h1>
        <div class="machine-form">
            <h3>Add Machine</h3>
            <label for="machine-name">Machine Name:</label>
            <input type="text" id="machine-name" required>
            
            <label for="machine-location">Location:</label>
            <input type="text" id="machine-location">
        
            <label for="machine-date">Date Acquired:</label>
            <input type="date" id="machine-date">
        
            <label for="machine-serial">Serial Number:</label>
            <input type="text" id="machine-serial">

            <button class="machine-button" onclick="addMachine()">Add Machine</button>
        </div>

        <div class="machines-table">
            <h3>Machines</h3>
            <table id="machine-table">
                <thead>
                    <tr>
                        <th>Machine Name</th>
                        <th>Location</th>
                        <th>Date Acquired</th>
                        <th>Serial Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($machines as $machine): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($machine['machine_name']); ?></td>
                            <td><?php echo htmlspecialchars($machine['machine_location']); ?></td>
                            <td><?php echo htmlspecialchars($machine['date_acquired']); ?></td>
                            <td><?php echo htmlspecialchars($machine['serial_number']); ?></td>
                            <td>
                                <button onclick="editMachine('<?php echo htmlspecialchars($machine['machine_name']); ?>')">Edit</button>
                                <button onclick="removeMachine('<?php echo htmlspecialchars($machine['machine_name']); ?>')">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div> 

    <!-- Modal for editing machine details -->
    <div id="editMachineModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Edit Machine</h3>
            <label for="edit-machine-name">Machine Name:</label>
            <input type="text" id="edit-machine-name" required>
            
            <label for="edit-machine-location">Location:</label>
            <input type="text" id="edit-machine-location">
            
            <label for="edit-machine-date">Date Acquired:</label>
            <input type="date" id="edit-machine-date">
            
            <label for="edit-machine-serial">Serial Number:</label>
            <input type="text" id="edit-machine-serial">

            <button class="machine-button" onclick="updateMachine()">Update Machine</button>
        </div>
    </div>
    
    <script defer src="scripts/fmdscript.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchMachines(); // Fetch machines when the page loads
    });
</script>
</body>
</html>