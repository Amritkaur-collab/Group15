<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ryan James">
    <title>Administrator Home Page</title>
    <link rel="stylesheet" href="styles/style.css" />
    <link rel="stylesheet" href="styles/commonelements.css" />
    <link rel="stylesheet" href="styles/adminstyle.css">
    <script src="scripts/column-sorting.js"></script>
    <script src="scripts/progress-bar.js"></script>
    <?php require_once "auth/sessioncheck.php"; ?>
    <?php require_once "auth/permissioncheck.php"; 
        requireRole(array('Administrator', 'Auditor'));
    ?>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
</head>
<body>
    <script> window.onload = updateProgressBars; </script>
    <div id = "pagetitle">
        <h1>Administrator View</h1>
    </div>

    <div class="admin">
        
        <div class="table" id="waitingAssigned">
            <h2>Waiting</h2>
            <table id="sortedTable0">
                <tr>
                    <th onclick="sortTable(0)">Machine Name<br></th>
                    <th onclick="sortTable(0)">Job Number</th>
                    <th onclick="sortTable(0)">Received Date</th>
                    <th>Submit</th>
                </tr>
                <tr>
                    <td>3D Printer</td>
                    <td>16544</td>
                    <td>25/08/2024</td>
                    <td><input type="checkbox" name="submitJob"></td>
                </tr>
                <tr>
                    <td>CNC Machine</td>
                    <td>16543</td>
                    <td>25/09/2024</td>
                    <td><input type="checkbox" name="submitJob"></td>
                </tr>
            </table>
        </div>

        <div class="table" id="inProgress">
            <h2>In Progress</h2>
            <table id="sortedTable1">
                <tr>
                    <th onclick="sortTable(1)">Operator ID</th>
                    <th onclick="sortTable(1)">Job Number</th>
                    <th onclick="sortTable(1)">Progress</th>
                </tr>
                <tr>
                    <td>321</td>
                    <td>16539</td>
                    <td>
                        <div class="progressBarContainer">
                        <div class="progressBarFill"></div>
                        <div class="progressText">100%</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>101</td>
                    <td>16538</td>
                    <td>
                        <div class="progressBarContainer">
                            <div class="progressBarFill"></div>
                            <div class="progressText">33%</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table" id="complete">
            <h2>Complete</h2>
            <table id="sortedTable2">
                <tr>
                    <th onclick="sortTable(2)">Operator ID</th>
                    <th onclick="sortTable(2)">Job Number</th>
                    <th onclick="sortTable(2, true)">Completion Date</th>
                </tr>
                <tr>
                    <td>321</td>
                    <td>16472</td>
                    <td>10/07/2024</td>
                </tr>
                <tr>
                    <td>101</td>
                    <td>16471</td>
                    <td>12/03/2024</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="activeUsers">
                <span>Active Users</span>
                <div class="userCount">1</div>
            </div>
        </div>

    </div>

</body>
</html>