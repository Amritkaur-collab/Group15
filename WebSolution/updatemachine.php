<?php

require_once "../WebSolution/inc/dbconn.inc.php"; 
require_once "../WebSolution/auth/sessioncheck.php";


if (!isset($_SESSION['logs'])) {
    $_SESSION['logs'] = [];
}


function updateMachineStatus($conn, $machine, $status, $employeeId, $employeeName, $log, $timestamp) {
    $stmt = $conn->prepare("UPDATE MachineNotes SET operational_status = ?, user_id = ?, user_name = ?, content = ? WHERE machine_name = ? AND timestamp = ?");
    $stmt->bind_param("sissss", $status, $employeeId, $employeeName, $log, $machine, $timestamp);
    return $stmt->execute();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $machine = filter_input(INPUT_POST, "machine", FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
    $employeeId = filter_input(INPUT_POST, "employee_id", FILTER_SANITIZE_NUMBER_INT);
    $employeeName = filter_input(INPUT_POST, "employee_name", FILTER_SANITIZE_STRING);
    $log = filter_input(INPUT_POST, "details", FILTER_SANITIZE_STRING);
    $timestamp = filter_input(INPUT_POST, "timestamp", FILTER_SANITIZE_STRING); 

    
    $employeeName = empty($employeeName) ? '-' : $employeeName;

    if (!empty($timestamp)) {
        if (updateMachineStatus($conn, $machine, $status, $employeeId, $employeeName, $log, $timestamp)) {
            echo "Job updated successfully.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error updating job: " . htmlspecialchars($stmt->error);
        }
    } else {
        $newLogEntry = [
            date('Y-m-d H:i:s'), 
            $machine,            
            $status,             
            $employeeId,         
            $employeeName,       
            $log              
        ];

        $_SESSION['logs'][] = $newLogEntry;

        
        if (count($_SESSION['logs']) > 5) {
            array_shift($_SESSION['logs']); 
        }

        $machineCheckStmt = $conn->prepare("SELECT COUNT(*) FROM Machines WHERE machine_name = ?");
        $machineCheckStmt->bind_param("s", $machine);
        $machineCheckStmt->execute();
        $machineCheckStmt->bind_result($count);
        $machineCheckStmt->fetch();
        $machineCheckStmt->close();

        if ($count > 0) {
            $stmt = $conn->prepare("UPDATE MachineNotes SET machine_name = ?, operational_status = ?, user_id = ?, user_name = ?, content = ? WHERE machine_name = ? AND timestamp = ?");
            $stmt->bind_param("ssissss", $machine, $status, $employeeId, $employeeName, $log, $machine, $newLogEntry[0]);

            if ($stmt->execute()) {
                echo "Updated successfully.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error logging job: " . htmlspecialchars($stmt->error); 
            }
            
            $stmt->close(); 
        } else {
            echo "Error: Machine '" . htmlspecialchars($machine) . "' does not exist in the Machines table.";
        }
    }
}

$logs = $_SESSION['logs'];
$logs = array_reverse($logs);

$result = $conn->query("SELECT timestamp, machine_name, operational_status, user_id, user_name, content FROM MachineNotes ORDER BY timestamp DESC");
$databaseLogs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Group 15" />
    <title>Smart Manufacturing Dashboard: Update Assigned Machines</title>
    <link rel="stylesheet" href="../WebSolution/styles/commonelements.css" />
    <link rel="stylesheet" href="../WebSolution/styles/production-operator.css" />
    <?php   
        require_once "auth/sessioncheck.php";
    ?>
    <?php require_once "auth/permissioncheck.php";
        requireRole(array('Production Operator'));
    ?>
    <style>
        .status-active {
            background-color: green;
            color: white;
        }

        .status-inactive {
            background-color: red;
            color: white;
        }

        .status-maintenance {
            background-color: yellow;
            color: black;
        }

        .status-idle {
            background-color: black;
            color: white;
        }
    </style>    
    <script src="../WebSolution/scripts/po_script.js"></script>
</head>
<body>
<?php require_once "../WebSolution/inc/dbheader.inc.php"; ?>
<?php require_once "../WebSolution/inc/dbsidebar.inc.php"; ?>

    <div id="pagetitle">
        <h1>Machine Status</h1>
    </div>

    <div id = 'db-content'>

    <div id='updatepage'>
        <form method="POST" action="">
        <div id = 'updatepage-content'>
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
                        <select name="status" id="status" required onchange="setStatusColor()">
                            <option value="">Select Status</option>
                            <option value="active" class="status-active">Active</option>
                            <option value="inactive" class="status-inactive">Inactive</option>
                            <option value="maintenance" class="status-maintenance">Maintenance</option>
                            <option value="idle" class="status-idle">Idle</option>
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
                        <label for="details">Additional Details:</label>
                        <textarea name="details" id="details" rows="4" cols="50"></textarea>
                    </li>

                    <input type="hidden" name="timestamp" id="timestamp" value="">
                    
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
                                <th>Operational Status</th>
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
                                    <td class="<?php echo 'status-' . strtolower($logEntry[2]); ?>">
                                        <?php echo htmlspecialchars($logEntry[2]); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($logEntry[3]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[4]); ?></td>
                                    <td><?php echo htmlspecialchars($logEntry[5]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No recent updates.</p>
                <?php endif; ?>
            </div>
        </div>
        </form>
    </div>
    </div>
    <footer>
        <p>@FactorieWorks Co.</p>
    </footer>
</body>
</html>
