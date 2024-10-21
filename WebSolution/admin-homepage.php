<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ryan James">
    <title>Administrator Home Page</title>
    <link rel="stylesheet" href="styles/commonelements.css" />
    <link rel="stylesheet" href="styles/adminstyle.css">
    <script src="scripts/column-sorting.js"></script>
    <?php require_once "auth/sessioncheck.php"; ?>
    <?php require_once "auth/permissioncheck.php"; 
        requireRole(array('Administrator', 'Auditor'));
    ?>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
</head>
<body>
    <div id = "pagetitle">
        <h1>Administrator View</h1>
    </div>

    <div id = "db-content">

    <div class="admin">
        
        <div class="table" id="waiting-assigned">
            <h2>Waiting</h2>
            <table id="sortedTable0">
                <tr>
                    <th onclick="sortTable(0)">Machine Name</th>
                    <th onclick="sortTable(0)">Job Number</th>
                    <th onclick="sortTable(0, true)">Received Date</th>
                    <th onclick="sortTable(0)">Submit</th>
                </tr>
                <tr>
                    <td><div class="icon-box"></div></td>
                    <td>16544</td>
                    <td>25/08/2024</td>
                    <td><div class="submit-box"></div></td>
                </tr>
                <tr>
                    <td>517</td>
                    <td>16543</td>
                    <td>25/08/2024</td>
                    <td><div class="submit-box"></div></td>
                </tr>
            </table>
        </div>

        <div class="table" id="in-progress">
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
                    <td><div class="progress-bar"></div></td>
                </tr>
                <tr>
                    <td>101</td>
                    <td>16538</td>
                    <td><div class="progress-bar"></div></td>
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
            <div class="active-users">
                <span>Active Users</span>
                <div class="user-count">3</div>
            </div>
        </div>

    </div>
    </div>

</body>
</html>