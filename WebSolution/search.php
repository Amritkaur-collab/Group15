<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Manufacturing Dashboard: Advanced Search</title>
    <link rel="stylesheet" href="styles/style.css" />
    <?php require_once "auth/sessioncheck.php";?>
    <?php require_once "auth/permissioncheck.php";
        requireRole(array('Administrator', 'Auditor'));
    ?>
</head>
<body>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>
    
    <?php require_once "inc/dateselect.inc.php"; ?>

    <div id = "pagetitle">
        <h1>Advanced Search</h1>
    </div>

    <div id = 'searchpage'>

    <div id = "filters">
        <form action="" method="POST">
        <h2>Filters</h2>
        <ul>
            <li><h3>Date & Time</h3></li>
            <?php
            $timefrom = ""; if(isset($_POST["timefrom"])) $timefrom = $_POST["timefrom"]; 
            $timeto = ""; if(isset($_POST["timeto"])) $timeto = $_POST["timeto"]; 
            $errorcode = ""; if(isset($_POST["error-code"])) $errorcode = $_POST["error-code"]; 
            $status = ""; if(isset($_POST["operational-status"])) $status = $_POST["operational-status"]; 
            
            echo "<li>";
            echo "<label>From:</label><div id = 'dts-input'><input id = \"timefrom\" type=\"text\" name = \"timefrom\" required value = \"$timefrom\"/><button id = \"timefrom-open\" type =\"button\" onclick=\"buttonDTS('timefrom')\">O</button></div><br/>";
            echo "</li>";
            echo "<li>";
            echo "<label>To:</label><div id = 'dts-input'><input id = \"timeto\" type=\"text\" name = \"timeto\" required value = \"$timeto\"/><button id = \"timeto-open\" type =\"button\" onclick=\"buttonDTS('timeto')\">O</button></div><br/>";
            echo "</li>";
            echo"<br/><br/>";
            echo "<li>";
            echo "<label>Error Code:</label><input type=\"text\" name = \"error-code\" value = \"$errorcode\"/><br/>";
            echo "</li>";
            echo "<li>";
            echo "<label>Status:</label><input type=\"text\" name = \"operational-status\" value = \"$status\"/>";
            echo "</li>";
            echo"<br/><br/>";
            echo "<li>";
            echo "<h3>Machines</h3>";

            require_once "search/machines.search.php"; 
            echo "</li>";
            ?>
            
            <br/>
            <input id ="submit" type = "submit" value = "Apply">
        </ul>
        </form>
    </div>

    <div id = "results-table">
        <table>
            <tr id = "tb-header">
                <th>Timestamp</th>
                <th>Machine</th>
                <th>Temperature</th>
                <th>Pressure</th>
                <th>Vibration</th>
                <th>Humidity</th>
                <th>Power Consumption</th>
                <th>Operational Status</th>
                <th>Error Code</th>
                <th>Production Count</th>
                <th>Maintenance Log</th>
                <th>Speed</th>
            </tr>
            <?php require_once "search/results.search.php"; ?>
        </table>
    </div>
    </div>
    <footer>
        <p>Dashboard Footer</p>
    </footer>
</body>
</html>