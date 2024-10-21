<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Group 15" />
    <meta name="description" content="Add-Update-Remove-Jobs" />
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="styles/jobstyle.css" />
    <script defer src="scripts/job_script.js"></script>
    <link rel="stylesheet" href="styles/commonelements.css">
    <?php
    // Check if the user has a valid session
    session_start();
    if (!isset($_SESSION['exists'])) {
        session_unset();
        session_destroy();
        header('Location: login.php');
    }

    require_once "auth/permissioncheck.php";
    requireRole(array('Factory Manager'));

    // Include the database connection
    include 'inc\dbconn.inc.php';

    // Fetch machines for the dropdown
    $machineQuery = "SELECT machine_name FROM Machines";
    $machines = $conn->query($machineQuery);
    ?>
</head>
<body>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>

        <div class="container">
        <h1>Manage Jobs</h1>
            <div class="job-form">
                <h3>Add / Edit Jobs</h3>
                <label for="job-name">Job Name:</label>
                <input type="text" id="job-name" required>

                <label for="job-duration">Job Duration (in minutes):</label>
                <input type="number" id="job-duration" required>

                <label for="machine-select">Assign to Machine:</label>
                <select id="machine-select" required>
                    <option value="">Select a Machine</option>
                    <?php while ($row = $machines->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['machine_name']); ?>">
                            <?php echo htmlspecialchars($row['machine_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button class="job-button" onclick="addJob()">Add / Edit Job</button>
            </div>
    
            <div class="jobs-table">
                <h3>Jobs</h3>
                <table id="job-table">
                    <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Job Name</th>
                            <th>Assigned Machine</th>
                            <th>Job Duration (minutes)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>