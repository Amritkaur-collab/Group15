<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
    require_once "dbfunctions.php";
    require_once "inc/dbconn.inc.php";
    $c = $conn;
    ?>

</head>

<body>

    <h1>CNC Machine</h1>

    <?php
        $machine = 'CNC Machine';
        $timestamps = getMostRecentTimestamps($c, 6, $machine);
        echo '<p>Status: ';
        echo getMachineLogValue('operational_status', $timestamps[1], $machine, $c);
        echo '</p>';
    ?>

    <div>
        <h2>Production Count</h2>
        <canvas id="productionCount" width="600" height="200" style="border: 1px black solid;"></canvas>
    </div>

    <div>
        <h2>Temperature</h2>
        <canvas id="temperature" width="600" height="200" style="border: 1px black solid;"></canvas>
    </div>

    <div>
        <h2>Speed</h2>
        <canvas id="speed" width="600" height="200" style="border: 1px black solid;"></canvas>
    </div>


    <footer><?php mysqli_close($conn)?></footer>
</body>

</html>