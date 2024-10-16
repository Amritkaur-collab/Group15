<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Group 15" />
    <meta name="description" content="Add-Update-Remove-Jobs" />
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="styles/jobstyle.css" />
    <script defer src="scripts/fmdscript.js"></script>
    <?php
    // Check if the user has a valid session
    session_start();
    if (!isset($_SESSION['exists'])) {
        session_unset();
        session_destroy();
        header('Location: login.php');
    }

    // Include the database connection
    require_once 'C:\xampp\htdocs\Group15\WebSolution\inc\dbconn.inc.php';

    // Fetch machines for the dropdown
    $machineQuery = "SELECT machine_name FROM Machines"; // Adjusted query to fetch machine_name
    $machines = $conn->query($machineQuery);
    ?>
</head>
<body>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
    <?php require_once "inc/dbheader.inc.php"; ?>

    <h1>Manage Jobs</h1> <!-- This heading will not be included in the colored section -->

    <!-- Start of section with background color -->
    <div class="colored-section">
        <div class="container">
            <div class="machine-form">
                <h3>Add or Update Job</h3>
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

                <button class="machine-button" onclick="addJob()">Add Job</button>
            </div>
    
            <div class="jobs-table">
                <h3>Jobs</h3>
                <table id="job-table">
                    <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Job Name</th>
                            <th>Assigned Machine</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Add your JavaScript functions here (e.g., addJob, fetchJobs, updateJob, removeJob)
        // Ensure that you create corresponding PHP files to handle job operations.
    </script>
</body>
</html>