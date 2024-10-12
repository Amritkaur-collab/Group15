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
    session_start();
    $_SESSION['connection'] = $c;
    ?>

</head>

<body>

    <h1>CNC Machine</h1>

    <!-- This is the worst thing I have ever written -->
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

    
    
    
    
    
    
    
    
    
    
    <script type="module">
        import {
            drawLineGraph
        } from "./scripts/dbgraph.js";

        <?php 
        $tf = '2024/04/01 1:00';
        $tt = '2024/04/01 7:00';

        createGraph('productionCount', 'blue', 'production_count', $tf, $tt, 'CNC Machine', $c);
        createGraph('temperature', 'red', 'temperature', $tf, $tt, 'CNC Machine', $c);
        createGraph('speed', 'green', 'speed', $tf, $tt, 'CNC Machine', $c);
        
        
        
        
        ?>

    </script>


    <footer><?php mysqli_close($conn) ?></footer>
</body>

</html>