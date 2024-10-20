<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Group 15" />
    <title>Home</title>
    <link rel="stylesheet" href="styles/commonelements.css" />
    <link rel="stylesheet" href="styles/home.css" />
    <?php
    require_once "auth/sessioncheck.php";

    require_once "dbfunctions.php";
    require_once "inc/dbconn.inc.php";
    require_once "inc/dateselect.inc.php";
    $c = $conn;
    ?>
</head>

<body>
    <?php require_once "inc/dbheader.inc.php"; ?>
    <?php require_once "inc/dbsidebar.inc.php"; ?>


    <div id='pagetitle'>
        <h1>Dashboard</h1>
    </div>

    <div id="db-content">

        <div id='db-home'>

            <table id="db-home-machine-list">
                <tr>
                    <th>Machine</th>
                    <th>Status</th>
                </tr>

                <?php

                /* 
                This graph is intended to show the average productivity for the last 3 hours.
                Ideally, it would use the current time for the graph.  However, the machines 
                do not output logs in real time, so for testing and display purposes, we use 
                the last 6 logs of the CNC machine to determine the most recent time period.
                */
                
                $time = getMostRecentTimestamps($c, 6, 'CNC Machine');

                $sql = "SELECT machine_name, operational_status
                    FROM MachineLogs
                    WHERE timestamp = ?
                    ";

                $statement = mysqli_stmt_init($c);
                mysqli_stmt_prepare($statement, $sql);

                mysqli_stmt_bind_param($statement, 's', $time[1]);
                mysqli_stmt_execute($statement);

                if ($result = mysqli_stmt_get_result($statement)) {
                    if ($rowcount = mysqli_num_rows($result) >= 1) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                        <tr>
                            <td>$row[machine_name]</td>
                            <td class = 'machine-status-$row[operational_status]'>$row[operational_status]</td>
                            <td class = 'machine-status-$row[operational_status]'><a href = 'machineview.php?machine=$row[machine_name]'><button>View</button></a></td>
                        </tr>";
                        }
                        mysqli_free_result($result);
                    }
                }
                ?>

            </table>

            <?php require_once "inc/avgproductivitygraph.inc.php"; ?>
        </div>

    </div>



    <footer>
        <p>Dashboard Footer</p>
        <?php mysqli_close($conn) ?>
    </footer>

</body>

</html>