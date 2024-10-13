<?php
session_start();

// Initialize task notes session variable if not set
if (!isset($_SESSION['task_notes'])) {
    $_SESSION['task_notes'] = [];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $machine = filter_input(INPUT_POST, "machine");
    $taskNote = filter_input(INPUT_POST, "task_note");
    $employeeId = filter_input(INPUT_POST, "employee_id");
    $employeeName = filter_input(INPUT_POST, "employee_name");

    // Use a dash if the employee name is empty
    $employeeName = empty($employeeName) ? '-' : $employeeName;

    // Create a new task note entry
    $newTaskNoteEntry = [
        date('Y-m-d H:i:s'), // Date and Time
        $machine,            // Machine
        $taskNote,           // Task Note
        $employeeId,         // Employee ID
        $employeeName        // Employee Name
    ];

    // Add the new task note entry to the session task notes
    $_SESSION['task_notes'][] = $newTaskNoteEntry;

    // Keep only the last 5 entries
    if (count($_SESSION['task_notes']) > 5) {
        array_shift($_SESSION['task_notes']); // Remove the oldest task note if more than 5
    }

    // Append the new task note entry to a CSV file (optional)
    $csvFile = 'task_notes.csv';
    if (($handle = fopen($csvFile, "a")) !== false) {
        fputcsv($handle, $newTaskNoteEntry);
        fclose($handle);
    } else {
        echo "Error updating task notes.";
    }

    // Prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Retrieve the task notes from the session
$taskNotes = $_SESSION['task_notes'];

// Reverse the task notes array to show the most recent updates first
$taskNotes = array_reverse($taskNotes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard: Task Notes</title>
    <link rel="stylesheet" href="../updatejobs/updatejobs.css" /> <!-- Use the same CSS as updatejobs -->
</head>
<body>
    <?php require_once "../inc/dbsidebar.inc.php"; ?>
    <?php require_once "../inc/dbheader.inc.php"; ?>

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
                        <label for="employee_id">Updated By (ID):</label>
                        <input type="number" name="employee_id" id="employee_id" required>
                    </li>

                    <li>
                        <label for="employee_name">Updated By (Name):</label>
                        <input type="text" name="employee_name" id="employee_name" required>
                    </li>

                    <li>
                        <input type="submit" id="submit" value="Submit Task Note">
                    </li>
                </ul>
            </div>

            <div id="latest-job-updates">
                <h2>Recent Task Notes</h2>
                <?php if (!empty($taskNotes)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Machine</th>
                                <th>Task Note</th>
                                <th>Updated By (ID)</th>
                                <th>Updated By (Name)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($taskNotes as $taskNoteEntry): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($taskNoteEntry[0]); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry[1]); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry[2]); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry[3]); ?></td>
                                    <td><?php echo htmlspecialchars($taskNoteEntry[4]); ?></td>
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
</body>
</html>
