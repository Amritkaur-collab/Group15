<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css" />
    <title>Document</title>
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


    <?php


    $machine = $_GET['machine'];

    $c = $conn;
    $timestamps = getMostRecentTimestamps($c, 16, $machine);

    $status = getMachineLogValue('operational_status', $timestamps[1], $machine, $c);
    ?>

    <div id="pagetitle">
        <h1><?php echo $machine ?></h1>
    </div>

    <div id="db-content">
        <div id="machine-view-window">

            <h2>Status - <?php echo $status ?></h2>

            <div class='machine-view-graph-column'>

                <div class='machine-view-graph'>
                    <label>Production Count</label>
                    <canvas id="db-machine-view-productivity" width="600" height="200"></canvas>
                </div>


                <div class='machine-view-graph'>
                    <label>Power Consumption</label>
                    <canvas id="db-machine-view-powerconsumption" width="600" height="200"></canvas>
                </div>


                <div class='machine-view-graph'>
                    <label>Temperature</label>
                    <canvas id="db-machine-view-temp" width="600" height="200"></canvas>
                </div>

            </div>

            <div class='machine-view-graph-column'>

                <div class='machine-view-graph'>
                    <label>Humidity</label>
                    <canvas id="db-machine-view-humidity" width="600" height="200"></canvas>
                </div>


                <div class='machine-view-graph'>
                    <label>Vibration</label>
                    <canvas id="db-machine-view-vibration" width="600" height="200"></canvas>
                </div>

                <div class='machine-view-graph'>
                    <label>Speed</label>
                    <canvas id="db-machine-view-speed" width="600" height="200"></canvas>
                </div>

            </div>

            <div class='machine-view-table-column'>
                <div id = 'machine-view-log-table'>
                <table>
                    <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>Error Code</th>
                        <th>Maintenance Log</th>
                    </tr>
                    </thead>

                    <tbody>

                <?php
                $params = array($machine);
            
                $sql = "SELECT * FROM MachineLogs  WHERE machine_name = ? AND error_code IS NOT NULL AND error_code != '' ORDER BY timestamp desc";
            
                $statement = mysqli_stmt_init($c);
                mysqli_stmt_prepare($statement, $sql);
            
                mysqli_stmt_bind_param($statement, 's', ...$params);
                mysqli_stmt_execute($statement);
            
                if ($result = mysqli_stmt_get_result($statement)) {
                    if (mysqli_num_rows($result) >= 1) 
                    {
                        while ($value = mysqli_fetch_assoc($result)) 
                        {
                            echo '
                            <tr>
                                <td>'.$value['timestamp'].'</td>
                                <td>'.$value['error_code'].'</td>
                                <td>'.$value['maintenance_log'].'</td>
                            ';
                        }
                        mysqli_free_result($result);
                    }
                }


                ?>
                    </tbody>

                </table>

                </div>
                <div id = 'machine-view-job-table'>


                <table>
                    <thead>
                    <tr>
                        <th>Job ID</th>
                        <th>Description</th>
                        <th>Assigned Operator</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>

            </table>
                </div>
                </div>



            <script type="module">
                import {
                    drawLineGraph
                } from "./scripts/dbgraph.js";
                <?php
                createGraph("db-machine-view-productivity", 'blue', 'production_count', $timestamps[0], $timestamps[1], $machine, $c);
                createGraph("db-machine-view-powerconsumption", 'green', 'power_consumption', $timestamps[0], $timestamps[1], $machine, $c);
                createGraph("db-machine-view-temp", 'green', 'temperature', $timestamps[0], $timestamps[1], $machine, $c);
                createGraph("db-machine-view-humidity", 'green', 'humidity', $timestamps[0], $timestamps[1], $machine, $c);
                createGraph("db-machine-view-vibration", 'green', 'vibration', $timestamps[0], $timestamps[1], $machine, $c);
                createGraph("db-machine-view-speed", 'green', 'speed', $timestamps[0], $timestamps[1], $machine, $c);
                ?>
            </script>
        </div>
    </div>

    <footer>
        <p>Dashboard Footer</p>
        <?php mysqli_close($conn) ?>
    </footer>

</body>

</html>