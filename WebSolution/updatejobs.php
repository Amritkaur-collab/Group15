<?php
// Include the database configuration
require_once "../WebSolution/inc/dbconn.inc.php"; // Ensure session is started in this file
require_once "../WebSolution/auth/sessioncheck.php";

// Initialize logs session variable if not set
if (!isset($_SESSION['logs'])) {
    $_SESSION['logs'] = [];
}

// Update job notes page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs and sanitize them
    $jobDescription = filter_input(INPUT_POST, "job", FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_STRING);
    $employeeId = filter_input(INPUT_POST, "employee_id", FILTER_SANITIZE_NUMBER_INT);
    $employeeName = filter_input(INPUT_POST, "employee_name", FILTER_SANITIZE_STRING);
    $logDetails = filter_input(INPUT_POST, "details", FILTER_SANITIZE_STRING);

    // Use a dash if the employee name is empty
    $employeeName = empty($employeeName) ? '-' : $employeeName;

    // Create a new log entry
    $newLogEntry = [
        date('Y-m-d H:i:s'), // Date and Time
        $jobDescription,      // Job Description
        $status,              // Status
        $employeeId,          // Employee ID
        $employeeName,        // Employee Name
        $logDetails           // Additional Details
    ];

    // Add the new log entry to the session logs
    $_SESSION['logs'][] = $newLogEntry;

    // Keep only the last 5 entries in the session logs
    if (count($_SESSION['logs']) > 5) {
        array_shift($_SESSION['logs']); // Remove the oldest log if there are more than 5
    }

    // Insert the log into the JobNotes table
    $stmt = $conn->prepare("INSERT INTO JobNotes (timestamp, job_description, status, employee_id, employee_name, additional_details) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $newLogEntry[0], $newLogEntry[1], $newLogEntry[2], $newLogEntry[3], $newLogEntry[4], $newLogEntry[5]);

    if ($stmt->execute()) {
        // Optional: handle successful insert
    } else {
        echo "Error: " . htmlspecialchars($stmt->error); // Display error if the insertion fails
    }
    
    $stmt->close(); // Close the statement

    // Optional: Redirect to prevent form re-submission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Retrieve the logs from the session
$logs = $_SESSION['logs'];

// Reverse the logs array to show the most recent updates first
$logs = array_reverse($logs);

// Fetch all logs from the database
$result = $conn->query("SELECT timestamp, job_description, status, employee_id, employee_name, additional_details FROM JobNotes ORDER BY timestamp DESC");
$databaseLogs = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard: Update Job Assignments</title>
    <link rel="stylesheet" href="../WebSolution/styles/style.css" />
    <?php   
        require_once "auth/sessioncheck.php";
        require_once "auth/permissioncheck.php";
        requireRole(array('Production Operator'));

        // Fetch all job updates from the database
        $result = $conn->query("SELECT timestamp, job_description, status, employee_id, employee_name, additional_details FROM JobNotes ORDER BY timestamp DESC");
        $jobs = $result->fetch_all(MYSQLI_ASSOC); // Fetching as associative array
    ?>
</head>
<body>
    <?php require_once "../WebSolution/inc/dbsidebar.inc.php"; ?>
    <?php require_once "../WebSolution/inc/dbheader.inc.php"; ?>

    <div id="pagetitle">
        <h1>Job Assignment</h1>
    </div>

    <div id='updatepage'>
        <form method="POST" action="">
            <div id="filters">
                <h2>Job Update</h2>
                <ul>
                    <li>
                        <label for="job">Job Description: </label>
                        <input type="text" name="job" id="job" required>
                    </li>

                    <li>
                        <label for="status">Job Status:  </label>
                        <select name="status" id="status" required>
                            <option value="">Select Status</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Waiting Parts">Waiting for Parts</option>
                            <option value="Completed">Completed</option>
                            <option value="On Hold">On Hold</option>
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

                    <li>
                        <input type="submit" id="submit" value="Update">
                    </li>
                </ul>
            </div>

            <div id="latest-machine-updates">
                <h2>Recent Job Updates</h2>
                <?php if (!empty($jobs)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date and Time</th>
                                <th>Job Description</th>
                                <th>Status</th>
                                <th>Updated By (ID)</th>
                                <th>Updated By (Name)</th>
                                <th>Additional Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jobs as $jobEntry): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($jobEntry['timestamp']); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry['job_description']); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry['status']); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry['employee_id']); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry['employee_name']); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry['additional_details']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No job updates made yet.</p>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <footer>
        <p>@FactorieWorks Co.</p>
    </footer>
</body>
</html>
