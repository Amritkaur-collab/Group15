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
// Checks if the user has a valid session and redirects them to login if not.
// Should be placed in the header of every page (except pages where we do not expect a session to exist. Eg. login.php)
session_start();
if(!isset($_SESSION['exists']))
{
    session_unset();
    session_destroy();
    header('Location: login.php');
}
?>
</head>
<body>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
    <?php require_once "inc/dbheader.inc.php"; ?>

    <h1>Manage Machines</h1> <!-- This heading will not be included in the colored section -->

<!-- Start of section with background color -->
<div class="colored-section">
    <div class="container">
        <div class="machine-form">
            <h3>Add or Update Machine</h3>
            <label for="machine-name">Machine Name:</label>
            <input type="text" id="machine-name" required>
            
            <label for="machine-location">Location:</label>
            <input type="text" id="machine-location" required>
        
            <label for="machine-date">Date Acquired:</label>
            <input type="date" id="machine-date" required>
            
            <label for="machine-serial">Serial Number:</label>
            <input type="text" id="machine-serial" required>
        
            <button class="machine-button" onclick="addMachine()">Add Machine</button>
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
</body>
</html>