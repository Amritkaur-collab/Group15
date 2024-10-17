<?php
// Include the database configuration
require_once "../WebSolution/inc/dbconn.inc.php"; // Ensure session is started in this file
require_once "../WebSolution/auth/sessioncheck.php";

// Initialize logs session variable if not set
if (!isset($_SESSION['logs'])) {
    $_SESSION['logs'] = [];
}

// Update machine status page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs and sanitize them
    $machine = filter_input(INPUT_POST, "machine", FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
    $employeeId = filter_input(INPUT_POST, "employee_id", FILTER_SANITIZE_NUMBER_INT);
    $employeeName = filter_input(INPUT_POST, "employee_name", FILTER_SANITIZE_STRING);
    $log = filter_input(INPUT_POST, "details", FILTER_SANITIZE_STRING);

    // Use a dash if the employee name is empty
    $employeeName = empty($employeeName) ? '-' : $employeeName;

    // Create a new log entry
    $newLogEntry = [
        date('Y-m-d H:i:s'), // Date and Time
        $machine,            // Machine
        $status,             // Status
        $employeeId,         // Employee ID
        $employeeName,       // Employee Name
        $log                  // Maintenance Details
    ];

    // Add the new log entry to the session logs
    $_SESSION['logs'][] = $newLogEntry;

    // Keep only the last 5 entries in the session logs
    if (count($_SESSION['logs']) > 5) {
        array_shift($_SESSION['logs']); // Remove the oldest log if there are more than 5
    }

    // Check if the machine exists in the Machines table
    $machineCheckStmt = $conn->prepare("SELECT COUNT(*) FROM Machines WHERE machine_name = ?");
    $machineCheckStmt->bind_param("s", $machine);
    $machineCheckStmt->execute();
    $machineCheckStmt->bind_result($count);
    $machineCheckStmt->fetch();
    $machineCheckStmt->close();

    if ($count > 0) {
        // The machine exists, proceed with insertion
        $stmt = $conn->prepare("INSERT INTO MachineNotes (timestamp, machine_name, user_id, user_name, content) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $newLogEntry[0], $newLogEntry[1], $newLogEntry[2], $newLogEntry[3], $newLogEntry[4]);

        if ($stmt->execute()) {
            // Optional: handle successful insert
        } else {
            echo "Error: " . htmlspecialchars($stmt->error); // Display error if the insertion fails
        }
        
        $stmt->close(); // Close the statement
    } else {
        echo "Error: Machine '" . htmlspecialchars($machine) . "' does not exist in the Machines table.";
    }

    // Optional: Redirect to prevent form re-submission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Retrieve the logs from the session
$logs = $_SESSION['logs'];

// Reverse the logs array to show the most recent updates first
$logs = array_reverse($logs);

// Fetch all logs from the database
$result = $conn->query("SELECT timestamp, machine_name, user_id, user_name, content FROM MachineNotes ORDER BY timestamp DESC");
$databaseLogs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard: Update Assigned Machines</title>
    <link rel="stylesheet" href="../WebSolution/styles/style.css" />
    <?php   
        require_once "auth/sessioncheck.php";
    ?>
    <?php require_once "auth/permissioncheck.php";
        requireRole(array('Production Operator'));
    ?>
</head>
<body>
    <?php require_once "../WebSolution/inc/dbsidebar.inc.php"; ?>
    <?php require_once "../WebSolution/inc/dbheader.inc.php"; ?>

    <div id="pagetitle">
        <h1>Machine Status</h1>
    </div>

    <div id='updatepage'>
        <form method="POST" action="">
            <div id="filters">
                <h2>Status Update</h2>
                <ul>
                    <li>
                        <label for="machine">Machine: </label>
                        <select name="machine" id="machine" required>
                            <option value="">Select Machine</option>
                            <?php
                            $machines = [
                                "3D Printer",
                                "CNC Machine",
                                "Industrial Robot",
                                "Automated Guided Vehicle (AGV)",
                                "Smart Conveyor System",
                                "IoT Sensor Hub",
                                "Predictive Maintenance System",
                                "Automated Assembly Line",
                                "Quality Control Scanner",
                                "Energy Management System"
                            ];

                            foreach ($machines as $machine) {
                                echo "<option value=\"" . htmlspecialchars($machine) . "\">" . htmlspecialchars($machine) . "</option>";
                            }
                            ?>
                        </select>
                    </li>

                    <li>
                        <label for="status">Operational Status: </label>
                        <select name="status" id="status" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </li>

                    <li>
                        <label for="employee_id">Updated By (ID):</label>
                        <input type="number" name="employee_id" id="employee_id" required>
                    </li>

                    <li>
                        <label for="employee_name">Updated By (Name):</label>
                        <input type="text" name="employee_name" id="employee_name" required>
                    </li>

                    <li>
                        <label for="details">Maintenance Details:</label>
                        <textarea name="details" id="details" rows="4" cols="50"></textarea>
                    </li>

                    <li>
                        <input type="submit" id="submit" value="Update">
                    </li>
                </ul>
            </div>
            <div id="latest-machine-updates">
                <h2>Recent Machine Updates</h2>
                <?php if (!empty($logs)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Machine</th>
                                <th>Updated By (ID)</th>
                                <th>Updated By (Name)</th>
                                <th>Additional Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $logEntry): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($logEntry[0]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[1]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[2]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[3]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[4]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No machine updates made yet.</p>
                <?php endif; ?>
            </div>
        </form>
    <footer>
        <p>@FactorieWorks Co.</p>
    </footer>
</body>
</html>
