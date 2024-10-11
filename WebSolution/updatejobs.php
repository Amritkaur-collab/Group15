<?php
session_start();

// Initialize jobs session variable if not set
if (!isset($_SESSION['jobs'])) {
    $_SESSION['jobs'] = [];
}

// Update job assignments page
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $job = filter_input(INPUT_POST, "job");
    $status = filter_input(INPUT_POST, "status");
    $employeeId = filter_input(INPUT_POST, "employee_id");
    $employeeName = filter_input(INPUT_POST, "employee_name");
    $details = filter_input(INPUT_POST, "details");

    // Use a dash if the employee name is empty
    $employeeName = empty($employeeName) ? '-' : $employeeName;

    // Create a new job entry with all fields
    $newJobEntry = [
        date('Y-m-d H:i:s'), // Date and Time
        $job,                // Job Description
        $status,             // Job Status
        $employeeId,         // Employee ID
        $employeeName,       // Employee Name
        $details             // Additional Details
    ];

    // Add the new job entry to the session jobs
    $_SESSION['jobs'][] = $newJobEntry;

    // Keep only the last 5 entries
    if (count($_SESSION['jobs']) > 5) {
        array_shift($_SESSION['jobs']); // Remove the oldest job if there are more than 5
    }

    // Append the new job entry to the CSV file (optional)
    $csvFile = 'C:\xampp\htdocs\www\web soln\Group15\WebSolution\job_assignments.csv';
    if (($handle = fopen($csvFile, "a")) !== false) {
        fputcsv($handle, $newJobEntry);
        fclose($handle);
    } else {
        echo "Error updating job assignment.";
    }

    // Optional: Redirect to prevent form re-submission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Retrieve the jobs from the session
$jobs = $_SESSION['jobs'];

// Reverse the jobs array to show the most recent updates first
$jobs = array_reverse($jobs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Manufacturing Dashboard: Update Job Assignments</title>
    <link rel="stylesheet" href="../updatejobs/updatejobs.css" /> <!-- Use the same CSS file -->
</head>
<body>
    <?php require_once "../inc/dbsidebar.inc.php"; ?>
    <?php require_once "../inc/dbheader.inc.php"; ?>

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

            <div id="latest-job-updates">
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
                                    <td><?php echo htmlspecialchars($jobEntry[0]); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry[1]); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry[2]); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry[3]); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry[4]); ?></td>
                                    <td><?php echo htmlspecialchars($jobEntry[5]); ?></td>
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
