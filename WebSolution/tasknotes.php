<?php
require_once "../WebSolution/inc/dbconn.inc.php"; 
require_once "../WebSolution/auth/sessioncheck.php";

if (!isset($_SESSION['logs'])) {
    $_SESSION['logs'] = [];
}

$emailSent = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $machine = filter_input(INPUT_POST, "machine", FILTER_SANITIZE_STRING);
    $taskNote = filter_input(INPUT_POST, "task_note", FILTER_SANITIZE_STRING);
    $employeeId = filter_input(INPUT_POST, "employee_id", FILTER_VALIDATE_INT);
    $employeeName = filter_input(INPUT_POST, "employee_name", FILTER_SANITIZE_STRING);

    $employeeName = empty($employeeName) ? '-' : $employeeName;

    $stmt = $conn->prepare("INSERT INTO TaskNotes (timestamp, machine_name, task_note, employee_id, employee_name) VALUES (CURRENT_TIMESTAMP, ?, ?, ?, ?)");
    $stmt->bind_param("ssis", $machine, $taskNote, $employeeId, $employeeName);
    $stmt->execute();
    $stmt->close();

    
    $to = "factorymanager@example.com"; 
    $subject = "New Task Note Submitted for $machine";
    $message = "A new task note has been submitted:\n\n"
        . "Machine: $machine\n"
        . "Task Note: $taskNote\n"
        . "Updated By (ID): $employeeId\n"
        . "Updated By (Name): $employeeName\n"
        . "Timestamp: " . date("Y-m-d H:i:s") . "\n";

    
    $mailto = "mailto:$to?subject=" . urlencode($subject) . "&body=" . urlencode($message);
    $emailSent = true; 

    
    header("Location: " . $_SERVER['PHP_SELF'] . "?mailto=" . urlencode($mailto));
    exit();
}

$result = $conn->query("SELECT timestamp, machine_name, task_note, employee_id, employee_name FROM TaskNotes ORDER BY timestamp DESC LIMIT 5");

$taskNotes = [];
while ($row = $result->fetch_assoc()) {
    $taskNotes[] = $row;
}

$taskNotes = array_reverse($taskNotes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard: Task Notes</title>
    <link rel="stylesheet" href="../WebSolution/styles/style.css" /> 
    <?php require_once "auth/sessioncheck.php"; ?>
    <?php require_once "auth/permissioncheck.php"; 
    requireRole(array('Production Operator')); ?>
</head>
<body>
    <?php require_once "../WebSolution/inc/dbheader.inc.php"; ?>
    <?php require_once "../WebSolution/inc/dbsidebar.inc.php"; ?>

    <div id="pagetitle">
        <h1>Task Notes</h1>
    </div>

    <div id='updatepage'>
        <form method="POST" action="">
            <div id="filters">
                <h2>Task Note Update</h2>
                <ul>
                    <li>
                        <label for="machine">Select Machine: </label>
                        <select name="machine" id="machine" required>
                            <option value="">Select Machine</option>
                            <option value="3D Printer">3D Printer</option>
                            <option value="CNC Machine">CNC Machine</option>
                            <option value="Industrial Robot">Industrial Robot</option>
                            <option value="Automated Guided Vehicle (AGV)">AGV</option>
                            <option value="Smart Conveyor System">Smart Conveyor System</option>
                            <option value="IoT Sensor Hub">IoT Sensor Hub</option>
                            <option value="Predictive Maintenance System">Predictive Maintenance System</option>
                            <option value="Automated Assembly Line">Automated Assembly Line</option>
                            <option value="Quality Control Scanner">Quality Control Scanner</option>
                            <option value="Energy Management System">Energy Management System</option>
                        </select>
                    </li>

                    <li>
                        <label for="task_note">Task Note: </label>
                        <textarea name="task_note" id="task_note" rows="4" cols="50" required></textarea>
                    </li>

                    <li>
                        <label for="employee_id">Written  By (ID):</label>
                        <input type="number" name="employee_id" id="employee_id" required>
                    </li>

                    <li>
                        <label for="employee_name">Written for (Name):</label>
                        <input type="text" name="employee_name" id="employee_name" required>
                    </li>

                    <li>
                        <input type="submit" id="submit" value="Submit Task Note">
                    </li>
                </ul>
            </div>

            <div id="latest-machine-updates">
                <h2>Recent Task Notes</h2>
                <?php if (!empty($taskNotes)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Machine</th>
                                <th>Task Note</th>
                                <th>Written By (ID)</th>
                                <th>Written for (Name)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($taskNotes as $taskNoteEntry): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($taskNoteEntry['timestamp']); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry['machine_name']); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry['task_note']); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry['employee_id']); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry['employee_name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No task notes created yet.</p>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <footer>
        <p>@FactorieWorks Co.</p>
    </footer>

    <?php if (isset($_GET['mailto'])): ?>
        <script>
            window.open("<?php echo htmlspecialchars($_GET['mailto']); ?>");
        </script>
    <?php endif; ?>
</body>
</html>
